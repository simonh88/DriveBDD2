<?php

class Sous_sous_rayon{
    private $nom_ssr;
    private $nom_sr;

    function __construct($row) {
        $this->nom_ssr = $row['NOM_SSR'];
        $this->nom_sr = $row['NOM_SR'];
    }
    
    //SETTER
    function getNom_ssr() {
        return $this->nom_ssr;
    }

    function getNom_sr() {
        return $this->nom_sr;
    }

    //GETTER
    function setNom_ssr($nom_ssr) {
        $this->nom_ssr = $nom_ssr;
    }

    function setNom_sr($nom_sr) {
        $this->nom_sr = $nom_sr;
    }



}
