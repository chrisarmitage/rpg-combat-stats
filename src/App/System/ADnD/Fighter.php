<?php

namespace App\System\ADnD;

class Fighter
{
    /**
     * @var int
     */
    public $health;

    /**
     * @var int
     */
    protected $attackModifier;

    /**
     * @var int
     */
    protected $armourClass;

    /**
     * @param int $health
     * @param int $attackModifier
     * @param int $armourClass
     */
    public function __construct(int $health, int $attackModifier, int $armourClass)
    {
        $this->health = $health;
        $this->attackModifier = $attackModifier;
        $this->armourClass = $armourClass;
    }

    /**
     * @return int
     */
    public function getAttackModifier(): int
    {
        return $this->attackModifier;
    }

    /**
     * @return int
     */
    public function getArmourClass(): int
    {
        return $this->armourClass;
    }
}
