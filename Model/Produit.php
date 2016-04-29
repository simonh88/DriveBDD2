<?php
Class Produit{
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
            var_dump($row);
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

        
    public static function getAll() { // exemple, a suprimer
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
}
