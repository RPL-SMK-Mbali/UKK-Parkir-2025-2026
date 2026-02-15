<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class Transaction extends Model
{
    protected $fillable = [
        'parking_area_id',
        'vehicle_id',
        'date_in',
        'date_out',
        'minutes_duration',
        'amount',
    ];

    public $timestamps = true;

    public $incrementing = true;

    protected $hidden = [];

    protected $appends = [
        'amountAt'
    ];

    public function parking_area() {
        return $this->belongsTo(ParkingArea::class, 'parking_area_id', 'id');
    }

    public function getAmountAtAttribute() {
        try {
            return number_format($this->amount, 0, ',', '.');
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function createWebapp($request) {
        $data = $request;
        $user = Auth::user();
        if($data['area_type'] == 'in') {
            $check_transaction = Transaction::where('vehicle_id', $data['vehicle_id'])
                ->whereNull('date_out')
                ->first();

            if($check_transaction) {
                return (object) [
                    'status' => false,
                    'message' => [
                        'vehicle_id' => ["Nomor Kendaraan : {$data['vehicle_id']} Terdapat Transaksi Masuk Sebelumnya, Silahkan Lakukan Transaksi Keluar Terlebih Dahulu"],
                    ],
                ];
            } else {
                $create = Transaction::create([
                    'parking_area_id' => $data['parking_area_id'],
                    'vehicle_id' => $data['vehicle_id'],
                    'date_in' => Carbon::now(),
                    'amount' => (int) $data['hourly_rate'],
                ]);
                $create->fresh();
                if($create) {
                    TransactionLog::create([
                        'user_id' => $user->id,
                        'transaction_id' => $create->id,
                        'activities' => 'Parkir Masuk',
                    ]);
                }

                return (object) [
                    'status' => true,
                    'message' => [],
                ];
            }

        }

        if($data['area_type'] == 'out') {
             $check_transaction = Transaction::where('vehicle_id', $data['vehicle_id'])
                ->whereNull('date_out')
                ->first();
                
            if($check_transaction) {
                $date_id = Carbon::parse($check_transaction->date_in);
                $date_out = Carbon::now();
                $minutesDuration = $date_id->diffInMinutes($date_out);
                $hourlyRate = (int) $data['hourly_rate'];

                if ($minutesDuration <= 60) {
                    // Kurang dari 1 jam: hitung normal per menit
                    $amount = $hourlyRate;
                } else {
                    // Lebih dari/sama dengan 1 jam: hitung proporsional per menit
                    $amount = ($hourlyRate / 60) * $minutesDuration;
                }

                $check_transaction->update([
                    'date_out' => $date_out,
                    'minutes_duration' => (int) $minutesDuration,
                    'amount' => ceil($amount / 500) * 500,
                ]);

                $check_transaction->fresh();
                TransactionLog::create([
                    'user_id' => $user->id,
                    'transaction_id' => $check_transaction->id,
                    'activities' => 'Parkir Keluar',
                ]);
                return (object) [
                    'status' => true,
                    'message' => [],
                ];
            } else {
                return (object) [
                    'status' => false,
                    'message' => [
                        'vehicle_id' => ["Nomor Kendaraan : {$data['vehicle_id']} Tidak Terdapat Transaksi Masuk Sebelumnya, Silahkan Lakukan Transaksi Masuk Terlebih Dahulu"],
                    ],
                ];
            }
        }
    }
}
