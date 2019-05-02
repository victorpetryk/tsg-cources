<?php

$currentHour = date( 'H' );

if ( $currentHour < 3 or $currentHour >= 11 ) {
	echo "Привіт, світ!";
} else {
	echo "Добрий ранок, світ!";
}

/**
 * Пояснення:
 *
 * (2 < 3 or 2 >= 11) (TRUE or FALSE) (TRUE) - скрипт виведе "Привіт, світ!"
 * (3 < 3 or 3 >= 11) (FALSE or FALSE) (FALSE) - скрипт виведе "Добрий ранок, світ!"
 * ...
 * (5 < 3 or 5 >= 11) (FALSE or FALSE) (FALSE) - скрипт виведе "Добрий ранок, світ!"
 * ...
 * (11 < 3 or 11 >= 11) (FALSE or TRUE) (TRUE) - скрипт виведе "Привіт, світ!"
 * (12 < 3 or 12 >= 11) (FALSE or TRUE) (TRUE) - скрипт виведе "Привіт, світ!"
 * ...
 */