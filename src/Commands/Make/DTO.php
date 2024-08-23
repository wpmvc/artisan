<?php

namespace WpMVC\Artisan\Commands\Make;

class DTO extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:dto';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new data transfer class';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'DTO'
        ];
    }

    public function directories():array {
        return [
            'app',
            'DTO',
        ];
    }
    
    public function uses_classes():array {
        return [];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

class ClassName {

    private string $title;

    public function get_title() {
        return $this->title;
    }

    public function set_title( string $title ) {
        $this->title = $title;
    }
}';
    }
}