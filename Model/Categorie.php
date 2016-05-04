<?php

class Categorie {

    private $nom_categorie;

    function __construct($row) {
        $this->nom_categorie = $row['NOM_CATEGORIE'];
    }

//GETTER
    function getNom() {
        return $this->nom_categorie;
    }

//SETTER
    function setNom_categorie($nom_categorie) {
        $this->nom_categorie = $nom_categorie;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Categorie'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $cate = new Categorie($row);
            $data[$i] = $cate;
            $i++;
        }

        return $data;
    }

    public static function getSesRayon($categorie) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM Rayon where NOM_CATEGORIE LIKE :cat "); // prepare le code
        $categorie = $categorie . "%";
        oci_bind_by_name($stid, ':cat', $categorie);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getAllProduit($produit) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM V_Produit where NOM_CATEGORIE LIKE :cat "); // prepare le code
        $produit = $produit . "%";
        oci_bind_by_name($stid, ':cat', $produit);
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

    public function getSous() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM Rayon where NOM_CATEGORIE LIKE :cat "); // prepare le code
        
        $nom = $this->getNom()."%";
        oci_bind_by_name($stid, ':cat', $nom);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

}
