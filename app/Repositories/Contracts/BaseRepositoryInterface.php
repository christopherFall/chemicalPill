<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /** @return Collection<int, Model> */
    public function all(): Collection;

    public function create(array $data): Model;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function findById(int $id): Model;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function update(int $id, array $data): Model;

    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function delete(int $id): bool;
}
