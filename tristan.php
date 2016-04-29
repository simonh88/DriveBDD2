<?php
require_once('common.php');


$cat = Rayon::getSesSRayon('Eaux');
//$cat = Rayon::getAll();
//var_dump($cat); 


$prod = Categorie::getAllProduit('Boissons');
var_dump($prod);