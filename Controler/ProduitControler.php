<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProduitControler extends Controler {

    static $action = array(
        //TODO plus d'action possible ( une action = 1 URL : drive.com/a=Accueil renvera sur la fonction static home()
        "Accueil" => "home", //accueil
        "Check" => "check", // connexion
        "Deco" => "logout"
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
            $pv->displayPage();
        } else {
            $client = Client::getInfosClient($_POST['carte']);
            if (empty($client)) {
                $p = new ConnexionVue('Mauvais Client');
                $p->displayPage();
            } else {
                $_SESSION["user"] = $_POST['carte'];
                $data = Produit::getAll();
                $pv = new ProduitVue($data);
                $pv->displayPage();
            }
        }
    }
    
    
        public function logout() {
        // On détruit les variables de notre session
        session_unset ();
        // On redirige le visiteur vers la page d'accueil        
        $msg ='Vous avez bien été deconecté';
        $view = new ConnexionVue($msg);
        $view->displayPage();
    }

}
