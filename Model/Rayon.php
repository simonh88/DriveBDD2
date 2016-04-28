<?php

class Rayon{
    private $nom_rayon;
    private $nom_categorie;
    
    
    function __construct($row) {
        $this->nom_rayon = $row['NOM_RAYON'];
        $this->nom_categorie = $row['NOM_CATEGORIE'];
    }

    
    //GETTER
    function getNom_rayon() {
        return $this->nom_rayon;
    }

    function getNom_categorie() {
        return $this->nom_categorie;
    }
    
    //SETTER
    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }

    function setNom_categorie($nom_categorie) {
        $this->nom_categorie = $nom_categorie;
    }
    
    
    
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Rayon'); // prepare le code
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
