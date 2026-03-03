<?php
/**
 * db:seed command for WpMVC.
 *
 * @package WpMVC\Artisan
 * @author  WpMVC
 * @license MIT
 */

namespace WpMVC\Artisan\Commands\Db;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WpMVC\Artisan\Contracts\Command;
use WpMVC\Database\Seeder;

/**
 * Class Seed
 *
 * Command for seeding the database with records.
 */
class Seed extends Command {
    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultName = 'db:seed';

    //phpcs:ignore WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
    protected static $defaultDescription = 'Seed the database with records';

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void {
        $this->addOption( 'class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder', 'DatabaseSeeder' );
    }

    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int
     */
    protected function execute( InputInterface $input, OutputInterface $output ): int {
        $class = $input->getOption( 'class' );

        $namespace = __NAMESPACE__;
        $parts     = explode( '\\', $namespace );
        $namespace = $parts[0];

        require_once dirname( __DIR__, 10 ) . '/wp-load.php';

        if ( ! class_exists( $class ) ) {
            $candidates = [
                "{$namespace}\\Database\\Seeders\\{$class}",
                "{$namespace}\\Database\\Seeders\\DatabaseSeeder",
            ];

            foreach ( $candidates as $candidate ) {
                if ( class_exists( $candidate ) ) {
                    $class = $candidate;
                    break;
                }
            }
        }

        if ( ! class_exists( $class ) ) {
            $output->writeln( "<error>Seeder class [{$class}] not found.</error>" );
            return Command::FAILURE;
        }

        Seeder::run_seeder( $class );

        $output->writeln( "<info>Seeded:</info> {$class}" );
        $output->writeln( "<info>Database seeding completed successfully.</info>" );

        return Command::SUCCESS;
    }
}