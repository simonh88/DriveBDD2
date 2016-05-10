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

    public static function getAll() {
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
            $item = new Item($row);
            $data[$i] = $item;
            $i++;
        }

        return $data;
    }

    public static function getUnProduit($id_carte, $ref) {
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, 'SELECT *
                FROM Item WHERE no_carte = :id and reference = :ref'); // prepare le cod 

        oci_bind_by_name($stid, ':id', $id_carte);
        oci_bind_by_name($stid, ':ref', $ref);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        $item = new Item($row);
        return $item;
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
    public static function getQuantiteDansPanier($noCarte, $ref) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT quantite FROM Item WHERE reference = :id and no_carte = :no ");
//
        oci_bind_by_name($stid, ':id', $ref);
        oci_bind_by_name($stid, ':no', $noCarte);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        return $row["QUANTITE"];
    }

    /** fonction testant la présence d'un produit ou non dans un panier * */
    public static function existProduitDansPanier($noCarte, $ref) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT count(*) as nb FROM Item WHERE reference = :id and no_carte = :no ");
//
        oci_bind_by_name($stid, ':id', $ref);
        oci_bind_by_name($stid, ':no', $noCarte);
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

    /** Inserer un produit avec sa reference et sa quantite* */
    public static function insertUnProduit($noCarte, $ref, $quant) {
//S'il existe pas on peut l'ajouter

        if (!Item::existProduitDansPanier($noCarte, $ref)) {
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
            Produit::updateStockQuantite($ref, $quant);
        } else {
            
        }
//Sinon on fait rien.
    }

    /*     * Supprime un seul produit* */

    public static function deleteUnProduit($noCarte, $ref, $quant) {
//S'il existe pas on peut l'ajouter
        if (Item::existProduitDansPanier($noCarte, $ref)) {
            $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
            $qDansPanier = Item::getQuantiteDansPanier($noCarte, $ref);
            if ($quant == -$qDansPanier) {
                $stid = oci_parse($oci, "DELETE FROM Item WHERE reference = :ref and no_carte = :carte"); //On delet le produit
            } else {
                $stid = oci_parse($oci, "UPDATE Item SET quantite = :q where no_carte = :carte and reference = :ref"); //On update la quantite
                $qfinal = $qDansPanier + $quant;
                oci_bind_by_name($stid, ':q', $qfinal);
            }
//
            oci_bind_by_name($stid, ':carte', $noCarte);
            oci_bind_by_name($stid, ':ref', $ref);
            $r = oci_execute($stid); // on l'execute
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            Panier::setPrix($noCarte);
            Produit::updateStockQuantite($ref, $quant);
        }
//Sinon on fait rien.
    }

    /*     * Supprime tout le contenu du panier.* */

    public static function deleteAll($noCarte) {
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

    public function update($qte) {//$qte est la quantite à update
        $oci = Base::getConnexion();
        $stid = oci_parse($oci, "UPDATE Item SET quantite = :q where no_carte = :nocarte and reference = :ref");
        $quant = $this->getQuantite();
        $carte = $this->getNo_carte();
        $ref = $this->getReference();
        oci_bind_by_name($stid, ':q', $quant);
        oci_bind_by_name($stid, ':nocarte', $carte);
        oci_bind_by_name($stid, ':ref', $ref);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        Panier::setPrix($carte);
        Produit::updateStockQuantite($ref, $qte);
    }

    public static function calculPromotion($no_carte) {


// tableau[$i]["reference"]
// tableau[$i]["quantiteé"]
// tableau[$i]["prixFinal"]
// tableau[$i]["cagnotte"]

        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée

        $stid = oci_parse($oci, "SELECT code_promo, libelle, marque, reference, quantite, prix_unit_ht, date_debut, date_fin, max_par_client "
                . "FROM ITem JOIN Produit USING(reference) JOIN Objet_Promo USING(reference) JOIN PROMOTION USING(code_promo) "
                . "WHERE no_carte = :carte and TRUNC(date_debut) <= TRUNC(SYSDATE) AND  TRUNC(date_fin) >= TRUNC(SYSDATE)"); // prepare le code

        oci_bind_by_name($stid, ':carte', $no_carte);
        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $data = array();

        $i = 0;
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            $data[$i] = $row;
            $i++;
        }

        $calcul = array();
        $client = Client::getInfosClient($no_carte);
        $i = 0;

        var_dump($data);
        foreach ($data as $ligne) {
            var_dump($ligne["REFERENCE"]);
            $reference = $ligne["REFERENCE"];
            $quantite = $ligne["QUANTITE"];
            $prixFinal = 0;
            $cagnotte = 0;


            $produit = Produit::getProduit($ligne["REFERENCE"]);


            if ($ligne["MAX_PAR_CLIENT"] - $ligne["QUANTITE"] >= 0)
                $limite = $ligne["QUANTITE"];
            else
                $limite = $ligne["MAX_PAR_CLIENT"];

            $promo = P_lot::getPromotion($ligne['CODE_PROMO']);

            if (empty($promo->getCode_promo())) { // INDIVIDUEL
                $promo = P_individuelle::getPromotion($ligne['CODE_PROMO']);
                for ($index = 0; $index < $limite; $index++) {
                    if ($promo->getImmediate_VF() == "F") { //Cagnotte
                        if (!empty($promo->getReduction_absolue())) { // €
                            $cagnotte += $promo->getReduction_absolue();
                            $prixFinal += $ligne["PRIX_UNIT_HT"];
                        } else { // %
                            $cagnotte += $ligne["PRIX_UNIT_HT"] * ($promo->getReduction_relative() / 100);
                            $prixFinal += $ligne["PRIX_UNIT_HT"];
                        }
                    } else { // remise immediat
                        if (!empty($promo->getReduction_absolue())) { // €
                            $prixFinal += $ligne["PRIX_UNIT_HT"] - $promo->getReduction_absolue();
                        } else { // %
                            $prixFinal += $ligne["PRIX_UNIT_HT"] - ($ligne["PRIX_UNIT_HT"] * ($promo->getReduction_relative() / 100));
                        }
                    }
                }
            } else { // PAR LOT
                $quantieMax = $ligne["MAX_PAR_CLIENT"];
                $nbAchetes = $promo->getNb_achetes();
                $nbGratuit = $promo->getNb_gratuits();

                $prixFinal = $ligne["PRIX_UNIT_HT"] * $quantite;

                for ($index1 = 0; $index1 < $quantite; $index1++) {
                    if ($index1 < $quantieMax && $index1 % $nbAchetes == 0) {
                        $quantite += $nbGratuit;
                    }
                }
            }

            $calcul[$i]["REFERENCE"] = $reference;
            $calcul[$i]["QUANTITE"] = $quantite;
            $calcul[$i]["PIRXFINAL"] = $prixFinal;
            $calcul[$i]["CAGNOTTE"] = $cagnotte;
            $calcul[$i]["LIBELLE"] = $ligne["LIBELLE"];
            $calcul[$i]["MARQUE"] = $ligne["MARQUE"];
            $i++;
            
            
            
        }
        return $calcul;
    }

}
