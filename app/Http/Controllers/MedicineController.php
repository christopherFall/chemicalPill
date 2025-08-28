<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\MedicineRequest;

class MedicineController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $medicines = Medicine::latest()->get();
            return response()->json(['medicines' => $medicines]);
        }

        $medicines = Medicine::all();
        return view('medicines.index', compact('medicines')); //función compact crea array asociativo
    }

    // NOT THIS CASE
    public function create()
    {
        return view('medicines.create');
    }


    public function store(MedicineRequest $request)
    {
        $medicine = Medicine::create($request->validated());
        return response()->json(['message' => 'ok', 'medicine' => $medicine], 201);
    }


    public function show(string $id)
    {
        $medicine = Medicine::findorFail($id);
        return response()->json(["medicine" => $medicine]);
    }

    // NOT THIS CASE
    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }


    public function update(MedicineRequest $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->validated());
        return response()->json(["success" => $medicine]);
    }


    public function destroy(string $id)
    {
       $medicine = Medicine::findorFail($id);
       $medicine->delete();
       return response()->json(["success" => "The medicine has been deleted succesfully"]);
    }
}
