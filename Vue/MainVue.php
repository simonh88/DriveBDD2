<?php

abstract class MainVue { // page d'accueil du site 

    private $title;

    public function __construct($title = 'Accueil Drive') {
        $this->title = $title;
    }

    public function displayPage() {
        ?>
        <!doctype html>
        <html lang="fr">
            <head>
                <?php
                $this->displayHead(); // affiche les information du header de la page html
                $this->css();   //permet l'import de fichier css contenu dans le dosier lib/css
                ?>


            </head>

            <body>

                <?php
                $this->displayBandeau();
                $this->displayBody();
                ?>

            </body>

            <?php
        }

        abstract function displayBody();

        public function css() {
            ?>
            <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css" />
            <link rel="stylesheet" href="lib/css/drive.css" />
            <link rel="stylesheet" href="lib/css/ddhover.css" />
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="lib/bootstrap/js/bootstrap.js"></script>
            <?php
        }

        public function displayHead() {
            ?>
            <title><?php echo $this->title ?></title>
            <meta charset="utf-8">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />         
            <?php
        }

        //Dropdown rayon sous rayons avec logo en haut a droite
        // et mon compte et mon panier
        public function displayBandeau() {
            $data = Categorie::getAll();
            ?>
            <div class="container">
                <div class="nav nav-stacked">
                    <div class="navbar-right">
                        <div class="dropdownh">
                            <button class="drophbtn"><span class="glyphicon glyphicon-user"></span> Mon compte<span class="caret"></span></button>
                            <div class="dropdownh-content">
                                <a href="drive.php?a=Profil">Mon profil <span class="glyphicon glyphicon-cog"></span></a>
                                <a href="drive.php?a=Deco">Se deconnecter <span class="glyphicon glyphicon-log-out"></span></a>
                            </div>
                        </div>
                        <div class="dropdownh">
                            <button class="drophbtn"><span class="glyphicon glyphicon-briefcase"></span> Mon Panier<span class="caret"></span><span class="badge">
                                    <?php
                                    $prix = Panier::getPrix($_SESSION["user"]);
                                    if (empty($prix)) {
                                        echo(0);
                                    } else {
                                        echo($prix);
                                    }
                                    ?>
                                    <span class="glyphicon glyphicon-euro"</span></span></button>
                            <div class="dropdownh-content">
                                <a href="drive.php?a=AffPanier">Voir son contenu <span class="glyphicon glyphicon-eye-open"</span></a>
                                <a href="drive.php?a=Payer">Payer <span class="glyphicon glyphicon-euro"</span> </a>
                            </div>
                        </div>
                    </div>
                    <a class="navbar-brand" href="drive.php?a=Accueil">Accueil</a>


                    <nav><ul>
                            <li><a href="drive.php?a=AffPromo">Promotions</a></li>
                            <?php
                            foreach ($data as $name) {
                                $cat = $name->getNom();
                                $rayon = $name->getSesRayon($cat);
                                ?>
                                <li><a href="drive.php?a=AffCat&c=<?php echo($cat) ?>"><?php echo($cat) ?></a>
                                    <ul>
                                        <?php foreach ($rayon as $value) { ?>
                                            <li><a href="drive.php?a=AffRay&c=<?php echo($value->getNom()) ?>"><?php echo($value->getNom()) ?></a>
                                                <ul>
                                                    <?php foreach ($value->getSesSRayon($value->getNom()) as $srayon) { ?>
                                                        <li><a href="drive.php?a=AffSR&c=<?php echo($srayon->getNom()) ?>"> <?php echo($srayon->getNom()) ?></a></li>
                                                    <?php } ?>
                                                </ul></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>


                        </ul></nav></div></div>
            <?php
        }

    }
    