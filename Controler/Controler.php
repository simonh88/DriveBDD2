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
	    if (array_key_exists($_GET['a'], static::$action)) {
		$actionS = static::$action[$_GET['a']];
		
		return $actionS;
	    } else {
		return 'home';
	    }
	} else {
	    return 'home';
	}
    }
    
    /**
     * fonction home du controller si aucun champs n'est rensigné
     */
    abstract function home();
}
