<?php

class AdminControler extends Controler {

    static $action = array(
//TODO plus d'action possible ( une action = 1 URL : drive.com/access=Admin&a=Accueil renvera sur la fonction static home()
        "Accueil" => "home", //accueil
        "AjoutPromo" => "addPromo",
        "AjoutProduit" => "addProduit",
        "AjoutCategorie" => "addCat",
        "AjoutRayon" => "addRayon",
        "AjoutSRayon" => "addSR",
        "AjoutSSRayon" => "addSSR",
        "ModifPromo" => "updtPromo",
        "ModifProduit" => "updtProduit",
        "SuprPromo" => "dltPromo",
        "SuprProduit" => "dltProduit",
        "SuprCategorie" => "dltCat",
        "SuprRayon" => "dltRayon",
        "SuprSRayon" => "dltSR",
        "SuprSSRayon" => "dltSSR",
        "MenuCategorie" => "listCat",
        "MenuPromo" => "listProm",
        "MenuProduit" => "listProd"
    );

    public function home() {
        $vue = new AdminHomeVue();
        $vue->displayPage();
    }

    public function addPromo() {

        if (isset($_POST)) {
            $this->home();
        } else {
            $vue = new AjoutPromo();
            $vue->displayPage();
        }
    }

    public function addProduit() {
        if (isset($_POST)) {
            $this->home();
        } else {
            $vue = new AjoutProd();
            $vue->displayPage();
        }
    }

    public function addCat() {
        if (isset($_POST['nom'])) {
            Categorie::insert($_POST['nom']);
            $this->listCat();
        } else {
            $vue = new AjoutCat();
            $vue->displayPage();
        }
    }

    public function addRayon() {
        if (isset($_POST['nom']) && isset($_POST['categorie'])) {
            Rayon::insert($_POST['nom'], $_POST['categorie']);
            $this->listCat();
        } else {
            $vue = new AjoutRayon();
            $vue->displayPage();
        }
    }

    public function addSR() {
        if (isset($_POST['nom']) && isset($_POST['rayon'])) {
            Sous_rayon::insert($_POST['nom'], $_POST['rayon']);
            $this->listCat();
        } else {
            $vue = new AjoutSRayon();
            $vue->displayPage();
        }
    }

    public function addSSR() {
        if (isset($_POST['nom']) && isset($_POST['srayon'])) {
            Sous_sous_rayon::insert($_POST['nom'], $_POST['srayon']);
            $this->listCat();
        } else {
            $vue = new AjoutSSRayon();
            $vue->displayPage();
        }
    }

    public function updtPromo() {

        $vue->displayPage();
    }

    public function updtProduit() {

        $vue->displayPage();
    }

    public function dltPromo() {

        $vue->displayPage();
    }

    public function dltProduit() {

        $vue->displayPage();
    }

    public function dltCat() {
        if (isset($_POST['ok'])) {
            Categorie::delete($_POST['ok']);
            $this->listCat();
        } else {
            $vue = new SupCat();
            $vue->displayPage();
        }
    }

    public function dltRayon() {
        if (isset($_POST['ok'])) {
            Rayon::delete($_POST['ok']);
            $this->listCat();
        } else {
            $vue = new SupR();
            $vue->displayPage();
        }
    }

    public function dltSR() {
        if (isset($_POST['ok'])) {            
            Sous_rayon::delete($_POST['ok']);
            $this->listCat();
        } else {
            $vue = new SupSR();
            $vue->displayPage();
        }
    }

    public function dltSSR() {

        if (isset($_POST['ok'])) {
            Sous_sous_rayon::delete($_POST['ok']);
            $this->listCat();
        } else {
            $vue = new SupSSR();
            $vue->displayPage();
        }
    }

    public function listCat() {
        $vue = new AdminCategorieVue();
        $vue->displayPage();
    }

    public function listProm() {
        $vue = new AdminPromotionVue();
        $vue->displayPage();
    }

    public function listProd() {
        $vue = new AdminProduitVue();

        $vue->displayPage();
    }

}
