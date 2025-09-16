<?php

namespace App\UseCases\Modules;

use App\Repositories\Contracts\BaseRepositoryInterface;
use App\UseCases\Contracts\DeleteEntityUseCaseInterface;

class DeleteEntityUseCase implements DeleteEntityUseCaseInterface
{
    public function __construct(private BaseRepositoryInterface $repo) {}

    public function execute(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
