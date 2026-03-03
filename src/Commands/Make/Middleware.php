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
            'WP_Error',
            'WpMVC\Routing\Contracts\Middleware',
            'WpMVC\Exceptions\Exception',
        ];
    }

    public function file_content() {
        return '<?php
/**
 * Middleware Class.
 *
 * @package NamespaceName
 */

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

/**
 * Class ClassName
 *
 * @package NamespaceName
 */
class ClassName implements Middleware {
    /**
     * Handle an incoming request.
     *
     * @param  WP_REST_Request  $wp_rest_request The current request instance.
     * @param  mixed           $next            The next middleware closure in the stack.
     * @return bool|WP_Error Returns true to continue, false to forbid, or WP_Error.
     */
    public function handle( WP_REST_Request $wp_rest_request, $next ) {
        // Write your middleware logic here
        return $next( $wp_rest_request );
    }
}';
    }
}