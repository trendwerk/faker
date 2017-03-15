<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\PersisterInterface;

final class Persister implements PersisterInterface
{
    private $progressBar;

    public function __construct(ProgressBar $progressBar)
    {
        $this->progressBar = $progressBar;
    }

    public function persist(array $objects)
    {
        foreach ($objects as $object) {
            $object->persist();
            $this->progressBar->tick();
        }
    }

    public function find($class, $id)
    {
    }
}
