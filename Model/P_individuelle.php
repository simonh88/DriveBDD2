<?php

class P_individuelle extends Promotion {

    private $reduction_absolue;
    private $reduction_relative;
    private $immediate_VF;

    function __construct($row) {
        var_dump($row);
        parent::__construct($row);
        $this->reduction_absolue = $row['REDUCTION_ABSOLUE']; // VALEUR DE LA PROMO
        $this->reduction_relative = $row['REDUCTION_RELATIVE']; // si null 
        $this->immediate_VF = $row['IMMEDIATE_VF'];
    }

    //GETTER
    function getReduction_absolue() {
        return $this->reduction_absolue;
    }

    function getReduction_relative() {
        return $this->reduction_relative;
    }

    function getImmediate_VF() {
        return $this->immediate_VF;
    }

    //SETTER
    function setReduction_absolue($reduction_absolue) {
        $this->reduction_absolue = $reduction_absolue;
    }

    function setReduction_relative($reduction_relative) {
        $this->reduction_relative = $reduction_relative;
    }

    function setImmediate_VF($immediate_VF) {
        $this->immediate_VF = $immediate_VF;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_individuelle '); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new P_individuelle($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function exist($code_promo) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_Individuelle where CODE_PROMO = :promo'); // prepare le code
        oci_bind_by_name($stid, ':promo', $code_promo);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $numrow = oci_fetch_all($stid, $res);
        if ($numrow > 0)
            return true;
        else
            return false;
    }

    public static function getPromotion($code_promo) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM P_INDIVIDUELLE JOIN PROMOTION USING(code_promo) where CODE_PROMO = :promo'); // prepare le code
        oci_bind_by_name($stid, ':promo', $code_promo);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }



        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
            $promo = new P_individuelle($row);
        
        return $promo;
    }

}
