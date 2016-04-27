<?php

/**
 * Classe générique des contrôleurs
 *
 */
abstract class Controller {

    
    /**
     * fonction d'appel des controller en fonction du Get[a]
     */
    public static function callAction() {
        
	if (isset($_GET['a'])) {
	    if (array_key_exists($_GET['a'], static::$action)) { // site.com/a=XXX
		$actionS = static::$action[$_GET['a']]; // XXX represete
		
		return $actionS;
	    } else {
		return 'home';
	    }
	} else { // HOME fonction par defaut ..un genre 404 quoi
	    return 'home';
	}
    }
    
    /**
     * fonction home du controller si aucun champs n'est rensigné
     */
    abstract function home();
}
