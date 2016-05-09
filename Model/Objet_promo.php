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
        $stid = oci_parse($oci, 'SELECT reference FROM Objet_promo WHERE code_promo = :c'); // prepare le cod 

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

    public static function insert($code_promo, $produit) {

        if (!empty(Objet_promo::getCodePromoFcode($produit))) {
            Objet_promo::delete($code_promo, $produit);
        }
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "INSERT INTO OBJET_PROMO (code_promo, reference) values(:code, :ref)");
        oci_bind_by_name($stid, ':code', $code_promo);
        oci_bind_by_name($stid, ':ref', $produit);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
      }

    public static function delete($code_promo, $produit) {

        $oci = Base::getConnexion();

        $stid = oci_parse($oci, "DELETE FROM OBJET_PROMO WHERE CODE_PROMO= :code AND REFERENCE = :ref");
//
        oci_bind_by_name($stid, ':ref', $produit);
        oci_bind_by_name($stid, ':code', $code_promo);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function deleteAll($code_promo) {
        $oci = Base::getConnexion();

        $stid = oci_parse($oci, "DELETE FROM OBJET_PROMO WHERE CODE_PROMO= :code");
//
        oci_bind_by_name($stid, ':ref', $produit);
        oci_bind_by_name($stid, ':code', $code_promo);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
