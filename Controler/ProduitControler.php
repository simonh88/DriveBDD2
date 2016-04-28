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
        $data = Client::getAll();
        $pv = new ProduitVue($data);
        $pv->displayPage();
    }
    
    /*public function compte(){
        $clien = Client::getId($session);
        $vue = new Vue($client);
        $vue->displayPage();
    }*/

}
