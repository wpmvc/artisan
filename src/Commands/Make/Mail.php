<?php

namespace WpMVC\Artisan\Commands\Make;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Mail extends Make {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'make:mail';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Create a new mailable class';

    /**
     * The view name for the mailable.
     *
     * @var string
     */
    protected $view_name = '';

    public function namespaces():array {
        return [
            explode( '\\', __NAMESPACE__ )[0],
            'App',
            'Mail'
        ];
    }

    public function directories():array {
        return [
            'app',
            'Mail',
        ];
    }

    public function uses_classes():array {
        return [
            'WpMVC\Mail\Mailable'
        ];
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute( InputInterface $input, OutputInterface $output ): int {
        $name            = $input->getArgument( strtolower( $this->get_called_class_name() ) );
        $this->view_name = 'emails.' . $this->snake_case( $name );

        $result = parent::execute( $input, $output );

        if ( $result === self::SUCCESS ) {
            $this->create_view( $output );
        }

        return $result;
    }

    /**
     * Get placeholders for file content
     *
     * @param array $namespaces
     * @param string $class
     * @return array
     */
    protected function get_placeholders( $namespaces, $class ) {
        $placeholders             = parent::get_placeholders( $namespaces, $class );
        $placeholders['ViewName'] = $this->view_name;
        return $placeholders;
    }

    /**
     * Get the file content.
     *
     * @return string
     */
    public function file_content() {
        return '<?php

namespace NamespaceName;

defined( "ABSPATH" ) || exit;

UsesClasses

class ClassName extends Mailable {
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject( "Subject Here" )
            ->view( "ViewName" );
    }
}';
    }

    /**
     * Create the view file.
     *
     * @param OutputInterface $output
     * @return void
     */
    protected function create_view( OutputInterface $output ) {
        $view_file = str_replace( '.', DIRECTORY_SEPARATOR, $this->view_name ) . '.php';
        $view_path = $this->artisan->root_dir . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $view_file;

        $directory = dirname( $view_path );

        if ( ! file_exists( $directory ) ) {
            mkdir( $directory, 0777, true );
        }

        if ( ! file_exists( $view_path ) ) {
            $content = '<?php defined( "ABSPATH" ) || exit; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Template</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #f9f9f9; padding: 30px; border-radius: 8px;">
        <h1 style="color: #444;">Hello!</h1>
        <p>This is a sample email template for <strong>' . $this->view_name . '</strong>.</p>
        <p>You can customize this view in <code>resources/views/' . $view_file . '</code>.</p>
        <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
        <p style="font-size: 12px; color: #999;">Sent via WpMVC Mailable System</p>
    </div>
</body>
</html>';
            file_put_contents( $view_path, $content );
            $output->writeln( "<info>View resources/views/{$view_file} Created Successfully!</info>" );
        }
    }

    /**
     * Convert string to snake_case while preserving directory separators as dots.
     *
     * @param string $string
     * @return string
     */
    protected function snake_case( $string ) {
        $string = str_replace( ['/', '\\'], DIRECTORY_SEPARATOR, $string );
        $parts  = explode( DIRECTORY_SEPARATOR, $string );
        $parts  = array_map(
            function( $part ) {
                return strtolower( preg_replace( '/(?<!^)[A-Z]/', '_$0', $part ) );
            }, $parts
        );
        return implode( '.', $parts );
    }
}
