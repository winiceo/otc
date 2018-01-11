<?php

namespace Genv\Web\Handlers;

use Illuminate\Console\Command;

class PackageHandler extends \Genv\Otc\Support\PackageHandler
{
    /**
     * Publish public asstes source handle.
     *
     * @param \Illuminate\Console\Command $command
     * @return mixed
     */
    public function publishAsstesHandle(Command $command)
    {
        $force = $command->confirm('Overwrite any existing files');

        return $command->call('vendor:publish', [
            '--provider' => \Genv\Web\Providers\AppServiceProvider::class,
            '--tag' => 'web-public',
            '--force' => boolval($force),
        ]);
    }

    /**
     * Publish package config source handle.
     *
     * @param \Illuminate\Console\Command $command
     * @return mixed
     */
    public function publishConfigHandle(Command $command)
    {
        $force = $command->confirm('Overwrite any existing files');

        return $command->call('vendor:publish', [
            '--provider' => \Genv\Web\Providers\AppServiceProvider::class,
            '--tag' => 'web-config',
            '--force' => boolval($force),
        ]);
    }

    /**
     * Publish package resource handle.
     *
     * @param \Illuminate\Console\Command $command
     * @return mixed
     */
    public function publishHandle(Command $command)
    {
        return $command->call('vendor:publish', [
            '--provider' => \Genv\Web\Providers\AppServiceProvider::class,
        ]);
    }

    /**
     * The migrate handle.
     *
     * @param \Illuminate\Console\Command $command
     * @return mixed
     */
    public function migrateHandle(Command $command)
    {
        return $command->call('migrate');
    }

    /**
     * The DB seeder handler.
     *
     * @param \Illuminate\Console\Command $command
     * @return mixed
     */
    public function dbSeedHandle(Command $command)
    {
        return $command->call('db:seed', [
            '--class' => \Genv\Web\Seeds\DatabaseSeeder::class,
        ]);
    }
}
