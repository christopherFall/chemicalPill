<?php

namespace App\UseCases\Contracts;

use Illuminate\Support\Collection;

interface GetAllEntitiesUseCaseInterface
{
    /** @return Collection<int, \Illuminate\Database\Eloquent\Model> */
    public function execute(): \Illuminate\Support\Collection;
}
