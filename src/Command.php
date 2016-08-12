<?php
namespace Trendwerk\Faker;

use WP_CLI;

final class Command
{
    /**
     * Generate fake data based on an Alice YAML file.
     *
     * @synopsis <file>
     */
    public function fake(array $args = [])
    {
        $fileName = $args[0];

        if (! file_exists($fileName)) {
            WP_CLI::error('Input file not found.');
        }

        $faker = new Faker($fileName);
        $count = $faker->run();

        WP_CLI::success(sprintf('Generated %d new posts.', $count));
    }
}
