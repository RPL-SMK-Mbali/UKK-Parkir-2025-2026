<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ParkingArea;
use App\Models\Transaction;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = ParkingArea::with(['rate'])->paginate(10);
        return Inertia::render('Transaction/Index', [
            'attr' => [
                'title' => 'Area Parkir',
                'route_create' => route('parking_areas.create'),
                'models' => $models,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ParkingArea $transaction)
    {
        $area_type = $request->query('area_type', 'in');

        if(!in_array($area_type, ['in', 'out'])) {
            abort(404);
        }

        $transactions = Transaction::with(['parking_area'])
            ->where('parking_area_id', $transaction->id)
            ->limit(10)
            ->get();

        $label = $area_type == 'in' ? 'Masuk' : 'Keluar';
        $transaction->load(['rate']);
        return Inertia::render('Transaction/Create', [
            'attr' => [
                'form_type' => 'PUT',
                'title' => "Area Parkir ({$label}) {$transaction->name}",
                'area_type' => $area_type,
                'model' => $transaction,
                'models' => $transactions,
                'route_url' => route('transactions.update', $transaction->id),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParkingArea $transaction)
    {
        $transaction->load(['rate']);
        
        $validated = $request->validate([
            'area_type' => ['required', 'in:in,out'],
            'vehicle_id' => ['required', 'string', 'max:15'],
        ], [], [
            'area_type' => 'Pintu Masuk / Keluar',
            'vehicle_id' => 'Plat Nomor Kendaraan',
        ]);

        $validated['parking_area_id'] = $transaction->id;
        $validated['hourly_rate'] = $transaction->rate->hourly_rate;

        if($transaction = Transaction::createWebapp($validated)) {
            if($transaction) {
                if($transaction->status == true) {
                    return redirect()->back()->with('success', 'Transaksi Berhasil');
                } else {
                    return redirect()->back()->withErrors($transaction->message);
                }
            }
        }

        return redirect()->back()->with('warning', 'Transaksi Gagal');
    }



}
