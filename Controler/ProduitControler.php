<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ProduitController extends Controller{
    
    
        static $action = array(
            //TODO plus d'action possible ( une action = 1 URL : drive.com/a=Accueil renvera sur la fonction static home()
                    "Accueil" => "home" //accueil
                    
);
        
        public function home() {
            
        /*$view = new AccueilView();
	$view->displayPage();*/
        }
}
