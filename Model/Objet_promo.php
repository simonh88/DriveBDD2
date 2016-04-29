<?php

class Objet_promo {

    private $code_promo;
    private $reference;

    function __construct($row) {
        $this->code_promo = $row['CODE_PROMO'];
        $this->reference = $row['REFERENCE'];
    }

    //GETTER
    function getCode_promo() {
        return $this->code_promo;
    }

    function getReference() {
        return $this->reference;
    }

    //SETTER
    function setCode_promo($code_promo) {
        $this->code_promo = $code_promo;
    }

    function setReference($reference) {
        $this->reference = $reference;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Objet_promo'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Objet_promo($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    /** En fonction de la référence, on renvoit la promo* */
    public static function getCodePromo($ref) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT code_promo FROM Objet_promo WHERE reference = :ref'); // prepare le cod 

        oci_bind_by_name($stid, ':ref', $ref);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $p = Promotion::getPromotion($row['code_promo']);
            $data[$i] = $p;
            $i++;
        }
        return $data;
    }
    /** En fonction du code, on renvoit le produit* */
    public static function getCodePromoFcode($code_promo) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT ref FROM Objet_promo WHERE code_promo = :c'); // prepare le cod 

        oci_bind_by_name($stid, ':c', $code_promo);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $p = Produit::getProduit($row['reference']);
            $data[$i] = $p;
            $i++;
        }
        return $data;
    }

}