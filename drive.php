<?php

try {

 // A completer si pkus de 1 controler (Connexion controler par exemples
    
$controleur = new ProduitControler();
$a = $controleur->callAction();
$controleur->$a();


}catch (Exception $e) {
 	echo $e->getMessage();
}