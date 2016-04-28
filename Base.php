<?php

class Base {

    /**
     * Connexion en cours
     */
    private static $db;

    /**
     * Retourne la connexion, en crée une si besoin
     * @return PDO connexion
     */
    static public function getConnexion() {
        if (isset($db)) {
            return $db;
        } else {

            $database = new Database();

// Connexion au service XE (i.e. la base de données) sur la machine "localhost"
            $db = oci_connect(database::$user, database::$password, database::$host);
            if (!$db) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            return $db;
        }
    }

}
