<?php

require __DIR__ . '/src/autoload.php';

$start  = '2015/03/21';
$end    = '2017/04/03';
$difference = MyDate::diff($start, $end);
var_dump($difference);
