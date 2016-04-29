<?php

class Panier{

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
        $this->date_validation = $row['DATE_VALIDATION'];
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
        $stid = oci_parse($oci, 'SELECT credit_carte, nom, prenom, adresse, e_mail, telephone
                FROM Panier WHERE no_carte = :id'); // prepare le cod 
  
        oci_bind_by_name($stid, ':id', $id_carte);
        
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
    
    
    /*
     * TODO 
     * 
     * INSERT PANIER lorsque le client n'en a pas (check lors de la 
     * connexion du client)
     *
     * 
     * INSERT PLanning DateDefautPlanning (avec limit -1)
     * 
     * INSERT INTO PANIER(nocarte, VIDE_VF, DatePlanningDefault,0,0)
     * 
     * DatePDefault = date du lendemain
     * Pourra etre changer lors du paiement
     *
     * FLUSH PANIER && ITEM lors du payement payement (ou boutton)
     * 
     * UPDATE dateValidation et de montant (lors du Payement)
     * 
     * 
     *Rajouter un fonction dans Planning ou Panier qui verif si 
     *
     * select count(*) from Panier where Date_Heure = DateDefaultHeure <
     * select nbmax from Planning
     * 
     * si Planning n'existait pas * INSERT PLANNING dateCHoisi
     * 
     * pour lors du choix de la date de livraison
     * 
     * INSERT PLanning
     * INSERT PANIER
     * DELETE ON CASCADE PANIER
     * DELETE ITEM
     * UPDATE ITEM & PANIER
     * fonction getNBPanier -> verifNombreLivraison
     */
    
}
