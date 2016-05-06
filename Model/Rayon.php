<?php

class Rayon {

    private $nom_rayon;
    private $nom_categorie;

    function __construct($row) {
        $this->nom_rayon = $row['NOM_RAYON'];
        $this->nom_categorie = $row['NOM_CATEGORIE'];
    }

    //GETTER

    function getNom() {
        return $this->nom_rayon;
    }

    function getNom_categorie() {
        return $this->nom_categorie;
    }

    //SETTER
    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }

    function setNom_categorie($nom_categorie) {
        $this->nom_categorie = $nom_categorie;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Rayon'); // prepare le code
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

    public static function getSesSRayon($categorie) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM SOUS_RAYON where NOM_RAYON LIKE :cat "); // prepare le code
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
            $client = new Sous_rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public function getSous() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM SOUS_RAYON where NOM_RAYON LIKE :cat "); // prepare le code

        $nom = $this->getNom() . "%";
        oci_bind_by_name($stid, ':cat', $nom);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Sous_rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getAllProduit($ray) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM V_Produit_RAY where NOM_RAYON LIKE :ray "); // prepare le code
        $ray = $ray . "%";
        oci_bind_by_name($stid, ':ray', $ray);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

            $prod = Produit::getProduit($row['REFERENCE']);
            $data[$i] = $prod;
            $i++;
        }

        return $data;
    }

    public static function insert($nomcategorie, $nomrayon) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "INSERT INTO Rayon VALUES ( :nom, :rayon) ");
        oci_bind_by_name($stid, ':nom', $nomcategorie);
        oci_bind_by_name($stid, ':rayon', $nomrayon);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($nom) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "DELETE FROM RAYON WHERE NOM_RAYON LIKE :nom");
        $nom = $nom . "%";
        oci_bind_by_name($stid, ':nom', $nom);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
