<?php

class AdminControler extends Controler {

    static $action = array(
//TODO plus d'action possible ( une action = 1 URL : drive.com/access=Admin&a=Accueil renvera sur la fonction static home()
        "Accueil" => "home", //accueil
        "AjoutPromoLot" => "addPromoL", //TOTO
        "AjoutPromoIndi" => "addPromoI", //TOTO
        "AjoutProduit" => "addProduit",
        "AjoutCategorie" => "addCat",
        "AjoutRayon" => "addRayon",
        "AjoutSRayon" => "addSR",
        "AjoutSSRayon" => "addSSR",
        "ModifPromo" => "updtPromo", //TOTO
        "ModifProduit" => "updtProduit",
        "SuprPromo" => "dltPromo", //TOTO
        "SuprProduit" => "dltProduit",
        "SuprCategorie" => "dltCat",
        "SuprRayon" => "dltRayon",
        "SuprSRayon" => "dltSR",
        "SuprSSRayon" => "dltSSR",
        "MenuCategorie" => "listCat",
        "MenuPromo" => "listProm", //TOTO
        "MenuProduit" => "listProd",
        "Recherche" => "search"
    );

    public function home() {
        $vue = new AdminHomeVue();
        $vue->displayPage();
    }

    public function addPromoI() {

        if (isset($_POST["code"])) {
            if ($_POST['radio'] == 'absolue') {
                $reduction_absolue = $_POST['reduc'];
                $reduction_relative = null;
            } else {
                $reduction_absolue = null;
                $reduction_relative = $_POST['reduc'];
            }
            $immediate_VF = "F";
            if (isset($_POST['imd'])) {
                $immediate_VF = "V";
            }

            $dd = explode(":", $_POST['datedebut']);
            $date = explode("/", $dd[0]);
            $jj = explode(" ", $date[2]);

            $datedebut = $jj[0] . "/" . $date[1] . "/" . $date[0] . " " . $jj[1];

            $df = explode(":", $_POST['datefin']);
            $datef = explode("/", $df[0]);
            $jjf = explode(" ", $datef[2]);

            $datefin = $jjf[0] . "/" . $datef[1] . "/" . $datef[0] . " " . $jjf[1];


            P_individuelle::insert($_POST['code'], $datedebut, $datefin, $_POST['max'], $reduction_absolue, $reduction_relative, $immediate_VF);


            if (isset($_POST['nom_categorie'])) {
                $cat = $_POST['nom_categorie'];
                foreach ($cat as $value => $osef) {
                    $produits = Categorie::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_rayon'])) {
                $ray = $_POST['nom_rayon'];
                foreach ($ray as $value => $osef) {
                    $produits = Rayon::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_sr'])) {
                $sray = $_POST['nom_sr'];
                foreach ($sray as $value => $osef) {
                    $produits = SR_P::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_ssr'])) {
                $ssray = $_POST['nom_ssr'];
                foreach ($ssray as $value => $osef) {
                    $produits = SSR_P::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['reference'])) {
                
                foreach ($_POST['reference'] as $ref => $osef) {
                    $produit = Produit::getProduit($ref);
                    Objet_promo::insert($_POST["code"], $produit->getReference());
                }
            }
            $vue = new AdminPromotionVue();
            $vue->displayPage();
        } else {
            $vue = new AjoutPromoIndi();
            $vue->displayPage();
        }
    }

    public function addPromoL() {
        if (isset($_POST["code"])) {
           
            $dd = explode(":", $_POST['datedebut']);
            $date = explode("/", $dd[0]);
            $jj = explode(" ", $date[2]);

            $datedebut = $jj[0] . "/" . $date[1] . "/" . $date[0] . " " . $jj[1];

            $df = explode(":", $_POST['datefin']);
            $datef = explode("/", $df[0]);
            $jjf = explode(" ", $datef[2]);

            $datefin = $jjf[0] . "/" . $datef[1] . "/" . $datef[0] . " " . $jjf[1];

            
            P_Lot::insert($_POST['code'], $datedebut, $datefin, $_POST['max'], $_POST['achat'], $_POST['offert']);


            if (isset($_POST['nom_categorie'])) {
                $cat = $_POST['nom_categorie'];
                foreach ($cat as $value => $osef) {
                    $produits = Categorie::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_rayon'])) {
                $ray = $_POST['nom_rayon'];
                foreach ($ray as $value => $osef) {
                    $produits = Rayon::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_sr'])) {
                $sray = $_POST['nom_sr'];
                foreach ($sray as $value => $osef) {
                    $produits = SR_P::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['nom_ssr'])) {
                $ssray = $_POST['nom_ssr'];
                foreach ($ssray as $value => $osef) {
                    $produits = SSR_P::getAllProduit($value);
                    foreach ($produits as $produit) {
                        Objet_promo::insert($_POST["code"], $produit->getReference());
                    }
                }
            }
            if (isset($_POST['reference'])) {
               
                foreach ($_POST['reference'] as $ref => $osef) {
                    $produit = Produit::getProduit($ref);
                    Objet_promo::insert($_POST["code"], $produit->getReference());
                }
            }
            $vue = new AdminPromotionVue();
            $vue->displayPage();
        } else {
            $vue = new AjoutPromoLot();
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

    public function updtPromo() { //TODO
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
        if (isset($_POST['ok'])) {
            Promotion::deleteP($_POST['ok']);
            $this->listProm();
        } else {
            $vue = new SuprProm();
            $vue->displayPage();
        }
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
