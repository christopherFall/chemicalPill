<?php

namespace App\UseCases\Modules;

use App\Models\Medicine;
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\UseCases\Contracts\ShowMedicineUseCaseInterface;

class ShowMedicineUseCase implements ShowMedicineUseCaseInterface
{
    public function __construct(private MedicineRepositoryInterface $repo) {}

    public function execute(int $id): Medicine
    {
        return $this->repo->findById($id);
    }
}
