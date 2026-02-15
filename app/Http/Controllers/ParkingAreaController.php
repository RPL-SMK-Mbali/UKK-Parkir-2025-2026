<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ParkingArea;
use App\Models\Rates;
use Inertia\Inertia;

class ParkingAreaController extends Controller
{
    private $types;
    private $rates;

    public function __construct()
    {
        $this->types = [
            ['id' => '', 'name' => 'Pilih Tipe'],
            ['id' => 'private', 'name' => 'Area Parkir Privat'],
            ['id' => 'public', 'name' => 'Area Parkir Publik'],
        ];

        $rastes = Rates::get()->toArray();
        $this->rates = array_merge([['id' => '', 'name' => 'Pilih Tipe']], $rastes);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $models = ParkingArea::with(['rate'])->paginate(10);
        return Inertia::render('ParkingArea/Index', [
            'attr' => [
                'title' => 'Area Parkir',
                'route_create' => route('parking_areas.create'),
                'models' => $models,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('ParkingArea/Create', [
            'attr' => [
                'form_type' => 'POST',
                'title' => 'Tambah Area Parkir',
                'rates' => $this->rates,
                'types' => $this->types,
                'model' => [],
                'route_url' => route('parking_areas.store'),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rate_id' => ['required', Rule::exists('rates', 'id')],
            'name' => ['required', 'max:255', 'unique:parking_areas,name'],
            'capacity' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:private,public'],
        ],[],
        [
            'name' => 'Nama Area Parkir',
            'capacity' => 'Kapasitas Area Parkir',
            'type' => 'Tipe Area Parkir',
        ]);

        if(ParkingArea::create($validated)) {
            return redirect()->route('parking_areas.index')
                ->with('success', 'Area Parkir berhasil ditambahkan.');
        }

        return redirect()->route('parking_areas.index')
                ->with('warnings', 'Area Parkir gagal ditambahkan.');
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
    public function edit(ParkingArea $parking_area)
    {
        return Inertia::render('ParkingArea/Create', [
            'attr' => [
                'form_type' => 'PUT',
                'title' => 'Edit Area Parkir',
                'rates' => $this->rates,
                'types' => $this->types,
                'model' => $parking_area,
                'route_url' => route('parking_areas.update', $parking_area->id),
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParkingArea $parking_area)
    {
        $validated = $request->validate([
            'rate_id' => ['required', Rule::exists('rates', 'id')],
            'name' => [
                'required',
                'max:255',
                Rule::unique('parking_areas', 'name')->ignore($parking_area->id),
            ],
            'capacity' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:private,public'],
        ], [], [
            'name' => 'Nama Area Parkir',
            'capacity' => 'Kapasitas Area Parkir',
            'type' => 'Tipe Area Parkir',
        ]);

        if($parking_area->update($validated)) {
            return redirect()->route('parking_areas.index')
                ->with('success', 'Area Parkir berhasil diupdate.');
        }

        return redirect()->route('parking_areas.index')
                ->with('warnings', 'Area Parkir gagal diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParkingArea $parking_area)
    {
        if($parking_area->delete()) {
            return redirect()->route('parking_areas.index')
                ->with('success', 'Area Parkir berhasil dihapus.');
        }

        return redirect()->route('parking_areas.index')
                ->with('warnings', 'Area Parkir gagal dihapus.');
    }
}
