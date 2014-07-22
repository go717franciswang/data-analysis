<?php

/*
 * Demo of doing a power of 10 calculation
 * probably has no value programmatically
 */

function power_of_ten($nums)
{
    $product = 1.0;
    $magnitudes = 0;
    foreach ($nums as $n) {
        if ($n == 0) {
            return 0;
        }

        if ($n < 1) {
            $n = 1/$n;
            $magnitude = floor(log10($n));
            $magnitudes -= $magnitude;
            $estimate = round($n / pow(10, $magnitude));
            $product /= $estimate;
        } else {
            $magnitude = floor(log10($n));
            $magnitudes += $magnitude;
            $estimate = round($n / pow(10, $magnitude));
            $product *= $estimate;
        }
    }

    return $product * pow(10, $magnitudes);
}

/*
 * Tests
 */
if (!debug_backtrace()) {
    assert(power_of_ten(array(9000, 17, 1/400, 1)), 450);
}
