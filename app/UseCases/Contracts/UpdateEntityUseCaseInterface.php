<?php

namespace App\UseCases\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UpdateEntityUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id, array $data): Model;
}
