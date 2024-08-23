<?php

namespace WpMVC\Artisan\Commands\Make;

class Repository extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:repository';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new repository class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Repositories'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Repositories',
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

class ClassName {
    public function get() {
        //
    }
}';
    }
}