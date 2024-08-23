<?php

namespace WpMVC\Artisan\Commands\Make;

class Model extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:model';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new model class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Models'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Models',
        ];
    }

    public function uses_classes():array {
        return [
            'WpMVC\App',
            'WpMVC\Database\Resolver',
            'WpMVC\Database\Eloquent\Model'
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends Model {
    public static function get_table_name():string {
        // return your table name here
    }

    public function resolver():Resolver {
        return App::$container->get( Resolver::class );
    }
}';
    }
}