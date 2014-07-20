<?php

/*
 * Ehrenberg's Rule:
 * quote all digits up to and including the first 2 varialble digits
 * Good rule to use on estimated numbers
 */

function ehrenberg($nums)
{
    $max = max($nums);
    $magnitude = $max == 0 ? 1 : floor(log10($max));
    $max_iter = 100;
    $iter = 0;
    while (true) {
        $max_digit = null;
        $min_digit = null;

        foreach ($nums as $i => $n) {
            $digit = ($n / pow(10, $magnitude)) % 10;
            if ($i == 0) {
                $max_digit = $digit;
                $min_digit = $digit;
            } elseif ($digit > $max_digit) {
                $max_digit = $digit;
            } elseif ($digit < $min_digit) {
                $min_digit = $digit;
            }
        }

        $magnitude--;
        $iter++;
        if ($max_digit - $min_digit >= 2 || $max_iter == $iter) {
            break;
        }
    }

    $rs = array();
    foreach ($nums as $n) {
        $rs[] = round($n / pow(10, $magnitude)) * pow(10, $magnitude);
    }
    return $rs;
}

/*
 * Tests
 */
if (!debug_backtrace()) {
    $a = array(121.733, 122.129, 121.492, 119.782, 120.890, 123.129);
    $b = array(121.7, 122.1, 121.5, 119.8, 120.9, 123.1);
    foreach (ehrenberg($a) as $i => $v) {
        assert(round($v,3) == round($b[$i],3));
    }

    # special cases
    ehrenberg(array(1,1,1));
    ehrenberg(array(0));
}
