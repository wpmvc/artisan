<?php

namespace WpMVC\Artisan\Commands\Make;

class Repository extends Make {
    /**
     * Command name to create a new repository class.
     *
     * @var string
     */
    // phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:repository';

    /**
     * Command description for creating a new repository class.
     *
     * @var string
     */
    // phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new repository class';

    /**
     * Returns the namespaces to be used in the generated repository file.
     *
     * @return array
     */
    public function namespaces(): array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Repositories',
        ];
    }

    /**
     * Returns the directory structure where the repository file will be created.
     *
     * @return array
     */
    public function directories(): array {
        return [
            'app',
            'Repositories',
        ];
    }

    /**
     * Returns the classes to be used in the "use" statements of the generated repository file.
     *
     * @return array
     */
    public function uses_classes(): array {
        return [
            'WpMVC\Repositories\Repository',
            'WpMVC\Database\Query\Builder',
            'WpMVC\Exceptions\Exception',
        ];
    }

    /**
     * Returns the template content for the new repository class.
     *
     * This method provides a string template that is used to create
     * a new repository class file. The template includes placeholders
     * for the namespace, use statements, class name, and method stubs
     * that the generated repository class will implement.
     *
     * @return string The template content for the repository class.
     */
    public function file_content(): string {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends Repository {
    public function get_query_builder(): Builder {
        // Replace with the actual Builder instance
        // Example: return Post::query();
    }
}';
    }
}