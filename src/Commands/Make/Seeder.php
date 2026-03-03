<?php
/**
 * make:seeder command for WpMVC.
 *
 * @package WpMVC\Artisan
 * @author  WpMVC
 * @license MIT
 */

namespace WpMVC\Artisan\Commands\Make;

/**
 * Class Seeder
 *
 * Command for creating a new database seeder class.
 */
class Seeder extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:seeder';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new database seeder class';

    /**
     * Get the namespace for the class.
     *
     * @return array
     */
    public function namespaces(): array {
        return [
            'Database',
            'Seeders'
        ];
    }

    /**
     * Get the directory for the class.
     *
     * @return array
     */
    public function directories(): array {
        return [
            'database',
            'Seeders'
        ];
    }

    /**
     * Get the classes that the class uses.
     *
     * @return array
     */
    public function uses_classes(): array {
        return [
            'WpMVC\Database\Seeder'
        ];
    }

    /**
     * Get the file content.
     *
     * @return string
     */
    public function file_content(): string {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void {
        //
    }
}';
    }
}
