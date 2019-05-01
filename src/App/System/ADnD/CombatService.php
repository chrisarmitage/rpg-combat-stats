<?php

namespace App\System\ADnD;

use App\DiceBag;

class CombatService
{
    /**
     * @var DiceBag
     */
    protected $diceBag;

    /**
     * @param DiceBag $diceBag
     */
    public function __construct(DiceBag $diceBag)
    {
        $this->diceBag = $diceBag;
    }

    public function hasHit(Fighter $attacker, Fighter $defender): bool
    {
        $roll = $this->diceBag->roll('1d20') + $attacker->getAttackModifier();
        if ($roll > $defender->getArmourClass()) {
            return true;
        }

        return false;
    }

    public function getDamage(Fighter $attacker)
    {
        return $this->diceBag->roll('1d8');
    }
}
