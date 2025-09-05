<?php

namespace App\Repositories\Modules;

use App\Models\Medicine;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\MedicineRepositoryInterface;

class EloquentMedicineRepository implements MedicineRepositoryInterface
{
    public function allLatest(): Collection
    {
        return Medicine::query()->latest()->get();
    }

    public function create(array $data): Medicine
    {
        return Medicine::create($data);
    }

    public function findById(int $id): Medicine
    {
        return Medicine::findOrFail($id);
    }

    public function update(int $id, array $data): Medicine
    {
        $medicine = $this->findById($id);
        $medicine->update($data);
        return $medicine;
    }

    public function delete(int $id): bool
    {
        $medicine = $this->findById($id);
        return (bool) $medicine->delete();
    }
}
