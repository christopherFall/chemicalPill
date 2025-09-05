<?php

namespace App\UseCases\Contracts;

interface DeleteMedicineUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id): bool;
}
