<?php

namespace WpMVC\Artisan\Commands;

use WpMVC\Artisan\Commands\App\Setup;
use WpMVC\Artisan\Commands\Make\Controller;
use WpMVC\Artisan\Commands\Make\DTO;
use WpMVC\Artisan\Commands\Make\Middleware;
use WpMVC\Artisan\Commands\Make\Model;
use WpMVC\Artisan\Commands\Make\Provider;
use WpMVC\Artisan\Commands\Make\Repository;
use WpMVC\Artisan\Commands\Make\Factory;
use WpMVC\Artisan\Commands\Make\Seeder;
use WpMVC\Artisan\Commands\Make\Mail;
use WpMVC\Artisan\Commands\Make\Migration;
use WpMVC\Artisan\Commands\Make\Request;
use WpMVC\Artisan\Commands\Db\Seed;
use WpMVC\Artisan\Contracts\Command;

class Commands
{
    /**
     * Register all available commands
     *
     * @return array<Command>;
     */
    public static function list() {
        return [
            Setup::class,
            Controller::class,
            DTO::class,
            Middleware::class,
            Model::class,
            Provider::class,
            Repository::class,
            Factory::class,
            Seeder::class,
            Mail::class,
            Migration::class,
            Request::class,
            Seed::class
        ];
    }
}