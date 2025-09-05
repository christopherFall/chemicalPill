<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MedicineRequest;
use App\UseCases\Contracts\{
    CreateMedicineUseCaseInterface,
    GetAllMedicinesUseCaseInterface,
    ShowMedicineUseCaseInterface,
    UpdateMedicineUseCaseInterface,
    DeleteMedicineUseCaseInterface
};

class MedicineController extends Controller
{
    public function __construct(
        private GetAllMedicinesUseCaseInterface $getAll,
        private CreateMedicineUseCaseInterface $create,
        private ShowMedicineUseCaseInterface $showOne,
        private UpdateMedicineUseCaseInterface $updateOne,
        private DeleteMedicineUseCaseInterface $deleteOne,
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $medicines = $this->getAll->execute();
            return response()->json(['medicines' => $medicines]);
        }

        // (tu vista no usa $medicines, pero si quieres mantenerla:)
        // Verificar el vinculo con la vista blade
        $medicines = $this->getAll->execute();
        return view('medicines.index', compact('medicines'));
    }

    public function store(MedicineRequest $request)
    {
        $medicine = $this->create->execute($request->validated());
        return response()->json(['message' => 'ok', 'medicine' => $medicine], 201);
    }

    public function show(string $id)
    {
        $medicine = $this->showOne->execute((int) $id);
        return response()->json(["medicine" => $medicine]);
    }

    public function update(MedicineRequest $request, string $id)
    {
        $medicine = $this->updateOne->execute((int) $id, $request->validated());
        return response()->json(["success" => $medicine]);
    }

    public function destroy(string $id)
    {
        $this->deleteOne->execute((int) $id);
        return response()->json(["success" => "The medicine has been deleted succesfully"]);
    }
}
