<?php

namespace WpMVC\Artisan\Commands\Make;

class Controller extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:controller';
    
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new controller class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Http',
            'Controllers'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Http',
            'Controllers',
        ];
    }

    public function uses_classes():array {
        return[
            'App\Http\Controllers\Controller',
            'WpMVC\Exceptions\Exception',
            'WpMVC\Routing\Response',
            'WpMVC\RequestValidator\Validator',
            'WP_REST_Request'
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends Controller {
    public function index( Validator $validator, WP_REST_Request $request ) {
        

        return Response::send([]);
    }
}';
    }
}