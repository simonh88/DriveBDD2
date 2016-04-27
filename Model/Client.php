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

    public static function getAll() { // exemple, a suprimer
        $oci = Base::getConnexion(); // on recupere la connexion a la base de donnée
        
        $stid = oci_parse($conn, 'SELECT * FROM Client'); // prepare le code
        oci_execute($stid); // on l'execute
        
    }

    public static function getNoCarte($nocarte) {
        
    }
    //oci_commit($conn); pour commt insert / delete / update
}

?>
