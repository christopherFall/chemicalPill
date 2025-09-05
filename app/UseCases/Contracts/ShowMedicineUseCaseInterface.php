<?php

namespace App\UseCases\Contracts;

use App\Models\Medicine;

interface ShowMedicineUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id): Medicine;
}
