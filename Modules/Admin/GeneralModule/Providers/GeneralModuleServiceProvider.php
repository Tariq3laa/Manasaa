<?php

namespace Modules\Admin\GeneralModule\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\GeneralModule\Repositories\BaseRepository;
use Modules\Admin\GeneralModule\Repositories\BaseRepositoryInterface;

class GeneralModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\Admin\GeneralModule\Http\Controllers';
    protected $webRoute = 'Modules/Admin/GeneralModule/Routes/web.php';
    protected $apiRoute = 'Modules/Admin/GeneralModule/Routes/api.php';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerApiRoutes();
        $this->registerMigrations();
    }


    protected function registerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->webRoute));
    }

    protected function registerApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(base_path($this->apiRoute));
    }

    /**
     * Register module migrations.
     */
    protected function registerMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
    }
}
