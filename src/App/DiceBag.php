<?php

namespace App;

class DiceBag
{
    /**
     * Generate a number on a Bell curve using the Box–Muller transform
     *
     * @param int        $min
     * @param int        $max
     * @param float      $standardDeviation
     * @param float|null $step
     * @return float|int
     */
    public function bell(int $min, int $max, float $standardDeviation, ?float $step) {
        $step = $step ?? 1.0;
        $rand1 = (float)mt_rand()/(float)mt_getrandmax();
        $rand2 = (float)mt_rand()/(float)mt_getrandmax();
        $gaussianNumber = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
        $mean = ($max + $min) / 2;
        $randomNumber = ($gaussianNumber * $standardDeviation) + $mean;
        $randomNumber = round($randomNumber / $step) * $step;

        return $randomNumber;
    }

    public function roll($code) :int
    {
        $matches = [];
        if (preg_match('/^(?<times>\d+)d(?<die>\d+)$/', $code, $matches)) {
            return mt_rand(1, $matches['die']);
        }

        throw new \Exception('Unrecognised format');
    }
}
