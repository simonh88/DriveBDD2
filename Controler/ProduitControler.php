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
        "Profil" => "afficherProfil"
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
            if (empty($client) || !isset($client)) {
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

}
