<?php

class SRR_P{
    private $reference;
    private $nom_ssr;
    
    function __construct($row) {
        $this->reference = $row['REFERENCE'];
        $this->nom_ssr = $row['NOM_SSR'];
    }

    
    //GETTER
    function getReference() {
        return $this->reference;
    }

    function getNom_ssr() {
        return $this->nom_ssr;
    }

    //SETTER
    function setReference($reference) {
        $this->reference = $reference;
    }

    function setNom_ssr($nom_ssr) {
        $this->nom_ssr = $nom_ssr;
    }


}
