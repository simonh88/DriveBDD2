<?php

class Item{
    private $no_carte;
    private $reference;
    private $quantite;
    
    function __construct($row) {
        $this->no_carte = $row['NO_CARTE'];
        $this->reference = $row['REFERENCE'];
        $this->quantite = $row['QUANTITE'];
    }

    
    //GETTER
    function getNo_carte() {
        return $this->no_carte;
    }

    function getReference() {
        return $this->reference;
    }

    function getQuantite() {
        return $this->quantite;
    }

    //SETTER
    function setNo_carte($no_carte) {
        $this->no_carte = $no_carte;
    }

    function setReference($reference) {
        $this->reference = $reference;
    }

    function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

}

