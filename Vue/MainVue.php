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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="lib/bootstrap/js/bootstrap.js"></script>
            <?php
        }

        public function displayHead() {
            
        }

        //Dropdown rayon sous rayons avec logo en haut a droite
        // et mon compte et mon panier
        public function displayBandeau() {
            $data = Categorie::getAll();
            echo("<ul class='nav nav-tabs'>");
            foreach ($data as $name) {
                echo("<li role='presentation' class='dropdown'>");
                $cat = $name->getNom_categorie();
                echo(' <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">' . $cat . '<span class="caret"></span></a>');
                $rayon = $name->getSesRayon($cat);
                echo("<ul class ='dropdown-menu'>");
                foreach ($rayon as $value) {
                    echo('<li class="dropdown-submenu"><a href="#">'. $value->getNom_rayon() . '</a><ul class="dropdown-menu">');
                    foreach ($value->getSesSRayon($value->getNom_rayon()) as $srayon) {
                        echo('<li><a href="#">'.$srayon->getNom_sr().'</a></li>');
                    }
                    echo('</ul></li>');
         
                }
                echo ("</ul></li>");
            }
            echo("</ul>");
        }

    }
   ?> 