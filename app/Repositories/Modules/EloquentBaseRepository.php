<?php

namespace App\Repositories\Modules;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\BaseRepositoryInterface;

class EloquentBaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /** @return Collection<int, Model> */
    public function all(): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function findById(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Model
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id): bool
    {
        $record = $this->findById($id);
        return (bool) $record->delete();
    }
}
