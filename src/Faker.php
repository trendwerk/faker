<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures\Loader;

final class Faker
{
    private $files;
    private $loader;

    public function __construct($files)
    {
        $this->files = $files;
        $this->loader = new Loader(get_locale(), [new Provider\Term]);
    }

    public function persist(ProgressBar $progressBar)
    {
        $persister = new Persister($progressBar);

        foreach ($this->files as $file) {
            $objects = $this->loader->load($file);
            $persister->persist($objects);
        }
    }

    public function getObjectCount()
    {
        $objects = [];

        foreach ($this->files as $file) {
            $set = $this->loader->load($file);
            $objects = array_merge($objects, $set);
        }

        return count($objects);
    }
}
