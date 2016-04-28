<?php

class SR_P{

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


    
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM SR_P'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();
        
        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Client($row);
            $data[$i] = $client;
            $i++;
        }
        
        return $data;
    }


}
