<?php

class SSR_P {

    private $reference;
    private $nom_ssr;

    function __construct($row) {
        $this->reference = $row['REFERENCE'];
        $this->nom_ssr = $row['NOM_SSR'];
    }

    //GETTER
    function getReference() {
        return $this->reference;
    }

    function getNom_ssr() {
        return $this->nom_ssr;
    }

    //SETTER
    function setReference($reference) {
        $this->reference = $reference;
    }

    function setNom_ssr($nom_ssr) {
        $this->nom_ssr = $nom_ssr;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM SSR_P'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new SSR_P($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getAllProduit($ssr) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM SSR_P where NOM_SSR = :cat'); // prepare le code

        oci_bind_by_name($stid, ':cat', $ssr);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = Produit::getProduit($row['REFERENCE']);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function insert($rayon, $produit) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "INSERT INTO SSR_P (NOM_SSR, REFERENCE)  VALUES (:rayon, :prod)");
        oci_bind_by_name($stid, ':rayon', $rayon);
        oci_bind_by_name($stid, ':prod', $produit);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function deleteUn($produit) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "DELETE FROM SSR_P WHERE REFERENCE = :produit");
        oci_bind_by_name($stid, ':produit', $produit);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($rayon, $produit) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "DELETE FROM SSR_P WHERE REFERENCE = :produit and NOM_SSR = :rayon");
        oci_bind_by_name($stid, ':rayon', $rayon);
        oci_bind_by_name($stid, ':produit', $produit);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function update($rayon, $produit) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "UPDATE SSR_P SET NOM_SSR = :rayon WHERE REFERENCE = :prod)");
        oci_bind_by_name($stid, ':rayon', $rayon);
        oci_bind_by_name($stid, ':prod', $produit);

        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function getSSR($sr) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM SSR_P where REFERENCE = :cat'); // prepare le code
//
        oci_bind_by_name($stid, ':cat', $sr);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        return $row['NOM_SSR'];
    }

}
