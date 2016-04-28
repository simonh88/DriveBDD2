<?php

class Planning{
    //Attributs
    private $date_heure;
    private $nombre_livraison_max;
    
    function __construct($row) {
        $this->date_heure = $row['DATE_HEURE'];
        $this->nombre_livraison_max = $row['NOMBRE_LIVRAISON_MAX'];
    }

    
    //GETTER
    function getDate_heure() {
        return $this->date_heure;
    }

    function getNombre_livraison_max() {
        return $this->nombre_livraison_max;
    }

    //SETTER
    function setDate_heure($date_heure) {
        $this->date_heure = $date_heure;
    }

    function setNombre_livraison_max($nombre_livraison_max) {
        $this->nombre_livraison_max = $nombre_livraison_max;
    }


    
}

