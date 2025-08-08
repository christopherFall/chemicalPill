<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{

    public function index()
    {
        $medicines = Medicine::all();
        return view('medicines.index', compact('medicines')); //función compact crea array asociativo
    }


    public function create()
    {
        return view('medicines.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'subtype' => 'nullable|string|max:255',
            'side_effects' => 'nullable|string|max:1000',
        ]);

        Medicine::create($request->all());

        return redirect()->route('medicines.index');

    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'subtype' => 'nullable|string|max:255',
            'side_effects' => 'nullable|string|max:1000',
        ]);

        $medicine = Medicine::findOrFail($id);

        $medicine->update($request->all());

        return redirect()->route('medicines.index');
    }


    public function destroy(string $id)
    {
       $medicine = Medicine::findOrFail($id);
       $medicine->delete();
       return redirect()->route('medicines.index');
    }
}
