<?php
namespace Trendwerk\Faker\Entity;

abstract class Entity
{
    public $id;

    abstract protected function create();
    abstract public function persist();
}
