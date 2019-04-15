<?php

namespace App;

class Person
{
    public $name;
    public $level;
    public $health;
    public $attack;
    public $defence;

    /**
     * Person constructor.
     * @param $name
     * @param $level
     * @param $health
     * @param $attack
     * @param $defence
     */
    public function __construct($name, $level, $health, $attack, $defence)
    {
        $this->name = $name;
        $this->level = $level;
        $this->health = $health;
        $this->attack = $attack;
        $this->defence = $defence;
    }
}
