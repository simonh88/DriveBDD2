<?php

class P_individuelle extends Promotion {

    private $reduction_absolue;
    private $reduction_relative;
    private $immediate_VF;

    function __construct($row) {
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

        $stid = oci_parse($oci, 'SELECT * FROM P_individuelle, Promotion '); // prepare le code
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

    public static function insert($code_promo, $date_debut, $date_fin, $max_par_client, $reduction_absolue, $reduction_relative, $immediate_VF) {
        $oci = Base::getConnexion();
        Promotion::insertP($code_promo, $date_debut, $date_fin, $max_par_client);

        $stid = oci_parse($oci, "INSERT INTO P_individuelle VALUES ( :code_promo, :reduction_absolue, :reduction_relative, :immediate_VF)"); // prepare le code                
        oci_bind_by_name($stid, ":code_promo", $code_promo);
        oci_bind_by_name($stid, ":reduction_absolue", $reduction_absolue);
        oci_bind_by_name($stid, ":reduction_relative", $reduction_relative);
        oci_bind_by_name($stid, ":immediate_VF", $immediate_VF);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {
        $oci = Base::getConnexion();
        parent::update();
        $stid = oci_parse($oci, "UPDATE P_individuelle  SET reduction_absolue = :reduction_absolue, reduction_relative = :reduction_relative, immediate_VF = :immediate_VF WHERE code_promo = :code_promo"); // prepare le code                
        oci_bind_by_name($stid, ":code_promo", $this->code_promo);
        oci_bind_by_name($stid, ":reduction_absolue", $this->reduction_absolue);
        oci_bind_by_name($stid, ":reduction_relative", $this->reduction_relative);
        oci_bind_by_name($stid, ":immediate_VF", $this->immediate_VF);
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($code) {
        Promotion::deleteP($code);
    }

}
