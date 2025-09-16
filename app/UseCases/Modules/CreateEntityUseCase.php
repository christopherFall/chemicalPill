<?php

namespace App\UseCases\Modules;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\UseCases\Contracts\CreateEntityUseCaseInterface;

class CreateEntityUseCase implements CreateEntityUseCaseInterface
{
    public function __construct(private BaseRepositoryInterface $repo) {}

    public function execute(array $data): Model
    {
        return $this->repo->create($data);
    }
}
