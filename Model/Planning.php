<?php

class Planning {

    //Attributs
    private $date_heure;
    private $nombre_livraison_max;

    function __construct($row) {
        $this->date_heure = $row['DATE_HEURE'];
        $this->nombre_livraison_max = $row['NOMBRE_LIVRAISON_MAX'];
    }

    //GETTER
    function getDate_heure() {
        return $this->date_heure;
    }

    function getNombre_livraison_max() {
        return $this->nombre_livraison_max;
    }

    //SETTER
    function setDate_heure($date_heure) {
        $this->date_heure = $date_heure;
    }

    function setNombre_livraison_max($nombre_livraison_max) {
        $this->nombre_livraison_max = $nombre_livraison_max;
    }

    public static function getAll() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Planning'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $pla = new Planning($row);
            $data[$i] = $pla;
            $i++;
        }

        return $data;
    }
    /**En fonction de la date, on retourne les infos du planning**/
    public static function getInfosPlanning($date) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM Planning where date_heure = to_date(:id,'dd/mm/yyyy hh24')"); // prepare le code

        oci_bind_by_name($stid, ':id', $date);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
            $p = new Planning($row);
        return $p;
    }
    /**En fonction de la date, on renvoit vrai si on peut rajouter un panier à cette date faux **/
    public static function verifNombreLivraison($date) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT * FROM Planning  WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')"); // prepare le code
        oci_bind_by_name($stid, ':id', $date);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        
        $stid2 = oci_parse($oci, "SELECT nombre_livraisons_max FROM Planning WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')");
        $r2 = oci_execute($stid); // on l'execute
        if (!$r2) {
            $e2 = oci_error($stid);
            trigger_error(htmlentities($e2['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $row2 = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS);
        var_dump((int)$row2);
        var_dump((int)$row);
        if($row['count'] < $row2['nombre_livraisons_max']){
            return true;
        }
        return false;
    } 
    
}
