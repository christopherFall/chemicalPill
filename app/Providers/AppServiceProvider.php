<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// Repositories
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\Repositories\Modules\EloquentMedicineRepository;

// UseCases
use App\UseCases\Contracts\{
    CreateMedicineUseCaseInterface,
    GetAllMedicinesUseCaseInterface,
    ShowMedicineUseCaseInterface,
    UpdateMedicineUseCaseInterface,
    DeleteMedicineUseCaseInterface
};
use App\UseCases\Modules\{
    CreateMedicineUseCase,
    GetAllMedicinesUseCase,
    ShowMedicineUseCase,
    UpdateMedicineUseCase,
    DeleteMedicineUseCase
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository
        $this->app->bind(MedicineRepositoryInterface::class, EloquentMedicineRepository::class);

        // Use Cases
        $this->app->bind(CreateMedicineUseCaseInterface::class, CreateMedicineUseCase::class);
        $this->app->bind(GetAllMedicinesUseCaseInterface::class, GetAllMedicinesUseCase::class);
        $this->app->bind(ShowMedicineUseCaseInterface::class, ShowMedicineUseCase::class);
        $this->app->bind(UpdateMedicineUseCaseInterface::class, UpdateMedicineUseCase::class);
        $this->app->bind(DeleteMedicineUseCaseInterface::class, DeleteMedicineUseCase::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
