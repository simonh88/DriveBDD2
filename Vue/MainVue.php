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
                $this->displayBody(); ?>

            </body>

            <?php
        }

        abstract function displayBody();

        public function css() {
            ?>
            <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css" />
            <?php
        }
        
        public function displayHead(){
            
        }
        
        
        //Dropdown rayon sous rayons avec logo en haut a droite
        // et mon compte et mon panier
        public function displayBandeau(){
            $data = Categorie::getAll();
            echo("<table class='table table-hover'><tr>");
            foreach($data as  $name){
                echo("<td>".$name->getNom_categorie()."</td>");
            }
            echo("</tr></table>");
        }
    }
    