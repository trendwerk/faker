<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Loader\NativeLoader;

final class Faker
{
    private $files;
    private $loader;

    public function __construct($files)
    {
        $this->files = $files;
        $this->loader = new NativeLoader();
    }

    public function persist(ProgressBar $progressBar)
    {
        $persister = new Persister($progressBar);

        foreach ($this->files as $file) {
            $objects = $this->loader->loadFile($file);
            $persister->persist($objects);
        }
    }

    public function getObjectCount()
    {
        $objects = [];

        foreach ($this->files as $file) {
            $set = $this->loader->loadFile($file);
            $objects = array_merge($objects, $set->getObjects());
        }

        return count($objects);
    }
}
