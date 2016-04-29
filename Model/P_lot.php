<?php

class P_lot extends Promotion {

    private $nb_achetes;
    private $nb_gratuits;

    function __construct($row) {
        parent::__construct($row);
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
            $client = new P_lot($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function exist($code_promo) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_Individuelle where CODE_PROMO = :promo'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        if (oci_num_rows($stid) > 0)
            return true;
        else
            return false;
    }

    public static function getPromotion($code_promo) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_LOT JOIN PROMOTION USING(code_promo) where CODE_PROMO = :promo'); // prepare le code
        oci_bind_by_name($stid, ':promo', $code_promo);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        $promo = new P_lot($row);

        return $promo;
    }

}
