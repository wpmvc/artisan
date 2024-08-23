<?php

namespace WpMVC\Artisan\Commands\Make;

class Provider extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:provider';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new service provider class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Providers'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Providers',
        ];
    }
    
    public function uses_classes():array {
        return [
            'WpMVC\Contracts\Provider'
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName implements Provider {
    public function boot() {
        //
    }
}';
    }
}