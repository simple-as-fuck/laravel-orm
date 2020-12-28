<?php

declare(strict_types=1);

namespace SimpleAsFuck\LaravelOrm\Provider;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;
use SimpleAsFuck\LaravelOrm\Database\Laravel\Adapter;
use SimpleAsFuck\LaravelOrm\Generator\Command\OrmCheck;
use SimpleAsFuck\LaravelOrm\Generator\Command\OrmGenerate;
use SimpleAsFuck\Orm\Config\Abstracts\Config;
use SimpleAsFuck\Orm\Database\Abstracts\Connection;
use SimpleAsFuck\Orm\Generator\Abstracts\StructureLoader;

final class Orm extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                OrmCheck::class,
                OrmGenerate::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->app->bind(Config::class, \SimpleAsFuck\LaravelOrm\Config\Laravel\Adapter::class);
        $this->app->bind(StructureLoader::class, function () {
            /** @var Repository $config */
            $config = $this->app->make(Repository::class);
            $driver = $config->get('database.connections.'.$config->get('orm.database-connection', $config->get('database.default')).'.driver');
            if (! $config->has('orm.structure-loaders.' . $driver)) {
                throw new \LogicException('Orm generator can not load models structure from database driver: "'.$driver.'" (orm.'.$driver.'-structure-loader class not defined)');
            }
            return $this->app->make($config->get('orm.structure-loaders.' . $driver));
        });

        $this->app->singleton(Connection::class, function () {
            return new Adapter($this->app->make(DatabaseManager::class), $this->app->make(Repository::class));
        });

        $this->mergeConfigFrom(__DIR__.'/../Config/Laravel/orm.php', 'orm');

        $this->publishes([__DIR__.'/../Config/Laravel/orm.php' => $this->app->configPath('orm.php')], 'config');
    }
}
