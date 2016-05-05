<?php

class Sous_rayon {

    private $nom_sr;
    private $nom_rayon;

    function __construct($row) {
        $this->nom_sr = $row['NOM_SR'];
        $this->nom_rayon = $row['NOM_RAYON'];
    }

    //GETTER
    function getNom() {
        return $this->nom_sr;
    }

    function getNom_rayon() {
        return $this->nom_rayon;
    }

    //SETTER
    function setNom_sr($nom_sr) {
        $this->nom_sr = $nom_sr;
    }

    function setNom_rayon($nom_rayon) {
        $this->nom_rayon = $nom_rayon;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Sous_Rayon'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Sous_Rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getSesSSRayon($categorie) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM SOUS_SOUS_RAYON where NOM_SR LIKE :cat"); // prepare le code
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
            $client = new Sous_sous_rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public function getSous() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM SOUS_SOUS_RAYON where NOM_SR LIKE :cat"); // prepare le code

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
            $client = new Sous_sous_rayon($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function insert($nomsr, $nomr) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "INSERT INTO SOUS_RAYON VALUES ( :nom, :nomr ) ");
        oci_bind_by_name($stid, ':nom', $nomsr);
        oci_bind_by_name($stid, ':nomr', $nomr);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($nom) {
        var_dump(Sous_rayon::getSesSSRayon($nom));
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "DELETE FROM SOUS_RAYON WHERE NOM_SR LIKE :nom ");
        $nom = $nom."%"; // base de donnée rajoute des espace après pour remplir les 32 char..pourquoi.. nul ne le sait
        oci_bind_by_name($stid, ":nom", $nom);
        $r = oci_execute($stid); // on l'execute
        
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
