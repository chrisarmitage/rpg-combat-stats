<?php

$numberOfFights = 10000;

$rulesets = [
    'STANDARD' => 'Standard',
    'GG_CRITICAL_20_X2' => 'Player Critical Hit 20, x2',
    'GG_CRITICAL_20_X3' => 'Player Critical Hit 20, x3',
    'GG_CRITICAL_19_X2' => 'Player Critical Hit 19, x2',
    'GG_CRITICAL_19_X3' => 'Player Critical Hit 19, x3',
];

foreach ($rulesets as $ruleset => $rulesetDesc) {


    $results = [
        'goodWins' => 0,
        'badWins' => 0,
    ];

    for ($fightNumber = 1; $fightNumber <= $numberOfFights; $fightNumber++) {
        $goodGuy = new Person(
            'Player',
            3,
            30,
            7,
            7
        );

        $badGuy = new Person(
            'Goblin',
            3,
            30,
            7,
            7
        );


        $victor = null;
        $goodGuyDamageDone = '';
        $badGuyDamageDone = '';
        $round = 1;

        //echo "## Fight {$fightNumber}" . PHP_EOL;

        do {
            //echo "R{$round}\t{$goodGuyDamageDone}\t{$goodGuy->health}\t{$badGuyDamageDone}\t{$badGuy->health}" . PHP_EOL;

            // Good guy attacks
            // GG has a Critical Hit chance
            $goodGuyAttackSkill = $goodGuy->attack;

            switch ($ruleset) {
                case 'GG_CRITICAL_20_X2':
                    $chance = 20;
                    $mod = 2;
                    break;
                case 'GG_CRITICAL_20_X3':
                    $chance = 20;
                    $mod = 3;
                    break;
                case 'GG_CRITICAL_19_X2':
                    $chance = 19;
                    $mod = 2;
                    break;
                case 'GG_CRITICAL_19_X3':
                    $chance = 19;
                    $mod = 3;
                    break;
                default:
                    $chance = 0;
                    $mod = 0;
            }

            if ($chance > 0) {
                if (mt_rand(1, 20) >= $chance) {
                    $goodGuyAttackSkill *= $mod;
                }
            }

            $roll = rollDamage($goodGuyAttackSkill, $badGuy->defence);

            $goodGuyDamageDone = $roll;

            if ($roll > 0) {
                $badGuy->health -= $roll;
            } else if ($roll < 0) {
                $goodGuy->health -= abs($roll);
            }

            // Bad guy attacks
            if ($badGuy->health > 0) {
                $roll = rollDamage($badGuy->attack, $goodGuy->defence);

                $badGuyDamageDone = $roll;

                if ($roll > 0) {
                    $goodGuy->health -= $roll;
                } else if ($roll < 0) {
                    $badGuy->health -= abs($roll);
                }
            }

        } while ($goodGuy->health > 0 && $badGuy->health > 0);

        // echo "R{$round}\t{$goodGuyDamageDone}\t{$goodGuy->health}\t{$badGuyDamageDone}\t{$badGuy->health}" . PHP_EOL;

        if ($goodGuy->health > 0) {
            $results['goodWins']++;
        } else {
            $results['badWins']++;
        }
    }

    echo str_pad($rulesetDesc, 40, ' ');
    echo "GW: {$results['goodWins']}\t" . round(($results['goodWins'] / $numberOfFights) * 100) . "% - ";
    echo round(($results['badWins'] / $numberOfFights) * 100) . "%\t{$results['badWins']}" . PHP_EOL;

}

function rollDamage($ggAttLvl, $bgDefLvl) {
    $attackRoll = purebell(0, $ggAttLvl, ($ggAttLvl - 0) / 3.3, 0.0001);
    $defenceRoll = purebell(0, $bgDefLvl, ($bgDefLvl - 0) / 3.3, 0.0001);

    $damageTaken = 0 - (int)($defenceRoll - $attackRoll);

    if ($damageTaken < 0) {
        $damageTaken = (int) ($damageTaken / 2);
    }

    return $damageTaken;
}

function purebell($min, $max, $standardDeviation, $step = 1) {
    $rand1 = (float)mt_rand()/(float)mt_getrandmax();
    $rand2 = (float)mt_rand()/(float)mt_getrandmax();
    $gaussianNumber = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
    $mean = ($max + $min) / 2;
    $randomNumber = ($gaussianNumber * $standardDeviation) + $mean;
    $randomNumber = round($randomNumber / $step) * $step;

    return $randomNumber;
}

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
