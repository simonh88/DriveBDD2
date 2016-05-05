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

        $vue->displayPage();
    }

    public function addProduit() {

        $vue->displayPage();
    }

    public function addCat() {

        $vue->displayPage();
    }

    public function addRayon() {

        $vue->displayPage();
    }

    public function addSR() {

        $vue->displayPage();
    }

    public function addSSR() {

        $vue->displayPage();
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

        $vue->displayPage();
    }

    public function dltRayon() {

        $vue->displayPage();
    }

    public function dltSR() {

        $vue->displayPage();
    }

    public function dltSSR() {

        $vue->displayPage();
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
