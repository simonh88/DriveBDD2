<?php

class SRR_P{
    private $reference;
    private $nom_ssr;
    
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
