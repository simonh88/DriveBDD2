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
        "Deco" => "logout",
        "AffPanier" => "affichagePanier",
        "Payer" => "payerPanier",
        "Profil" => "afficherProfil",
        "AffCat" => "afficherProduitCat",
        "AffRay" => "afficherProduitRay",
        "AffSR" => "afficherProduitSR"
            //"Compte" => "compte"
    );

    public function home() { // test d'affichage de client
        if ($this->isConnected()) {

            if (isset($_GET["c"])) {
                if ($_GET["c"] == "ajoutPanier") {
                    Item::insertUnProduit($_SESSION["user"], $_POST["ref"], $_POST["qte"]);
                }
            }
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
            if (isset($_POST['carte'])) {
                $client = Client::getInfosClient($_POST['carte']);
            }
            
            if ($client->getNo_carte() == null) {
                $p = new ConnexionVue('Mauvais Client');
                $p->displayPage();
            } else {
                $_SESSION["user"] = $client->getNo_carte();
                $data = Produit::getAll();
                $pv = new ProduitVue($data);
                $pv->displayPage();
            }
        }
    }

    public function logout() {
        // On détruit les variables de notre session
        session_unset();
        // On redirige le visiteur vers la page d'accueil        
        $msg = 'Vous avez bien été deconecté';
        $view = new ConnexionVue($msg);
        $view->displayPage();
    }

    public function affichagePanier() {
        if ($this->isConnected()) {
            if (isset($_GET["c"])) {
                if ($_GET["c"] == "ViderPanier") {
                    Item::deleteAll($_SESSION['user']);
                } else if ($_GET["c"] == "enleveProduit") {
                    Item::deleteUnProduit($_SESSION["user"], $_POST["ref"], $_POST["qte"]);
                }
            }
            $infos = Panier::getInfos($_SESSION['user']);
            $items = Item::getInfosPanier($_SESSION['user']);
            $view = new PanierVue($items, $infos);
            $view->displayPage();
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }

    public function payerPanier() {
        if ($this->isConnected()) {
            $infos = Panier::getInfos($_SESSION['user']);
            if (isset($_GET["c"])) {
                if ($_GET["c"] == "validPayement") {
                    Item::deleteAll($_SESSION['user']);
                    $view = new PayerVue($infos, true);
                    $view->displayPage();
                }
            } else {
                $view = new PayerVue($infos, false);
                $view->displayPage();
            }
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }

    public function afficherProfil() {
        if ($this->isConnected()) {
            if (isset($_GET["c"])) {
                if ($_GET["c"] == "isValider") {
                    if (empty($_POST["nom"]) || empty($_POST["prenom"]) || (empty($_POST["tel"])) || (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) || (empty($_POST["adresse"]))) {
                        $infos = Client::getInfosClient($_SESSION["user"]);
                        $view = new ProfilVue($infos, false, false); //premier boolean pour dire si c est bien egal a isValider, le deuxieme pour dire si les données sont valides ou non
                        $view->displayPage();
                    } else {
                        $cli = Client::getInfosClient($_SESSION["user"]);
                        $cli->setNom($_POST["nom"]);
                        $cli->setPrenom($_POST["prenom"]);
                        $cli->setTelephone($_POST["tel"]);
                        $cli->setE_mail($_POST["email"]);
                        $cli->setAdresse($_POST["adresse"]);
                        $cli->update();
                        $infos = Client::getInfosClient($_SESSION["user"]);
                        $view = new ProfilVue($infos, true, true);
                        $view->displayPage();
                    }
                }
            } else {
                $infos = Client::getInfosClient($_SESSION["user"]);
                $view = new ProfilVue($infos, false, true);
                $view->displayPage();
            }
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }

    public function afficherProduitCat() {
        if ($this->isConnected()) {   
            if (isset($_GET["c"])) {
                $cate = Categorie::getAll();
                foreach ($cate as $uneCate) {
                    $nom = $uneCate->getNom();
                    if (strpos($nom,$_GET["c"]) === 0) { //Car $nom est un string de taille 32
                        $data = Categorie::getAllProduit($nom);
                        $view = new ProduitVue($data);
                        $view->displayPage();
                    }
                }
            }
            if (empty($view)) {//Si le client à essayer de changer le c= avec un nom inexistant ou c supprimé
                $data = Produit::getAll();
                $view = new ProduitVue($data);
                $view->displayPage();
            }
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }
    
    public function afficherProduitRay(){
        if ($this->isConnected()) {   
            if (isset($_GET["c"])) {
                $ray = Rayon::getAll();
                foreach ($ray as $unRay) {
                    $nom = $unRay->getNom();
                    if (strpos($nom,$_GET["c"]) === 0) { //Car $nom est un string de taille 32
                        $data = Rayon::getAllProduit($nom);
                        $view = new ProduitVue($data);
                        $view->displayPage();
                    }
                }
            }
            if (empty($view)) {//Si le client à essayer de changer le c= avec un nom inexistant ou c supprimé
                $data = Produit::getAll();
                $view = new ProduitVue($data);
                $view->displayPage();
            }
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }
    
    public function afficherProduitSR(){
        if ($this->isConnected()) {   
            if (isset($_GET["c"])) {
                $sr = Sous_rayon::getAll();
                foreach ($sr as $unSR) {
                    $nom = $unSR->getNom();
                    if (strpos($nom,$_GET["c"]) === 0) { //Car $nom est un string de taille 32
                        $data = SR_P::getAllProduit($nom);
                        $view = new ProduitVue($data);
                        $view->displayPage();
                    }
                }
            }
            if (empty($view)) {//Si le client à essayer de changer le c= avec un nom inexistant ou c supprimé
                $data = Produit::getAll();
                $view = new ProduitVue($data);
                $view->displayPage();
            }
        } else {
            $p = new ConnexionVue();
            $p->displayPage();
        }
    }
}
