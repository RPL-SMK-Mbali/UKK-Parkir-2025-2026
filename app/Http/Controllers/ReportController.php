<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;
use Inertia\Inertia;
use Carbon\Carbon;

class ReportController extends Controller
{
    private $start;
    private $end;

    public function __construct()
    {
        $this->start = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Report/Index', [
            'attr' => [
                'title' => 'Laporan Transaksi',
                'reports' => route('reports.pdf'),
                'start' => $this->start,
                'end' => $this->end
            ]
        ]);
    }

    public function pdf(Request $request) {
        $models = Transaction::with(['parking_area'])
            ->whereBetween('created_at', [$this->start, $this->end])
            ->get();

        // dd($models->toArray());
        $pdf = Pdf::loadView('pdf.transaction', [
            'transactions' => $models
        ]);
        return $pdf->stream('transaction.pdf');
    }
}
