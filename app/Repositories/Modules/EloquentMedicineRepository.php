<?php

namespace App\Repositories\Modules;

use App\Models\Medicine;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\MedicineRepositoryInterface;

class EloquentMedicineRepository extends EloquentBaseRepository implements MedicineRepositoryInterface
{
    public function __construct(Medicine $model)
    {
        parent::__construct($model);
    }

    /** @return Collection<int, Medicine> */
    public function allLatest(): Collection
    {
        return $this->model->newQuery()->latest()->get();
    }
}
