<?php

namespace App\UseCases\Modules;

use Illuminate\Support\Collection;
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\UseCases\Contracts\GetAllMedicinesUseCaseInterface;

class GetAllMedicinesUseCase implements GetAllMedicinesUseCaseInterface
{
    public function __construct(private MedicineRepositoryInterface $repo) {}

    public function execute(): Collection
    {
        return $this->repo->allLatest();
    }
}
