<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProduitControler extends Controler {

    static $action = array(
        //TODO plus d'action possible ( une action = 1 URL : drive.com/a=Accueil renvera sur la fonction static home()
        "Accueil" => "home" //accueil
            //"Compte" => "compte"
    );

    public function home() { // test d'affichage de client
        if ($this->isConnected()) {
            $data = Produit::getAll();
            $pv = new ProduitVue($data);
            $pv->displayPage();
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }

    public function isConnected() {
        if (isset($_SESSION["user"]))
            return true;
        return false;
    }

    public function check() {
        if ($this->isConnected()) {
            $data = Produit::getAll();
            $pv = new ProduitVue($data);
            $vue->displayPage();
        } else {
            
        }
    }

}
