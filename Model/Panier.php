<?php

class Panier{

        //Attributs de panier
    private $no_carte;
    private $date_heure;
    private $vide_VF;
    private $date_validation;
    private $montant;
    
    function __construct($row) {
        $this->no_carte = $row['NO_CARTE'];
        $this->date_heure = $row['DATE_HEURE'];
        $this->vide_VF = $row['VIDE_VF'];
        $this->date_validation = $row['DATE_VALIDATION'];
        $this->montant = $row['MONTANT'];
    }

    
    //GETTER
    function getNo_carte() {
        return $this->no_carte;
    }

    function getDate_heure() {
        return $this->date_heure;
    }

    function getVide_VF() {
        return $this->vide_VF;
    }

    function getDate_validation() {
        return $this->date_validation;
    }

    function getMontant() {
        return $this->montant;
    }

    //SETTER
    function setNo_carte($no_carte) {
        $this->no_carte = $no_carte;
    }

    function setDate_heure($date_heure) {
        $this->date_heure = $date_heure;
    }

    function setVide_VF($vide_VF) {
        $this->vide_VF = $vide_VF;
    }

    function setDate_validation($date_validation) {
        $this->date_validation = $date_validation;
    }

    function setMontant($montant) {
        $this->montant = $montant;
    }


    
 
}
