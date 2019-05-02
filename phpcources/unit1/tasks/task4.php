<?php

$expression1 = 17>>3;
$expression2 = 9<<2;

echo $expression1 . '<br>';
echo $expression2;

/**
 * Пояснення:
 *
 * 17>>3 (10001 >> 3) (00010) (2)
 * 9<<2 (1001 << 2) (100100) (36)
 */