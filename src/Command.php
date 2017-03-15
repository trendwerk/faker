<?php
namespace Trendwerk\Faker;

use WP_CLI;

final class Command
{
    /**
     * Generate fake data based on an Alice YAML file.
     *
     * @synopsis <files>...
     */
    public function fake(array $files = [])
    {
        foreach ($files as $file) {
            if (! file_exists($file)) {
                WP_CLI::error('Input file not found.');
            }
        }

        $faker = new Faker($files);
        $objectCount = $faker->getObjectCount();

        $progressBar = new ProgressBar();
        $progressBar->start($objectCount);

        $faker->persist($progressBar);

        $progressBar->finish();

        WP_CLI::success(sprintf('Generated %d new posts.', $objectCount));
    }
}
