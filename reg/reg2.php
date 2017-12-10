<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 10.12.2017
 * Time: 13:12
 */

$var = '<div class="text">Text text text</div><p>Some text</p>';
preg_match_all('!<.*?>(.*?)</.*?>!is', $var, $mass);
print_r($mass[1]);

