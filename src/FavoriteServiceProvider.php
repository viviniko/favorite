<?php

namespace Viviniko\Favorite;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Viviniko\Favorite\Console\Commands\FavoriteTableCommand;

class FavoriteServiceProvider extends BaseServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../config/favorite.php' => config_path('favorite.php'),
        ]);

        // Register commands
        $this->commands('command.favorite.table');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/favorite.php', 'favorite');

        $this->registerRepositories();

        $this->registerFavoriteService();

        $this->registerCommands();
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.favorite.table', function ($app) {
            return new FavoriteTableCommand($app['files'], $app['composer']);
        });
    }

    protected function registerRepositories()
    {
        $this->app->singleton(
            \Viviniko\Favorite\Repositories\FavoriteRepository::class,
            \Viviniko\Favorite\Repositories\EloquentFavorite::class
        );
    }

    /**
     * Register the favorite service provider.
     *
     * @return void
     */
    protected function registerFavoriteService()
    {
        $this->app->singleton(
            \Viviniko\Favorite\Contracts\UserFavoriteService::class,
            \Viviniko\Favorite\Services\Favorite\UserFavoriteServiceImpl::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            \Viviniko\Favorite\Contracts\UserFavoriteService::class
        ];
    }
}