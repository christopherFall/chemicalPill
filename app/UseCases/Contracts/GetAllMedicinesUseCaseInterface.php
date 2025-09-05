<?php

namespace App\UseCases\Contracts;

use Illuminate\Support\Collection;

interface GetAllMedicinesUseCaseInterface
{
    /** @return Collection<int, \App\Models\Medicine> */
    public function execute(): \Illuminate\Support\Collection;
}
