<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rates;
use Inertia\Inertia;

class RatesController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = Rates::paginate(10);
        return Inertia::render('Rates/Index', [
            'attr' => [
                'title' => 'Tarif Parkir',
                'route_create' => route('rates.create'),
                'models' => $models,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Rates/Create', [
            'attr' => [
                'form_type' => 'POST',
                'title' => 'Tambah Tarif Parkir',
                'model' => [],
                'route_url' => route('rates.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        if(Rates::create($request->only(['name', 'hourly_rate']))) {
            return redirect()->route('rates.index')
                ->with('success', 'Tarif Parkir berhasil ditambahkan.');
        }

        return redirect()->route('rates.index')
                ->with('warnings', 'Tarif Parkir gagal ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rates $rate)
    {
        return Inertia::render('Rates/Create', [
            'attr' => [
                'form_type' => 'PUT',
                'title' => 'Edit Tarif Parkir',
                'model' => $rate,
                'route_url' => route('rates.update', $rate->id),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rates $rate)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        if($rate->update($request->only(['name', 'hourly_rate']))) {
            return redirect()->route('rates.index')
                ->with('success', 'Tarif Parkir berhasil diupdate.');
        }

        return redirect()->route('rates.index')
                ->with('warnings', 'Tarif Parkir gagal diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rates $rate)
    {
        if($rate->delete()) {
            return redirect()->route('rates.index')
                ->with('success', 'Tarif Parkir berhasil dihapus.');
        }

        return redirect()->route('rates.index')
                ->with('warnings', 'Tarif Parkir gagal dihapus.');
    }
}
