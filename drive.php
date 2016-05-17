<?php

require_once("common.php");

try {

    // A completer si pkus de 1 controler (Connexion controler par exemples
    if (isset($_GET["acces"])) {

        if ($_GET["acces"] == 'Admin') {

            $controleur = new AdminControler();
            $a = $controleur->callAction();
            $controleur->$a();
        } else {

            $controleur = new ProduitControler();
            $a = $controleur->callAction();
            $controleur->$a();
        }
    } else {
        $controleur = new ProduitControler();
        $a = $controleur->callAction();
        $controleur->$a();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
