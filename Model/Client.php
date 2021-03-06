<?php

class Client {

    // Tout les attribu de la table Client

    private $no_carte;
    private $credit_carte;
    private $nom;
    private $prenom;
    private $adresse;
    private $e_mail;
    private $telephone;

    function __construct($row) {
        $this->no_carte = $row['NO_CARTE'];
        $this->credit_carte = $row['CREDIT_CARTE'];
        $this->nom = $row['NOM'];
        $this->prenom = $row['PRENOM'];
        $this->adresse = $row['ADRESSE'];
        $this->e_mail = $row['E_MAIL'];
        $this->telephone = $row['TELEPHONE'];
    }

    function setNo_carte($no_carte) {
        $this->no_carte = $no_carte;
    }

    function setCredit_carte($credit_carte) {
        $this->credit_carte = $credit_carte;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setE_mail($e_mail) {
        $this->e_mail = $e_mail;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function getNo_carte() {
        return $this->no_carte;
    }

    function getCredit_carte() {
        return $this->credit_carte;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getE_mail() {
        return $this->e_mail;
    }

    function getTelephone() {
        return $this->telephone;
    }

    public static function getAll() {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Client'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Client($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    /** A partir du no_carte, on retourne les infos du client* */
    public static function getInfosClient($id_carte) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT *
                FROM Client WHERE no_carte = :id'); // prepare le cod 

        oci_bind_by_name($stid, ':id', $id_carte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        $client = new Client($row);
        return $client;
    }

    public static function delete($nocarte) {
        $oci = Base::getConnexion();
        Panier::delete($nocarte);
        $stid = oci_parse($oci, "DELETE FROM CLIENT where NO_CARTE = :nocarte");
        oci_bind_by_name($stid, ':carte', $noCarte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

    public function update() {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE Client SET credit_carte = :credit, nom = :nom, prenom = :prenom, adresse = :adresse, e_mail = :email, telephone = :telephone where no_carte = :nocarte");
        oci_bind_by_name($stid, ':credit', $this->credit_carte);
        oci_bind_by_name($stid, ':nom', $this->nom);
        oci_bind_by_name($stid, ':prenom', $this->prenom);
        oci_bind_by_name($stid, ':adresse', $this->adresse);
        oci_bind_by_name($stid, ':email', $this->e_mail);
        oci_bind_by_name($stid, ':telephone', $this->telephone);
        oci_bind_by_name($stid, ':nocarte', $this->no_carte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
    }

}
