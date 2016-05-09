<?php

require_once('common.php');



$date = "12/11/10";

$date = explode("/", $date);


echo strtotime($date[1]."-".$date[0]."-".$date[2]);