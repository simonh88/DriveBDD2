<?php
require_once('common.php');

$date = '21.03.2096 12';
Panier::insert('1117144480');

var_dump(Panier::getAll());

Panier::delete('1117144480');

var_dump(Panier::getAll());


bite::Grossir();