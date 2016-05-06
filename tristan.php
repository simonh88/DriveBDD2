<?php

require_once('common.php');

Produit::insert(123456, "test", "test", "test", 12, "V", 12, 12);
$a = Produit::getProduit(123456);
var_dump($a);
$a->setMarque("bonjour");
$a->setPrix_unit_HT(99);
$a->update();
var_dump(Produit::getProduit(123456));
Produit::delete(123456);
var_dump(Produit::getProduit(123456));



?><!--//INSERT INTO "SSR_P" VALUES('34955558424589742580', 'Provence'); -->