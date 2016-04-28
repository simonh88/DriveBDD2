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

    
    
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Item'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();
        
        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Item($row);
            $data[$i] = $client;
            $i++;
        }
        
        return $data;
    }
}

