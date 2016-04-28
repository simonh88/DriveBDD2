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
	private $quandtite_stock;
        
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
            return $this->quandtite_stock;
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

        function setQuandtite_stock($quandtite_stock) {
            $this->quandtite_stock = $quandtite_stock;
        }


}
?>