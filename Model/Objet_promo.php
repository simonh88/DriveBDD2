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

    /** En fonction de la référence, on renvois toute les infos de la promo* */
    public static function getInfosPromoFref($ref) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT date_debut, date_fin, max_par_client,code_promo,reduction_absolue_reduction_relative,
            immediat_vf,nb_achetes_nb_gratuits FROM Objet_promo JOIN P_lot USING (code_promo) JOIN
            P_individuelle USING (code_promo) JOIN promotion USING (code_promo)
                WHERE reference = :ref'); // prepare le cod 

        oci_bind_by_name($stid, ':ref', $ref);

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

}
