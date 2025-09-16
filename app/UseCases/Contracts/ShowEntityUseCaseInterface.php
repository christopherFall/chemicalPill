<?php

namespace App\UseCases\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ShowEntityUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id): Model;
}
