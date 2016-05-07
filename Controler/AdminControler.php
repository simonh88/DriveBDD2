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
            $uploadOk = 0;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (isset($_POST["submit"]) && empty($_FILES["img"]['name']) == false) {
                $check = getimagesize($_FILES["img"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $uploadOk = 0;
                }
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    $lique = "V";
                    if (!isset($_POST['liqu']))
                        $lique = "F";
                    Produit::insert($_POST['ref'], $_POST['lib'], $_POST['marq'], $target_file, $_POST['prix'], $lique, $_POST['kilo'], $_POST['qute']);
                    if (Sous_rayon::exist($_POST['sous']))
                        SR_P::insert($_POST['sous'], $_POST['ref']);
                    else
                        SSR_P::insert($_POST['sous'], $_POST['ref']);
                    $vue = new AdminProduitVue();
                    $vue->displayPage();
                } else {
                    $vue = new AjoutProduit("Erreur Incconue");
                    $vue->displayPage();
                }
            } else {
                $vue = new AjoutProduit("Erreur");
                $vue->displayPage();
            }
        } else {
            $vue = new AjoutProduit();
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
        if (isset($_POST["ref"])) {

            $produit = Produit::getProduit($_POST["ref"]);

            $target_dir = "IMAGES/";
            $target_file = $target_dir . basename($_FILES["img"]["name"]);

            if ($produit->getFichier_image() != $target_file) {
                $uploadOk = 0;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                if (isset($_POST["submit"]) && empty($_FILES["img"]['name']) == false) {
                    $check = getimagesize($_FILES["img"]["tmp_name"]);
                    if ($check !== false) {
                        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                            unlink($produit->getFichier_image());
                            $produit->setFichier_image($target_file);
                        } else {
                            $vue = new ModifProduit("Erreur Inconnue");
                            $vue->displayPage();
                        }
                    } else {
                        $vue = new ModifProduit("Erreur");
                        $vue->displayPage();
                    }
                }
            }

            if (!isset($_POST['liqu']))
                $produit->setLiquide_VF("F");
            $produit->setLibelle($_POST['lib']);
            $produit->setMarque($_POST['marq']);
            $produit->setPrix_unit_HT($_POST['prix']);
            $produit->setPrix_kilo_ou_litre($_POST['kilo']);
            $produit->setQuandtite_stock($_POST['qute']);
            $produit->update();
            if (Sous_rayon::exist($_POST['sous'])) {
                SR_P::deleteUn($_POST['ref']);
                SR_P::insert($_POST['sous'], $_POST['ref']);
            } else {
                SSR_P::deleteUn($_POST['ref']);
                SSR_P::insert($_POST['sous'], $_POST['ref']);
            }
            
            $vue = new AdminProduitVue();
            $vue->displayPage();
        } else {
            if (isset($_GET['id'])) {
                $vue = new ModifProduit();
                $vue->displayPage();
            } else {
                $vue = new AdminProduitVue();
                $vue->displayPage();
            }
        }
    }

    public function dltPromo() {

        $vue->displayPage();
    }

    public function dltProduit() {
        if (isset($_POST['ok'])) {
            Produit::delete($_POST['ok']);
            $this->listProd();
        } else {
            $vue = new SupProd();
            $vue->displayPage();
        }
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

    public function search() { // pour le moment, que la reference du produit
        $produit = Produit::getProduit($_POST["reference"]);
        if (empty($produit)) {
            $vue = new AdminProduitVue();
            $vue->displayPage();
        } else {
            $vue = new AdminProduitVue($produit);
            $vue->displayPage();
        }
    }

}
