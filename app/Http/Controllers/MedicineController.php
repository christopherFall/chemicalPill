<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

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


    public function create()
    {
        return view('medicines.create');
    }


    public function store(Request $request)
    {

        $data = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'subtype' => 'required|string|max:255',
        'side_effects' => 'required|string',
        ]);

        $medicine = Medicine::create($data);

        return response()->json(['message' => 'ok', 'medicine' => $medicine], 201);

    }


    public function show(string $id)
    {
        $medicine = Medicine::find($id);
        return response()->json(["medicine" => $medicine]);
    }


    public function edit(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }


    public function update(Request $request, string $id)
    {
        $data = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'subtype' => 'required|string|max:255',
        'side_effects' => 'required|string',
        ]);

        $medicine = Medicine::find($id);

        $medicine->name = $request->name;
        $medicine->type = $request->type;
        $medicine->subtype = $request->subtype;
        $medicine->side_effects = $request->side_effects;
        $medicine->save();


        return response()->json(["success" =>$medicine]);
    }


    public function destroy(string $id)
    {
       $medicine = Medicine::find($id);
       $medicine->delete();
       return response()->json(["success" => 1]);
    }
}
