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

    public YourRepository $repository;

    public function __construct( YourRepository $repository ) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Validator $validator Instance of the Validator.
     * @param WP_REST_Request $request The REST request instance.
     * @return array
     */
    public function index( Validator $validator, WP_REST_Request $request ): array {
        return Response::send(
            [
                "items" => $this->repository->get()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Validator $validator Instance of the Validator.
     * @param WP_REST_Request $request The REST request instance.
     * @return array
     */
    public function store( Validator $validator, WP_REST_Request $request ): array {
        $validator->validate(
            [
                // Add request-validation rules here.
            ]
        );

        $dto = new YourDTO;
        $id  = $this->repository->create( $dto );

        return Response::send(
            [
                "message" => esc_html__( "Item was created successfully" ),
                "data"    => [
                    "id" => $id
                ]
            ], 201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Validator $validator Instance of the Validator.
     * @param WP_REST_Request $request The REST request instance.
     * @return array
     * @throws Exception
     */
    public function show( Validator $validator, WP_REST_Request $request ): array {
        $validator->validate(
            [
                "id" => "required|numeric"
            ]
        );

        $item = $this->repository->get_by_id( $request->get_param( "id" ) );

        if ( ! $item ) {
            throw new Exception( esc_html__( "Item not found" ) );
        }

        return Response::send(
            [
                "data" => $item
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Validator $validator Instance of the Validator.
     * @param WP_REST_Request $request The REST request instance.
     * @return array
     */
    public function update( Validator $validator, WP_REST_Request $request ): array {
        $validator->validate(
            [
                "id" => "required|numeric"
                // Add other validation rules as needed.
            ]
        );

        $dto = new YourDTO;
        $dto->set_id( $request->get_param( "id" ) );

        $this->repository->update( $dto );

        return Response::send(
            [
                "message" => esc_html__( "Item was updated successfully" )
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Validator $validator Instance of the Validator.
     * @param WP_REST_Request $request The REST request instance.
     * @return array
     */
    public function delete( Validator $validator, WP_REST_Request $request ): array {
        $validator->validate(
            [
                "id" => "required|numeric"
            ]
        );

        $this->repository->delete_by_id( $request->get_param( "id" ) );

        return Response::send(
            [
                "message" => esc_html__( "Item was deleted successfully" )
            ]
        );
    }
}';
    }
}