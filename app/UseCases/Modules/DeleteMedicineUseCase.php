<?php

namespace App\UseCases\Modules;

use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\UseCases\Contracts\DeleteMedicineUseCaseInterface;

class DeleteMedicineUseCase implements DeleteMedicineUseCaseInterface
{
    public function __construct(private MedicineRepositoryInterface $repo) {}

    public function execute(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
