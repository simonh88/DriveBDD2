<?php
require_once('common.php');

$date = '21.03.2096 12';
$cat = Planning::getInfosPlanning($date);
var_dump($cat); 
