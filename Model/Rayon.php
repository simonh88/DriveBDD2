<?php

class Rayon{
    private $nom_rayon;
    private $nom_categorie;
    
    //GETTER
    function getNom_rayon() {
        return $this->nom_rayon;
    }

    function getNom_categorie() {
        return $this->nom_categorie;
    }
    
    //SETTER
    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }

    function setNom_categorie($nom_categorie) {
        $this->nom_categorie = $nom_categorie;
    }




}
