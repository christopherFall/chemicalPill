<?php

namespace App\UseCases\Contracts;

use App\Models\Medicine;

interface UpdateMedicineUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id, array $data): Medicine;
}
