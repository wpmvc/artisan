<?php

namespace WpMVC\Artisan\Commands\Make;

class Middleware extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:middleware';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new middleware class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Http',
            'Middleware'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Http',
            'Middleware',
        ];
    }

    public function uses_classes():array {
        return [
            'WP_REST_Request',
            'WpMVC\Routing\Contracts\Middleware',
            'WpMVC\Exceptions\Exception',
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName implements Middleware {
    /**
    * Handle an incoming request.
    *
    * @param  WP_REST_Request  $wp_rest_request
    * @return bool
    */
    public function handle( WP_REST_Request $wp_rest_request ): bool {
        // Write your middleware logic here
        return true;
    }
}';
    }
}