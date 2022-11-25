<?php

namespace Modules\Admin\Skill\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\Admin\Skill\Repositories\BaseRepository;
use Modules\Admin\Skill\Repositories\BaseRepositoryInterface;

class SkillModuleServiceProvider extends ServiceProvider
{

    protected $moduleNamespace = 'Modules\Admin\Skill\Http\Controllers';
    protected $webRoute = 'Modules/Admin/Skill/Routes/web.php';
    protected $apiRoute = 'Modules/Admin/Skill/Routes/api.php';

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
