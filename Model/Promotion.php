<?php

class Promotion {

    //Attributs de promotion

    private $code_promo;
    private $date_debut;
    private $date_fin;
    private $max_par_client;

    function __construct($row) {
        $this->code_promo = $row['CODE_PROMO'];
        $this->date_debut = $row['DATE_DEBUT'];
        $this->date_fin = $row['DATE_FIN'];
        $this->max_par_client = $row['MAX_PAR_CLIENT'];
    }

    //GETTER
    function getCode_promo() {
        return $this->code_promo;
    }

    function getDate_debut() {
        return $this->date_debut;
    }

    function getDate_fin() {
        return $this->date_fin;
    }

    function getMax_par_client() {
        return $this->max_par_client;
    }

    //SETTER
    function setCode_promo($code_promo) {
        $this->code_promo = $code_promo;
    }

    function setDate_debut($date_debut) {
        $this->date_debut = $date_debut;
    }

    function setDate_fin($date_fin) {
        $this->date_fin = $date_fin;
    }

    function setMax_par_client($max_par_client) {
        $this->max_par_client = $max_par_client;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Promotion'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Promotion($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getPromotion($code_promo) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Promotion where CODE_PROMO = :promo'); // prepare le code
        oci_bind_by_name($stid, ':promo', $code_promo);
        $r = oci_execute($stid); // on l'execute

        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }



        $row = oci_fetch_array($stid, OCI_BOTH);
        if (P_individuelle::exist($code_promo) == true) {
            $promotion = P_individuelle::getPromotion($code_promo);
        } else {
            $promotion = P_lot::getPromotion($code_promo);
        }
        return $promotion;
    }

    public static function insertP($code_promo, $date_debut, $date_fin, $max_par_client) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "INSERT INTO Promotion VALUES ( :code_promo , To_Date( :date_debut ,'dd/mm/yyyy hh24'), To_Date( :date_fin ,'dd/mm/yyyy hh24'),:max_par_client )"); // prepare le code                
        oci_bind_by_name($stid, ":code_promo", $code_promo);
        oci_bind_by_name($stid, ":date_debut", $date_debut);
        oci_bind_by_name($stid, ":date_fin", $date_fin);
        oci_bind_by_name($stid, ":max_par_client", $max_par_client);        
        
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE Promotion SET date_debut =To_Date( :date_debut ,'dd/mm/yyyy hh24'), date_fin =To_Date( :date_fin ,'dd/mm/yyyy hh24'),max_par_client =:max_par_client WHERE code_promo = :code_promo");
        oci_bind_by_name($stid, ":code_promo", $this->code_promo);
        oci_bind_by_name($stid, ":date_debut", $this->date_debut);
        oci_bind_by_name($stid, ":date_fin", $this->date_fin);
        oci_bind_by_name($stid, ":max_par_client", $this->max_par_client);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function deleteP($code) {
        $oci = Base::getConnexion();
        Item::deleteAll($code);
        $stid = oci_parse($oci, "DELETE FROM PROMOTION where CODE_PROMO = :carte");
        oci_bind_by_name($stid, ':carte', $code);        
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
