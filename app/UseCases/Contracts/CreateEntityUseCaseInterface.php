<?php

namespace App\UseCases\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CreateEntityUseCaseInterface
{
    public function execute(array $data): Model;
}
