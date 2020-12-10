<?php

declare(strict_types=1);

namespace SimpleAsFuck\LaravelOrm\Config\Laravel;

use Illuminate\Contracts\Config\Repository;
use SimpleAsFuck\Orm\Config\Abstracts\Config;

final class Adapter extends Config
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    protected function getValue(string $key)
    {
        $key = 'orm.'.$key;
        if (! $this->repository->has($key)) {
            throw new \RuntimeException('Config key: "'.$key.'" not exists');
        }

        return $this->repository->get($key);
    }
}
