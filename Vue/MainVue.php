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
                    <a class="navbar-brand" href="drive.php?a=Acceuil">Accueuil</a>
                    <?php
                    echo("<ul class='nav nav-tabs navbar-left'>");
                    foreach ($data as $name) {
                        echo("<li role='presentation' class='dropdown'>");
                        $cat = $name->getNom();
                        echo(' <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">' . $cat . '<span class="caret"></span></a>');
                        $rayon = $name->getSesRayon($cat);
                        echo("<ul class ='dropdown-menu'>");
                        foreach ($rayon as $value) {
                            echo('<li class="dropdown-submenu"><a href="#">' . $value->getNom() . '</a><ul class="dropdown-submenu">');
                            foreach ($value->getSesSRayon($value->getNom()) as $srayon) {
                                echo('<li><a href="#">' . $srayon->getNom() . '</a></li>');
                            }
                            echo('</ul></li>');
                        }
                        echo ("</ul></li>");
                    }
                    echo("</ul></div>");
                    ?>
                </div>
            </div>
            <?php
        }

    }
    ?>  