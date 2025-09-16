<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MedicineRequest;
use App\UseCases\Contracts\{
    CreateEntityUseCaseInterface,
    GetAllEntitiesUseCaseInterface,
    ShowEntityUseCaseInterface,
    UpdateEntityUseCaseInterface,
    DeleteEntityUseCaseInterface
};

class MedicineController extends Controller
{
    public function __construct(
        private GetAllEntitiesUseCaseInterface $getAll,
        private CreateEntityUseCaseInterface $create,
        private ShowEntityUseCaseInterface $showOne,
        private UpdateEntityUseCaseInterface $updateOne,
        private DeleteEntityUseCaseInterface $deleteOne,
    ) {}

    public function index(Request $request)
    {
        $medicines = $this->getAll->execute();

        if ($request->ajax()) {
            return response()->json(['medicines' => $medicines]);
        }

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
        return response()->json(["success" => "The medicine has been deleted successfully"]);
    }
}
