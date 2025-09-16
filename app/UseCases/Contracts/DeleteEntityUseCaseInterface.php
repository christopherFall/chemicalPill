<?php

namespace App\UseCases\Contracts;

interface DeleteEntityUseCaseInterface
{
    /** @throws \Illuminate\Database\Eloquent\ModelNotFoundException */
    public function execute(int $id): bool;
}
