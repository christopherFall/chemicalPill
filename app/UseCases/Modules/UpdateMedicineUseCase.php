<?php

namespace App\UseCases\Modules;

use App\Models\Medicine;
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\UseCases\Contracts\UpdateMedicineUseCaseInterface;

class UpdateMedicineUseCase implements UpdateMedicineUseCaseInterface
{
    public function __construct(private MedicineRepositoryInterface $repo) {}

    public function execute(int $id, array $data): Medicine
    {
        return $this->repo->update($id, $data);
    }
}
