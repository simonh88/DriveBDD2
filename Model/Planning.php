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

    /** On regarde en fonction d'une date si on peut encore ajouter un panier ou non au planning* */
    public static function verifNombreLivraison($date) {
        //Tout marche !
        $a = Planning::getNombreLivraisonsMax($date);
        $b = Planning::getNbPanierInscrits($date);
        if ($b['NB'] < $a['NOMBRE_LIVRAISONS_MAX']) {
            return true;
        }
        return false;
    }

    /*     * Fonction regardant si le planning existe déjà ou non* */

    public static function existPlanning($date) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT count(*) as nb FROM Planning WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')");
        oci_bind_by_name($stid, ':id', $date);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        if ($row['NB'] == 1) {
            return true;
        }
        return false;
    }

    /*     * Fonction insérant un planning s'il n'existe pas à une date choisie* */

    public static function insertPlanning($dateChoisie, $nbLivMax) {
        //Print un message d'erreur. et regarder si la date est valide.
        if (($nbLivMax < 0) && ($nbLivMax > 9)) {
            echo("Le nombre de livraisons doit être compris entre 0 et 9 exclus");
            return;
        }
        if (!Planning::existPlanning($dateChoisie)) {//Si le planning existe pas
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $stid = oci_parse($oci, "INSERT INTO Planning VALUES(to_date(:id,'dd/mm/yyyy hh24'),:nb)");
            oci_bind_by_name($stid, ':id', $dateChoisie);
            oci_bind_by_name($stid, ':nb', $nbLivMax);
            $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
        }else{
            echo("Le planning existait déjà.");
        }
        //S'il existe on fait rien.
    }

    /** return la date du planning par défaut * */
    public static function getDefaultDate() {
        $date = '01/01/2000 12';
        return $date;
    }

    /*     * INsert un planning par défaut rattaché à tout les paniers avec nb_livraison_max = -1 et une date par défaut. * */
    
    public static function insertDefaultPlanning() {
        //Si le planning par défaut n'existe pas, on l'insert, sinon on fait rien
        $dateDefault = Planning::getDefaultDate();
        if (!Planning::existPlanning($dateDefault)) {
            $livDefault = -1; //COmme ça on ajoute autant de paniers qu'on veut.
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $stid = oci_parse($oci, "INSERT INTO Planning VALUES(to_date(:id,'dd/mm/yyyy hh24'),:nb)");
            oci_bind_by_name($stid, ':id', $dateDefault);
            oci_bind_by_name($stid, ':nb', $livDefault);
            $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
        }else{
            echo("Le planning par défaut existait déjà");
        }
    }

}
