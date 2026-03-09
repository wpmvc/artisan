<?php

namespace WpMVC\Artisan\Commands\Make;

class Migration extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:migration';
    
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new migration class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'Database',
            'Migrations'
        ];
    }

    public function directories():array {
        return [
            'database',
            'Migrations',
        ];
    }

    public function uses_classes():array {
        return [
            'WpMVC\Contracts\Migration'
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName implements Migration {
    /**
     * Run the migrations.
     *
     * @return bool If true migration is completed. if false then migration will execute next request too.
     */
    public function execute(): bool {
        return true;
    }
}';
    }
}
