<?php

class Item {

    private $no_carte;
    private $reference;
    private $quantite;

    function __construct($row) {
        $this->no_carte = $row['NO_CARTE'];
        $this->reference = $row['REFERENCE'];
        $this->quantite = $row['QUANTITE'];
    }

    //GETTER
    function getNo_carte() {
        return $this->no_carte;
    }

    function getReference() {
        return $this->reference;
    }

    function getQuantite() {
        return $this->quantite;
    }

    //SETTER
    function setNo_carte($no_carte) {
        $this->no_carte = $no_carte;
    }

    function setReference($reference) {
        $this->reference = $reference;
    }

    function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, 'SELECT * FROM Item'); // prepare le code
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $client = new Item($row);
            $data[$i] = $client;
            $i++;
        }

        return $data;
    }

    /*     * à partir du no_carte on recup le contenu du panier* */

    public static function getInfosPanier($id_carte) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT *
                FROM Item WHERE no_carte = :id'); // prepare le cod 

        oci_bind_by_name($stid, ':id', $id_carte);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $data = array();
        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $item = new Item($row);
            $data[$i] = $item;
            $i++;
        }
        return $data;
    }

    /** fonction testant la présence d'un produit ou non dans un panier * */
    public static function existProduitDansPanier($noCarte, $ref) {
        var_dump($noCarte);
        var_dump($ref);
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT count(*) as nb FROM Item WHERE reference LIKE :id and no_carte = :no ");
        $ref = $ref."%";
        oci_bind_by_name($stid, ':id', $ref);
        oci_bind_by_name($stid, ':no', $noCarte);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        var_dump($row);
        if ($row['NB'] == 1) {
                        echo("Bonjour");
            return true;
        }
        return false;
    }

    /** Inserer un produit avec sa reference et sa quantite* */
    public static function insertUnProduit($noCarte, $ref, $quant) {
        //S'il existe pas on peut l'ajouter
        
        if (!Item::existProduitDansPanier($noCarte, $ref)) {
            echo("Bonjour");
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $stid = oci_parse($oci, "INSERT INTO Item VALUES (:carte,:ref,:quant)");
            oci_bind_by_name($stid, ':carte', $noCarte);
            oci_bind_by_name($stid, ':ref', $ref);
            oci_bind_by_name($stid, ':quant', $quant);
            $r = oci_execute($stid); // on l'execute
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            Panier::setPrix($noCarte);
        }
        //Sinon on fait rien.
    }

    /**Supprime un seul produit**/
    public static function deleteUnProduit($noCarte, $ref) {
        //S'il existe pas on peut l'ajouter
        if (Item::existProduitDansPanier($noCarte, $ref)) {
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $stid = oci_parse($oci, "DELETE FROM Item WHERE reference LIKE :ref and no_carte = :carte");
            $ref = $ref."%";
            oci_bind_by_name($stid, ':carte', $noCarte);
            oci_bind_by_name($stid, ':ref', $ref);
            $r = oci_execute($stid); // on l'execute
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            Panier::setPrix($noCarte);
        }
        //Sinon on fait rien.
    }
    
    /**Supprime tout le contenu du panier.**/
    public static function deleteAll($noCarte){
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $stid = oci_parse($oci, "DELETE FROM Item WHERE no_carte = :carte");
            oci_bind_by_name($stid, ':carte', $noCarte);
            $r = oci_execute($stid); // on l'execute
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            Panier::setPrix($noCarte);
    }

    public function update() {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE Item SET quantite = :q where no_carte = :nocarte and reference LIKE :ref");
        $ref = $this->getReference()."%";
        oci_bind_by_name($stid, ':q', $this->getQuantite());
        oci_bind_by_name($stid, ':ref', $ref);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        Panier::setPrix($nocarte);
    }
}
