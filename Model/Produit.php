<?php

Class Produit {

    //Attributs de Produit

    private $reference;
    private $libelle;
    private $marque;
    private $fichier_image;
    private $prix_unit_HT;
    private $liquide_VF;
    private $prix_kilo_ou_litre;
    private $quantite_stock;

    function __construct($row) {

        $this->reference = $row['REFERENCE'];
        $this->libelle = $row['LIBELLE'];
        $this->marque = $row['MARQUE'];
        $this->fichier_image = $row['FICHIER_IMAGE'];
        $this->prix_unit_HT = $row['PRIX_UNIT_HT'];
        $this->liquide_VF = $row['LIQUIDE_VF'];
        $this->prix_kilo_ou_litre = $row['PRIX_KILO_OU_LITRE'];
        $this->quantite_stock = $row['QUANTITE_STOCK'];
    }

    //GETTER 
    function getReference() {
        return $this->reference;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getMarque() {
        return $this->marque;
    }

    function getFichier_image() {
        return $this->fichier_image;
    }

    function getPrix_unit_HT() {
        return $this->prix_unit_HT;
    }

    function getLiquide_VF() {
        return $this->liquide_VF;
    }

    function getPrix_kilo_ou_litre() {
        return $this->prix_kilo_ou_litre;
    }

    function getQuandtite_stock() {
        return $this->quantite_stock;
    }

    //SETTER
    function setReference($reference) {
        $this->reference = $reference;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setMarque($marque) {
        $this->marque = $marque;
    }

    function setFichier_image($fichier_image) {
        $this->fichier_image = $fichier_image;
    }

    function setPrix_unit_HT($prix_unit_HT) {
        $this->prix_unit_HT = $prix_unit_HT;
    }

    function setLiquide_VF($liquide_VF) {
        $this->liquide_VF = $liquide_VF;
    }

    function setPrix_kilo_ou_litre($prix_kilo_ou_litre) {
        $this->prix_kilo_ou_litre = $prix_kilo_ou_litre;
    }

    function setQuandtite_stock($quantite_stock) {
        $this->quantite_stock = $quantite_stock;
    }

    public static function getAll() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Produit'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $p = new Produit($row);
            $data[$i] = $p;
            $i++;
        }

        return $data;
    }

    public static function getProduit($ref) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Produit WHERE reference = :ref'); // prepare le code
//
        oci_bind_by_name($stid, ':ref', $ref);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        $p = new Produit($row);

        return $p;
    }

    public static function updateStockQuantite($ref, $quantite) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $p = Produit::getProduit($ref);
        $stid = oci_parse($oci, 'UPDATE Produit SET quantite_stock = :q WHERE reference = :ref'); // prepare le code
//
        $qFinale = $p->getQuandtite_stock() - $quantite;
        oci_bind_by_name($stid, ':ref', $ref);
        oci_bind_by_name($stid, ':q', $qFinale);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function insert($ref, $lib, $marq, $img, $prix, $liqu, $kilo, $qute) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "INSERT INTO PRODUIT VALUES ( :ref, :lib, :marq, :img, :prix, :liqu, :kilo, :qute)");
        oci_bind_by_name($stid, ':ref', $ref);
        oci_bind_by_name($stid, ':lib', $lib);
        oci_bind_by_name($stid, ':marq', $marq);
        oci_bind_by_name($stid, ':img', $img);
        oci_bind_by_name($stid, ':prix', $prix);
        oci_bind_by_name($stid, ':liqu', $liqu);
        oci_bind_by_name($stid, ':kilo', $kilo);
        oci_bind_by_name($stid, ':qute', $qute);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($ref) {
        $oci = Base::getConnexion();
        $p = Produit::getProduit($ref);
        unlink($p->fichier_image);
        $stid = oci_parse($oci, "DELETE FROM PRODUIT WHERE reference = :ref");
//
        oci_bind_by_name($stid, ':ref', $ref);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE PRODUIT SET libelle = :libelle, marque = :marque, fichier_image = :fichier_image, prix_unit_HT = :prix_unit_HT, liquide_VF = :liquide_VF, prix_kilo_ou_litre = :prix_kilo_ou_litre, quantite_stock = :quantite_stock where reference = :reference");
        oci_bind_by_name($stid, ':reference', $this->reference);
        oci_bind_by_name($stid, ':libelle', $this->libelle);
        oci_bind_by_name($stid, ':marque', $this->marque);
        oci_bind_by_name($stid, ':fichier_image', $this->fichier_image);
        oci_bind_by_name($stid, ':prix_unit_HT', $this->prix_unit_HT);
        oci_bind_by_name($stid, ':liquide_VF', $this->liquide_VF);
        oci_bind_by_name($stid, ':prix_kilo_ou_litre', $this->prix_kilo_ou_litre);
        oci_bind_by_name($stid, ':quantite_stock', $this->quantite_stock);
        $r = oci_execute($stid); // on l'execute et ça commit en même temps car on a pas utilise oci no auto commit
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
