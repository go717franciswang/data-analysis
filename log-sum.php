<?php

/*
 * sometimes product of many numbers between 0 and 1 will be smaller 
 * than floating point can handle, we can take log of each number and 
 * add them. Then if we need the product, we can take exponential of 
 * the sum to get the desired product 
 */

function log_sum($numbers)
{
    $log_sum = 0;
    foreach ($numbers as $n) {
        $log_sum += log($n);
    }
    return $log_sum;
}
