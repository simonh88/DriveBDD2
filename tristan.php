<?php

require_once('common.php');


$promo = Objet_promo::getAll();
foreach ($promo as $value) {
    $promo = Promotion::getPromotion($value->getCode_promo());
    var_dump($promo);
    
    $dateD = $promo->getDate_debut();
    $dateF = $promo->getDate_fin();
    echo $dateD." ---- ".$dateF."<br>";
    
    $dateD = str_replace("/", "-", $dateD);
    $dateF = str_replace("/", "-", $dateF);
    echo $dateD." ---- ".$dateF."<br>";
    
    
    $dateD = strtotime($dateD);
    $dateF = strtotime($dateF);       
    echo $dateD." ---- ".$dateF."<br>";
}


?>