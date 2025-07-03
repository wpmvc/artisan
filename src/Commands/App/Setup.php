<?php

namespace WpMVC\Artisan\Commands\App;

use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WP_Filesystem_Direct;
use WpMVC\Artisan\Contracts\Command;
use Symfony\Component\Console\Question\Question;

class Setup extends Command
{
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'app:setup';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Setup wordpress plugin basic information';

    protected function execute( InputInterface $input, OutputInterface $output ): int {

        $helper = $this->getHelper( 'question' );

        /**
         * Ask Plugin Name
         */
        $question    = new Question( '<question>Enter plugin name:</question> ' );
        $plugin_name = $helper->ask( $input, $output, $question );
        echo PHP_EOL;
        $plugin_name = $this->plugin_name_validation( $plugin_name, $input, $output );
        
        /**
         * Ask Plugin Namespace
         */
        $question         = new Question( '<question>Enter plugin namespace:</question> ' );
        $plugin_namespace = $helper->ask( $input, $output, $question );
        echo PHP_EOL;
        $plugin_namespace = $this->plugin_namespace_validation( $plugin_namespace, $input, $output );

        /**
         * Ask Plugin Api Namespace
         */
        $question             = new Question( '<question>Enter plugin api namespace:</question> ' );
        $plugin_api_namespace = $helper->ask( $input, $output, $question );
        echo PHP_EOL;
        $plugin_api_namespace = $this->plugin_api_namespace_validation( $plugin_api_namespace, $input, $output );

        $search = [
            'MyPluginNamespace',
            'MyPluginName',
            'MyPluginApiNamespace',
            'MyPluginClass',
            'MyPluginTextDomain',
            'plugin_file_name',
            'my_plugin_hook',
            'my_plugin_function'
        ];

        $file_name =  str_replace( ' ', '-', strtolower( $plugin_name ) );
        $hook_name =  str_replace( [' ', '-'], ['_', '_'], strtolower( $plugin_name ) );

        $replace = [
            $plugin_namespace,
            $plugin_name,
            $plugin_api_namespace,
            str_replace( [' ', '-'], ['', ''], ucwords( $plugin_name ) ),
            $file_name,
            $file_name,
            $hook_name,
            $hook_name
        ];

        $this->update_file_content( $search, $replace );

        $old_root_file = $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'wpmvc.php';
        $new_root_file = $this->artisan->root_dir . DIRECTORY_SEPARATOR . $file_name . '.php';

        $subject  = file_get_contents( $old_root_file );
        $new_file = fopen( $new_root_file, "wb" );

        fwrite( $new_file, (string) str_replace( $search, $replace, $subject ) );
        fclose( $new_file );

        @unlink( $old_root_file );

        $this->update_artisan_file( $plugin_namespace );
        $this->update_composer( $file_name );
      
        $output->writeln( "<info>Information Updated Successfully!</info>" );
        echo PHP_EOL;
        $output->writeln( "<question>Started adding namespace prefix to the Composer libraries</question>" );
        exec( 'composer setup' );

        $output->writeln( "<info>{$plugin_name} Plugin Setup Successfully!</info>" );

        return Command::SUCCESS;
    }

    protected function update_composer( string $file_name ) {
        $file    = $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'composer.json';
        $subject = file_get_contents( $file );
        file_put_contents( $file, str_replace( "wpmvc/wpmvc", "wpmvc" . time() . "/" . $file_name, $subject ) );

        $this->delete_folder( $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'vendor-src' );
        unlink( $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'composer.lock' );
    }

    protected function update_artisan_file( string $namespace ) {
        $artisan_path = $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'artisan';
        $subject      = file_get_contents( $artisan_path );
        file_put_contents( $artisan_path, str_replace( ['vendor-src', 'WpMVC'], ['vendor/vendor-src', "{$namespace}\\WpMVC"], $subject ) );
    }

