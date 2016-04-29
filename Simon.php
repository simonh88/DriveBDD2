<?php
require_once('common.php');




$promotion = Promotion::getPromotion('1951761830');

var_dump($promotion);


$p = Planning::getNbPanier('21.03.2096 12');

var_dump($p);
/**
--INSERT INTO panier VALUES (1117144480,To_Date('21/03/2096 12','dd/mm/yyyy hh24'), 'F', NULL, NULL);
SELECT * FROM Planning JOIN Panier USING(date_heure) WHERE date_heure = to_date('21.03.2096 12','dd/mm/yyyy hh24');
**/