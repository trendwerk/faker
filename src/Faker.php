<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures;

final class Faker
{
    private $files;

    public function __construct($files)
    {
        $this->files = $files;
    }

    public function run()
    {
        $objects = Fixtures::load($this->files, new Persister(), [
            'locale'    => get_locale(),
            'providers' => [new Provider\Term()],
        ]);

        return count($objects);
    }
}
