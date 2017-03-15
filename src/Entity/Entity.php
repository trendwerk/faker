<?php
namespace Trendwerk\Faker\Entity;

abstract class Entity
{
    public $id;

    abstract public function persist();
    abstract protected function create();
}
