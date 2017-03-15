<?php
namespace Trendwerk\Faker\Entity;

abstract class Entity
{
    public $id;

    abstract public function persist();
    abstract public static function delete();
    abstract protected function create();
}
