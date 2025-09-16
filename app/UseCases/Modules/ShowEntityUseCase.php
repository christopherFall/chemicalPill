<?php

namespace App\UseCases\Modules;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\UseCases\Contracts\ShowEntityUseCaseInterface;

class ShowEntityUseCase implements ShowEntityUseCaseInterface
{
    public function __construct(private BaseRepositoryInterface $repo) {}

    public function execute(int $id): Model
    {
        return $this->repo->findById($id);
    }
}
