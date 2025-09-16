<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

// Repositories
use App\Repositories\Contracts\MedicineRepositoryInterface;
use App\Repositories\Modules\EloquentMedicineRepository;

// UseCases (GENÉRICOS)
use App\UseCases\Contracts\{
    CreateEntityUseCaseInterface,
    GetAllEntitiesUseCaseInterface,
    ShowEntityUseCaseInterface,
    UpdateEntityUseCaseInterface,
    DeleteEntityUseCaseInterface
};
use App\UseCases\Modules\{
    CreateEntityUseCase,
    GetAllEntitiesUseCase,
    ShowEntityUseCase,
    UpdateEntityUseCase,
    DeleteEntityUseCase
};

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositorio concreto
        $this->app->bind(MedicineRepositoryInterface::class, EloquentMedicineRepository::class);

        // Casos de uso genéricos inyectando el repo de Medicine
        $this->app->bind(CreateEntityUseCaseInterface::class, function ($app) {
            return new CreateEntityUseCase($app->make(MedicineRepositoryInterface::class));
        });

        $this->app->bind(GetAllEntitiesUseCaseInterface::class, function ($app) {
            return new GetAllEntitiesUseCase($app->make(MedicineRepositoryInterface::class));
        });

        $this->app->bind(ShowEntityUseCaseInterface::class, function ($app) {
            return new ShowEntityUseCase($app->make(MedicineRepositoryInterface::class));
        });

        $this->app->bind(UpdateEntityUseCaseInterface::class, function ($app) {
            return new UpdateEntityUseCase($app->make(MedicineRepositoryInterface::class));
        });

        $this->app->bind(DeleteEntityUseCaseInterface::class, function ($app) {
            return new DeleteEntityUseCase($app->make(MedicineRepositoryInterface::class));
        });
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
