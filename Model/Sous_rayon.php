<?php

class Sous_rayon{
    private $nom_sr;
    private $nom_rayon;
    
    function __construct($row) {
        $this->nom_sr = $row['NOM_SR'];
        $this->nom_rayon = $row['NOM_RAYON'];
    }

    //GETTER
    function getNom_sr() {
        return $this->nom_sr;
    }

    function getNom_rayon() {
        return $this->nom_rayon;
    }

    //SETTER
    function setNom_sr($nom_sr) {
        $this->nom_sr = $nom_sr;
    }

    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }

    
    
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Sous_Rayon'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();
        
        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Sous_Rayon($row);
            $data[$i] = $client;
            $i++;
        }
        
        return $data;
    }

    
}
