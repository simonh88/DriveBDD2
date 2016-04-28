<?php

abstract class MainView { // page d'accueil du site 

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
                $this->javaScript(); // permet l'import de fonction javacript contenu dans le dossier lib/js
                ?>


            </head>
            
            <body>
                
                $this->displayBody();
                
            </body>

            <?php
        }

    }
    