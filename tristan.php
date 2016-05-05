<?php
require_once('common.php');

$date = '21.03.2096 12';
Panier::insert('1117144480');

var_dump(Panier::getAll());

Panier::delete('1117144480');

var_dump(Panier::getAll());
//INSERT INTO "SSR_P" VALUES('34955558424589742580', 'Provence');