<?php

namespace WpMVC\Artisan\Commands\Make;

class Request extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:request';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new form request class';

    public function namespaces(): array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Http',
            'Requests',
        ];
    }

    public function directories(): array {
        return [
            'app',
            'Http',
            'Requests',
        ];
    }

    public function uses_classes(): array {
        return [
            'WpMVC\RequestValidator\FormRequest',
        ];
    }

    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            //
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array {
        return [
            //
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array {
        return [
            //
        ];
    }
}';
    }
}
