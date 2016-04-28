<?php

class P_lot extends Promotion{
	private $nb_achetes;
	private $nb_gratuits;
        
        function __construct($row) {
            parent::__construct(array_slice($row,0,4));
            $this->nb_achetes = $row['NB_ACHETES'];
            $this->nb_gratuits = $row['NB_GRATUITS'];
        }

        
        //GETTER

        function getNb_achetes() {
            return $this->nb_achetes;
        }

        function getNb_gratuits() {
            return $this->nb_gratuits;
        }

        //SETTER

        function setNb_achetes($nb_achetes) {
            $this->nb_achetes = $nb_achetes;
        }

        function setNb_gratuits($nb_gratuits) {
            $this->nb_gratuits = $nb_gratuits;
        }


        
    

}