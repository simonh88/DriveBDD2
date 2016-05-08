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
        if (isset(Base::$db)) {            
            return Base::$db;
        } else {

            $database = new Database();

// Connexion au service XE (i.e. la base de données) sur la machine "localhost"
            Base::$db = oci_connect(database::$user, database::$password, database::$host);
            if (!Base::$db) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            return Base::$db;
        }
    }

}
