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

    public static function getAll() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_lot JOIN Promotion USING(code_promo)'); // prepare le code
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

        $stid = oci_parse($oci, 'SELECT * FROM P_LOT JOIN PROMOTION USING(code_promo) where CODE_PROMO = :promo'); // prepare le code
        oci_bind_by_name($stid, ':promo', $code_promo);
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

    public static function insert($code_promo, $date_debut, $date_fin, $max_par_client,$nb_achetes, $nb_gratuits) {
        $oci = Base::getConnexion();
        Promotion::insertP($code_promo, $date_debut, $date_fin, $max_par_client);

        $stid = oci_parse($oci, "INSERT INTO P_lot VALUES ( :code_promo, :nb_achetes, :nb_gratuits)"); // prepare le code                
        oci_bind_by_name($stid, ":code_promo", $code_promo);
        oci_bind_by_name($stid, ":nb_achetes", $nb_achetes);
        oci_bind_by_name($stid, ":nb_gratuits", $nb_gratuits);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {
        $oci = Base::getConnexion();
        parent::update();
        $stid = oci_parse($oci, "UPDATE P_individuelle  SET nb_achetes = :nb_achetes, nb_gratuits = :nb_gratuits WHERE code_promo = :code_promo"); // prepare le code                
        oci_bind_by_name($stid, ":code_promo", $this->code_promo);
        oci_bind_by_name($stid, ":nb_achetes", $this->$nb_achetes);
        oci_bind_by_name($stid, ":nb_gratuits", $this->$nb_gratuits);        
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($code) {
        Promotion::deleteP($code);
    }

}