    protected function update_file_content( array $search, array $replace ) {
        foreach ( $this->get_all_files() as $file ) {
            $subject = file_get_contents( $file );
            file_put_contents( $file, str_replace( $search, $replace, $subject ) );
        }
    }

    protected function get_all_files() {
        $files = [];
        foreach ( $this->directories() as $directory ) {
            array_push( $files, ...$this->get_file_list_from_directory( $this->artisan->root_dir . DIRECTORY_SEPARATOR . $directory ) );
        }
        foreach ( $this->files() as $file ) {
            array_push( $files, $this->artisan->root_dir . DIRECTORY_SEPARATOR . $file );
        }
        return $files;
    }

    protected function get_file_list_from_directory( string $directory ) {
        $files    = [];
        $iterator = new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $directory ) );
    
        foreach ( $iterator as $file ) {
            if ( $file->isFile() ) {
                $files[] = $file->getPathname();
            }
        }
    
        return $files;
    }

    protected function files() {
        return [
            'composer.json',
            'package.json'
        ];
    }

    protected function directories() {
        return ['app', 'config', 'routes', 'database', 'dev-tools', 'enqueues'];
    }

    protected function plugin_name_validation( $plugin_name, InputInterface $input, OutputInterface $output ) {
        if ( empty( $plugin_name ) ) {
            $question    = new Question( "<error>Please enter plugin name:</error> " );
            $helper      = $this->getHelper( 'question' );
            $plugin_name = $helper->ask( $input, $output, $question );
            echo PHP_EOL;
            $plugin_name = $this->plugin_name_validation( $plugin_name, $input, $output );
        }

        return $plugin_name;
    }

    protected function plugin_api_namespace_validation( $plugin_api_namespace, $input, $output ) {
        if ( empty( $plugin_api_namespace ) ) {
            $question             = new Question( "<error>Please enter plugin api namespace:</error> " );
            $helper               = $this->getHelper( 'question' );
            $plugin_api_namespace = $helper->ask( $input, $output, $question );
            echo PHP_EOL;
            $plugin_api_namespace = $this->plugin_api_namespace_validation( $plugin_api_namespace, $input, $output );
        }

        return str_replace( ' ', '-', strtolower( $plugin_api_namespace ) );
    }

    public function plugin_namespace_validation( $plugin_namespace, $input, $output ) {
        if ( empty( $plugin_namespace ) ) {
            $question         = new Question( "<error>Please enter plugin namespace:</error> " );
            $helper           = $this->getHelper( 'question' );
            $plugin_namespace = $helper->ask( $input, $output, $question );
            echo PHP_EOL;
            $plugin_namespace = $this->plugin_namespace_validation( $plugin_namespace, $input, $output );
        }

        $first_character = intval( substr( $plugin_namespace, 0, 1 ) );

        if ( 0 !== $first_character ) {
            $question         = new Question( "<error>Please enter a valid namespace:</error> " );
            $helper           = $this->getHelper( 'question' );
            $plugin_namespace = $helper->ask( $input, $output, $question );
            echo PHP_EOL;
            $plugin_namespace = $this->plugin_namespace_validation( $plugin_namespace, $input, $output );
        }

        return str_replace( ' ', '', ucwords( $plugin_namespace ) );
    }

    private function delete_folder( string $folder ): void {
        if ( ! is_dir( $folder ) || is_link( $folder ) ) {
            // Do not delete if it's not a directory or if it's a symlink
            return;
        }

        $files = array_diff( scandir( $folder ), ['.', '..'] );

        foreach ( $files as $file ) {
            $path = $folder . DIRECTORY_SEPARATOR . $file;

            if ( is_link( $path ) ) {
                // Skip symlinks entirely
                continue;
            }

            if ( is_dir( $path ) ) {
                $this->delete_folder( $path );
            } elseif ( is_file( $path ) ) {
                @unlink( $path );
            }
        }

        @rmdir( $folder );
    }
}

