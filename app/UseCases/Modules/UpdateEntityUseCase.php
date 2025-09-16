<?php

namespace App\UseCases\Modules;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\BaseRepositoryInterface;
use App\UseCases\Contracts\UpdateEntityUseCaseInterface;

class UpdateEntityUseCase implements UpdateEntityUseCaseInterface
{
    public function __construct(private BaseRepositoryInterface $repo) {}

    public function execute(int $id, array $data): Model
    {
        return $this->repo->update($id, $data);
    }
}
