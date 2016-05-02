<?php
require_once('common.php');




$promotion = Promotion::getPromotion('1951761830');

var_dump($promotion);

echo('Test du verifnbLivraisons');
$p = Planning::verifNombreLivraison('21/03/2096 12');

var_dump($p);
echo('Test du existPlanning (qui doit exister: ');
var_dump(Planning::existPlanning('21/03/2096 12'));
echo('Test quand la date existe pas');
var_dump(Planning::existPlanning('30/03/2096 12'));

echo ('Insertion du planning par defaut');
Planning::insertDefaultPlanning();
echo("tentative d'une deuxieme insertion du planning par def, doit repondre qu'il peut pas ");
Planning::insertDefaultPlanning();

echo("Insertion d'un planning ");

Planning::insertPlanning('21/03/96 12', '3');

var_dump(Planning::getAll());
var_dump(Item::getInfosPanier('1223129340'));
echo(",,,,,");
var_dump(Item::existProduitDansPanier('1223129340', '12431574596446974350'));
//Item::insertUnProduit('1223129340', '12431574596446974350', '3');
//Item::insertUnProduit('1223129340', '12595663421373637890', '3');

var_dump(Item::getInfosPanier('1223129340'));

/**
--INSERT INTO panier VALUES (1117144480,To_Date('21/03/2096 12','dd/mm/yyyy hh24'), 'F', NULL, NULL);
SELECT * FROM Planning JOIN Panier USING(date_heure) WHERE date_heure = to_date('21.03.2096 12','dd/mm/yyyy hh24');
**/


    /**En fonction de la date, on renvoit vrai si on peut rajouter un panier à cette date faux sinon**/
    /*public static function verifNombreLivraison($date) {
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        $stid = oci_parse($oci, "SELECT count(*) FROM Planning WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')"); // prepare le code
        oci_bind_by_name($stid, ':id', $date);

        $r = oci_execute($stid); // on l'execute
        if (!$r) {
            $e = oci_error($stid);
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);
        
        $stid2 = oci_parse($oci, "SELECT nombre_livraison_max FROM Planning WHERE date_heure = to_date(:id,'dd/mm/yyyy hh24')");
        $r2 = oci_execute($stid); // on l'execute
        if (!$r2) {
            $e2 = oci_error($stid);
            trigger_error(htmlentities($e2['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $row2 = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_NULLS);
        var_dump((int)$row2);
        var_dump((int)$row1);
        if($row['count'] < $row2['nombre_livraison_max']){
            return true;
        }
        return false;
    } */