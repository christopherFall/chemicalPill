<?php

namespace App\Repositories\Contracts;

use App\Models\Medicine;
use Illuminate\Support\Collection;

interface MedicineRepositoryInterface
{
    /** @return Collection<int, Medicine> */
    public function allLatest(): Collection;

    public function create(array $data): Medicine;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function findById(int $id): Medicine;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function update(int $id, array $data): Medicine;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function delete(int $id): bool;
}
