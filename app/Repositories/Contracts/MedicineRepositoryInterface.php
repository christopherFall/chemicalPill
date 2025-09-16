<?php

namespace App\Repositories\Contracts;

use App\Models\Medicine;
use Illuminate\Support\Collection;

interface MedicineRepositoryInterface extends BaseRepositoryInterface
{
    /** @return Collection<int, Medicine> */
    public function allLatest(): Collection;
}
