<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures\Loader;

final class Faker
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function run()
    {
        $loader = new Loader(get_locale(), [new Provider\Term()]);
        $objects = $loader->load($this->file);

        $persister = new Persister();
        $persister->persist($objects);

        return count($objects);
    }
}
