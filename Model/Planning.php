<?php

class Planning {

    //Attributs
    private $date_heure;
    private $nombre_livraison_max;

    function __construct($row) {
        $this->date_heure = $row['DATE_HEURE'];
        $this->nombre_livraison_max = $row['NOMBRE_LIVRAISONS_MAX'];
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

    /*     * En fonction de la date, on retourne les infos du planning* */

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

    /*     * En fonction de la date, on renvoit le nombre de livraisons maximum * */

    public static function getNombreLivraisonsMax($date) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT nombre_livraisons_max FROM Planning WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')");
        oci_bind_by_name($stid, ':id', $date);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        return $row;
    }

    /** Fonction calculant le nombre de panier inscrits au planning à une date précisé en paramètres */
    public static function getNbPanierInscrits($date) {
        var_dump($date);
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT count(*) as nb FROM Panier WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')"); // prepare le code
        oci_bind_by_name($stid, ':id', $date);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        return $row;
        }
        /** On regarde en fonction d'une date si on peut encore ajouter un panier ou non au planning**/
        public static function verifNombreLivraison($date){
            //Tout marche !
            $a = Planning::getNombreLivraisonsMax($date);
            $b = Planning::getNbPanierInscrits($date);
            if ($b['NB'] < $a['NOMBRE_LIVRAISONS_MAX']) {
                return true;
            }
            return false;
    }

}
