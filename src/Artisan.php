<?php

namespace WpMVC\Artisan;

use Symfony\Component\Console\Application;
use WpMVC\Artisan\Commands\Commands;

class Artisan
{
    public string $root_dir;

    public function __construct( string $root_dir ) {
        $this->root_dir = $root_dir;
    }

    public function execute() {
        $application = new Application();
        $application->setName( 'WpMVC <info>' . $this->get_wpmvc_version() . '</info>' );

        foreach ( Commands::list() as $command ) {
            $command_object = new $command();
            $command_object->set_artisan( $this );
            $application->add( $command_object );
        }

        $application->run();
    }

    public function get_wpmvc_version() {
        $file_path = $this->root_dir . '/composer.json';

        if ( ! is_file( $file_path ) ) {
            return 'Unknown';
        }

        $composer_json = json_decode( file_get_contents( $file_path ), true );

        if ( empty( $composer_json['version'] ) ) {
            return 'Unknown';
        }

        return $composer_json['version'];
    }
}