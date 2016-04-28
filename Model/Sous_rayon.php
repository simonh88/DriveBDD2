<?php

class Sous_rayon{
    private $nom_sr;
    private $nom_rayon;
    
    function __construct($row) {
        $this->nom_sr = $row['NOM_SR'];
        $this->nom_rayon = $row['NOM_RAYON'];
    }

    //GETTER
    function getNom_sr() {
        return $this->nom_sr;
    }

    function getNom_rayon() {
        return $this->nom_rayon;
    }

    //SETTER
    function setNom_sr($nom_sr) {
        $this->nom_sr = $nom_sr;
    }

    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }


    
}
