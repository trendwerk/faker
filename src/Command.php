<?php
namespace Trendwerk\Faker;

use WP_CLI;

final class Command
{
    /**
     * Generate fake data based on a fixture.
     *
     * @synopsis <file>
     */
    public function fake($args = [])
    {
        $fileName = $args[0];

        if (! file_exists($fileName)) {
            WP_CLI::error('Input file not found.');
        }
    }
}
