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

        $stid = oci_parse($oci, "SELECT * FROM Rayon where NOM_CATEGORIE = :cat "); // prepare le code
//
        oci_bind_by_name($stid, ':cat', $categorie);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $rayon = new Rayon($row);
            $data[$i] = $rayon;
            $i++;
        }

        return $data;
    }

    public static function getAllProduit($cate) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM V_Produit where NOM_CATEGORIE = :cat "); // prepare le code
//
        oci_bind_by_name($stid, ':cat', $cate);
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

    public function getSous() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT * FROM Rayon where NOM_CATEGORIE = :cat "); // prepare le code

        $nom = $this->getNom();
        oci_bind_by_name($stid, ':cat', $nom);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $rayon = new Rayon($row);
            $data[$i] = $rayon;
            $i++;
        }

        return $data;
    }

    public static function insert($nomcategorie) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "INSERT INTO CATEGORIE VALUES ( :nom ) ");
        oci_bind_by_name($stid, ':nom', $nomcategorie);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($nom) {

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "DELETE FROM CATEGORIE WHERE NOM_CATEGORIE = :nom");
//
        oci_bind_by_name($stid, ':nom', $nom);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function verif($where, $valeur) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $test = "SELECT count(*) as NB 
FROM Produit P, SSR_P ssrp, sous_sous_rayon ssr,sous_rayon sr, rayon r, categorie c 
WHERE p.reference = ssrp.reference AND ssrp.nom_ssr = ssr.nom_ssr AND ssr.nom_sr = sr.nom_sr AND sr.nom_rayon = r.nom_rayon AND r.nom_categorie = c.nom_categorie
AND " . $where . "= :valeur";

        $stid = oci_parse($oci, $test);

        oci_bind_by_name($stid, ':valeur', $valeur);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        
        if ($row['NB'] == 1) {
            return true;
        }
        return false;
    }

//Notre base de donnée à été donnée tel que modification est impossible car le nom de la categorie est une clef primaire (de meme pour les autres tables Rayon SousRayon..)
//(hors le principe d'un clef primaire est d'être immuatable
// il aurais fallut créer une table categorie avec un ID clef primaire et un nom(Varchar 2 not null)
}
