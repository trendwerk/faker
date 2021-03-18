<?php
namespace Trendwerk\Faker;

use Fidry\AliceDataFixtures\Persistence\PersisterInterface;

final class Persister implements PersisterInterface
{
    private $progressBar;

    public function __construct(ProgressBar $progressBar)
    {
        $this->progressBar = $progressBar;
    }

    public function persist($objects)
    {
        foreach ($objects->getObjects() as $object) {
            $object->persist();
            $this->progressBar->tick();
        }
    }

    public function flush()
    {
    }
}
