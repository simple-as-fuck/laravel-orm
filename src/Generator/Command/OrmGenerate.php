<?php

declare(strict_types=1);

namespace SimpleAsFuck\LaravelOrm\Generator\Command;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository;
use SimpleAsFuck\Orm\Generator\Generator;

final class OrmGenerate extends Command
{
    /** @var string */
    protected $signature = 'orm:generate';
    /** @var string */
    protected $description = 'Command generate orm classes based on current database structure.';

    private Generator $generator;
    private Repository $config;

    public function __construct(Generator $generator, Repository $config)
    {
        parent::__construct();

        $this->generator = $generator;
        $this->config = $config;
    }

    public function handle(): int
    {
        $configKey = 'database.connections.'.$this->config->get('orm.database-connection', $this->config->get('database.default')).'.database';
        $databaseName = $this->config->has($configKey) ? $this->config->get($configKey) : null;

        $this->generator->generate(true, $databaseName);

        return 0;
    }
}
