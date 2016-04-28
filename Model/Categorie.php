<?php

class Categorie{
    private $nom_categorie;
    
    function __construct($row) {
        $this->nom_categorie = $row['NOM_CATEGORIE'];
    }

    
    
    //GETTER
    function getNom_categorie() {
        return $this->nom_categorie;
    }
    //SETTER
    function setNom_categorie($nom_categorie) {
        $this->nom_categorie = $nom_categorie;
    }


}
