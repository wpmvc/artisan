<?php

namespace WpMVC\Artisan\Commands\Make;

class DTO extends Make {
    /**
     * Command name for creating a new DTO class.
     *
     * @var string
     */
    // phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:dto';

    /**
     * Command description for creating a new DTO class.
     *
     * @var string
     */
    // phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new data transfer class';

    /**
     * Returns the namespaces to be used in the generated DTO file.
     *
     * @return array
     */
    public function namespaces(): array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'DTO',
        ];
    }

    /**
     * Returns the directory structure where the DTO file will be created.
     *
     * @return array
     */
    public function directories(): array {
        return [
            'app',
            'DTO',
        ];
    }

    /**
     * Returns the classes to be used in the "use" statements of the generated DTO file.
     *
     * @return array
     */
    public function uses_classes(): array {
        return [
            'WpMVC\DTO\DTO',
        ];
    }

    /**
     * Returns the file content template for the new DTO class.
     *
     * @return string
     */
    public function file_content(): string {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends DTO {
    private int $id;

    /**
     * Get the value of id.
     *
     * @return int
     */
    public function get_id(): int {
        return $this->id;
    }

    /**
     * Set the value of id.
     *
     * @param int $id
     *
     * @return self
     */
    public function set_id( int $id ): self {
        $this->id = $id;
        return $this;
    }
}';
    }
}