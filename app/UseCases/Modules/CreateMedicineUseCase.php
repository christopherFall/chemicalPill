<?php

namespace App\UseCases\Modules;

use App\Models\Medicine;
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\UseCases\Contracts\CreateMedicineUseCaseInterface;

class CreateMedicineUseCase implements CreateMedicineUseCaseInterface
{
    protected $repo;
    public function __construct(MedicineRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function execute(array $data): Medicine
    {
        return $this->repo->create($data);
    }
}
