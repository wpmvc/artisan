<?php
/**
 * make:factory command for WpMVC.
 *
 * @package WpMVC\Artisan
 * @author  WpMVC
 * @license MIT
 */

namespace WpMVC\Artisan\Commands\Make;

/**
 * Class Factory
 *
 * Command for creating a new model factory class.
 */
class Factory extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:factory';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new model factory class';

    /**
     * Get the namespace for the class.
     *
     * @return array
     */
    public function namespaces(): array {
        return [
            'Database',
            'Factories'
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
            'Factories'
        ];
    }

    /**
     * Get the classes that the class uses.
     *
     * @return array
     */
    public function uses_classes(): array {
        return [
            'WpMVC\Database\Eloquent\Factory'
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

class ClassName extends Factory {
    /**
     * Define the model\'s default state.
     *
     * @return array
     */
    public function definition(): array {
        return [
            //
        ];
    }
}';
    }
}
