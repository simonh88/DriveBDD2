<?php

class Panier {

//Attributs de panier
    private $no_carte;
    private $date_heure;
    private $vide_VF;
    private $date_validation;
    private $montant;

    function __construct($row) {
        $this->no_carte = $row['NO_CARTE'];
        $this->date_heure = $row['DATE_HEURE'];
        $this->vide_VF = $row['VIDE_VF'];
        $this->date_validation = $row['DATEVALIDATION'];
        $this->montant = $row['MONTANT'];
    }

//GETTER
    function getNo_carte() {
        return $this->no_carte;
    }

    function getDate_heure() {
        return $this->date_heure;
    }

    function getVide_VF() {
        return $this->vide_VF;
    }

    function getDate_validation() {
        return $this->date_validation;
    }

    function getMontant() {
        return $this->montant;
    }

//SETTER
    function setNo_carte($no_carte) {
        $this->no_carte = $no_carte;
    }

    function setDate_heure($date_heure) {
        $this->date_heure = $date_heure;
    }

    function setVide_VF($vide_VF) {
        $this->vide_VF = $vide_VF;
    }

    function setDate_validation($date_validation) {
        $this->date_validation = $date_validation;
    }

    function setMontant($montant) {
        $this->montant = $montant;
    }

    public static function getAll() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Panier'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Panier($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    public static function getInfos($id_carte) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT * 
                FROM Panier WHERE no_carte = :id'); // prepare le cod 

        oci_bind_by_name($stid, ':id', $id_carte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        $panier = new Panier($row);

        return $panier;
    }

    public static function insert($noCarte) {

        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "INSERT INTO Panier (NO_CARTE ,DATE_HEURE) VALUES ( :nocarte , To_Date( :heure ,'dd/mm/yyyy hh24:mi')) "); // prepare le code        

        $heure = Planning::getDefaultDate();
        oci_bind_by_name($stid, ':nocarte', $noCarte);
        oci_bind_by_name($stid, ':heure', $heure);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function delete($noCarte) {
        $oci = Base::getConnexion();
        Item::deleteAll($noCarte);
        $stid = oci_parse($oci, "DELETE FROM PANIER where NO_CARTE = :carte");
        oci_bind_by_name($stid, ':carte', $noCarte);
        Panier::setPrix($noCarte);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {

        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE Panier SET DATEVALIDATION = To_Date( :dateVal ,'dd/mm/yyyy hh24:mi') where no_carte = :no");

        $date = $this->getDate_validation();
        $no = $this->getNo_carte();
        oci_bind_by_name($stid, ':dateVal', $date);
        oci_bind_by_name($stid, ':no', $no);


        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        Panier::setPrix($no);
    }

    /**
     * 
     * @param type $nocarte 
     * @return
     */
    public static function setPrix($noCarte) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "Update Panier set montant = (select Sum(quantite*prix_UNIT_HT) as prix from Item JOIN Produit USING(reference) where no_carte = :carte) where no_carte = :carte");
        oci_bind_by_name($stid, ':carte', $noCarte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public static function getPrix($noCarte) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "Select montant from Panier where NO_CARTE = :carte");
        oci_bind_by_name($stid, ':carte', $noCarte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $prix = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        return $prix["MONTANT"];
    }

}
