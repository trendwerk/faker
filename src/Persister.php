<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\PersisterInterface;

final class Persister implements PersisterInterface
{
    public function persist(array $objects)
    {
        foreach ($objects as $object) {
            $object->save();
        }
    }

    public function find($class, $id)
    {
    }
}
