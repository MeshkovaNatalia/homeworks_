<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 13:14
 */

$var = '777';
if (preg_match("/^\d+$/", $var)) {
    echo "number";
} else {
    echo "no number";
}