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

        WP_CLI::success(sprintf('Generated %d new objects.', $objectCount));
    }

    /**
     * Delete fake data
     *
     * ## OPTIONS
     *
     * [--yes]
     * : Delete the fake data without a confirmation prompt.
     */
    public function delete(array $args, array $assocArgs)
    {
        WP_CLI::confirm('Are you sure you want remove all fake data?', $assocArgs);

        // Sorted by removal specifity
        $dataTypes = [
            'Attachment',
            'Post',
            'User',
        ];

        foreach ($dataTypes as $dataType) {
            $className = __NAMESPACE__ . '\\Entity\\' . $dataType;
            $count = $className::delete();

            if ($count > 0) {
                WP_CLI::log(sprintf('Removed %d %s%s.', $count, strtolower($dataType), $count > 1 ? 's' : ''));
            }
        }

        WP_CLI::success('Successfully removed fake data.');
    }
}
