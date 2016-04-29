<?php
require_once('common.php');


$cat = Categorie::getSesRayon('Boissons');

var_dump($cat); 


$prod = Categorie::getAllProduit('Boissons');
var_dump($prod);