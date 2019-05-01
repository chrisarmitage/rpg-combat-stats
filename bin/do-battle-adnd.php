<?php

use App\DiceBag;
use App\System\ADnD\CombatService;
use App\System\ADnD\Fighter;

require_once __DIR__ . '/../vendor/autoload.php';

$combatService = new CombatService(new DiceBag());

$numberOfFights = 10000;

$rulesets = [
    'STANDARD' => 'Standard',
];

foreach ($rulesets as $ruleset => $rulesetDesc) {
    $results = [
        'goodWins' => 0,
        'badWins' => 0,
    ];

    for ($fightNumber = 1; $fightNumber <= $numberOfFights; $fightNumber++) {
        $goodGuy = new Fighter(
            30,
            0,
            10
        );

        $badGuy = new Fighter(
            30,
            0,
            10
        );


        $goodGuyDamageDone = '';
        $badGuyDamageDone = '';
        $round = 1;

        //echo "## Fight {$fightNumber}" . PHP_EOL;

        do {
            $goodGuyDamageDone = '';
            $badGuyDamageDone = '';

            if ($combatService->hasHit($goodGuy, $badGuy)) {
                $goodGuyDamageDone = $combatService->getDamage($goodGuy);
                $badGuy->health -= $goodGuyDamageDone;
            }

            if ($badGuy->health > 0) {
                if ($combatService->hasHit($badGuy, $goodGuy)) {
                    $badGuyDamageDone = $combatService->getDamage($badGuy);
                    $goodGuy->health -= $badGuyDamageDone;
                }
            }

            //echo "R{$round}\t{$badGuyDamageDone}\t{$goodGuy->health}\t{$badGuy->health}\t{$goodGuyDamageDone}" . PHP_EOL;
        } while ($goodGuy->health > 0 && $badGuy->health > 0);


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
