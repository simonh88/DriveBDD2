<?php

class P_individuelle extends Promotion {

    private $reduction_absolue;
    private $reduction_relative;
    private $immediate_VF;

    function __construct($row) {
        parent::__construct(array_slice($row, 0, 4));
        $this->reduction_absolue = $row['REDUCTION_ABSOLUE'];
        $this->reduction_relative = $row['REDUCTION_RELATIVE'];
        $this->immediate_VF = $row['IMMEDIAT_VF'];
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

        $stid = oci_parse($oci, 'SELECT * FROM P_individuelle'); // prepare le code
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
