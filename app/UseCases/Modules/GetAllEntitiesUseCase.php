<?php

namespace App\UseCases\Modules;

use Illuminate\Support\Collection;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\UseCases\Contracts\GetAllEntitiesUseCaseInterface;

class GetAllEntitiesUseCase implements GetAllEntitiesUseCaseInterface
{
    public function __construct(private BaseRepositoryInterface $repo) {}

    public function execute(): Collection
    {
        return $this->repo->allLatest();
    }
}
