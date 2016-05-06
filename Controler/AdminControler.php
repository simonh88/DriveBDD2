<?php

class AdminControler extends Controler {

    static $action = array(
//TODO plus d'action possible ( une action = 1 URL : drive.com/access=Admin&a=Accueil renvera sur la fonction static home()
        "Accueil" => "home", //accueil
        "AjoutPromo" => "addPromo", //TOTO
        "AjoutProduit" => "addProduit", //TOTO
        "AjoutCategorie" => "addCat",
        "AjoutRayon" => "addRayon",
        "AjoutSRayon" => "addSR",
        "AjoutSSRayon" => "addSSR",
        "ModifPromo" => "updtPromo", //TOTO
        "ModifProduit" => "updtProduit", //TOTO
        "SuprPromo" => "dltPromo", //TOTO
        "SuprProduit" => "dltProduit", //TOTO
        "SuprCategorie" => "dltCat",
        "SuprRayon" => "dltRayon",
        "SuprSRayon" => "dltSR",
        "SuprSSRayon" => "dltSSR",
        "MenuCategorie" => "listCat",
        "MenuPromo" => "listProm", //TOTO
        "MenuProduit" => "listProd", //TOTO
        "Recherche" => "search"         //TODO
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
        if (isset($_POST["ref"])) {

            $target_dir = "IMAGES/";
            $target_file = $target_dir . basename($_FILES["img"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }


            if ($uploadOk == 1) {
                $liqu = "V";
                if(!isset($_POST['liqu']))$lique = "F";
                Produit::insert($_POST['ref'], $_POST['lib'], $_POST['marq'], $target_file, $_POST['prix'], $lique, $_POST['kilo'], $_POST['qute']);
            } else {
                $vue = new AjoutProd("Erreur");
                $vue->displayPage();
            }
        } else {
            $vue = new AjoutProduit("lol");
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
