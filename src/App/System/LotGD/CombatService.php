<?php

namespace App\System\LotGD;

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

    public function rollDamage($ggAttLvl, $bgDefLvl): int
    {
        $attackRoll = $this->diceBag->bell(0, $ggAttLvl, ($ggAttLvl - 0) / 3.3, 0.0001);
        $defenceRoll = $this->diceBag->bell(0, $bgDefLvl, ($bgDefLvl - 0) / 3.3, 0.0001);

        $damageTaken = 0 - (int)($defenceRoll - $attackRoll);

        if ($damageTaken < 0) {
            $damageTaken = (int) ($damageTaken / 2);
        }

        return $damageTaken;
    }
}
