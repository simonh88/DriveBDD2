<?php

class P_lot extends Promotion{
	private $nb_achetes;
	private $nb_gratuits;
        
        function __construct($row) {
            parent::__construct(array_slice($row,0,4));
            $this->nb_achetes = $row['NB_ACHETES'];
            $this->nb_gratuits = $row['NB_GRATUITS'];
        }

        
        //GETTER

        function getNb_achetes() {
            return $this->nb_achetes;
        }

        function getNb_gratuits() {
            return $this->nb_gratuits;
        }

        //SETTER

        function setNb_achetes($nb_achetes) {
            $this->nb_achetes = $nb_achetes;
        }

        function setNb_gratuits($nb_gratuits) {
            $this->nb_gratuits = $nb_gratuits;
        }


        
    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_lot'); // prepare le code
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