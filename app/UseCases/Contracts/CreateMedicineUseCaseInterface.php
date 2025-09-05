<?php

namespace App\UseCases\Contracts;

use App\Models\Medicine;

interface CreateMedicineUseCaseInterface
{
    public function execute(array $data): Medicine;
}
