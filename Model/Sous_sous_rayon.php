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
    
    
    
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Sous_sous_rayon'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();
        
        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Sous_sous_rayon($row);
            $data[$i] = $client;
            $i++;
        }
        
        return $data;
    }



}
