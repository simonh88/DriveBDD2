<?php

class P_lot extends Promotion{
        private $code_promo;
	private $nb_achetes;
	private $nb_gratuits;
        
        //GETTER
        function getCode_promo() {
            return $this->code_promo;
        }

        function getNb_achetes() {
            return $this->nb_achetes;
        }

        function getNb_gratuits() {
            return $this->nb_gratuits;
        }

        //SETTER
        function setCode_promo($code_promo) {
            $this->code_promo = $code_promo;
        }

        function setNb_achetes($nb_achetes) {
            $this->nb_achetes = $nb_achetes;
        }

        function setNb_gratuits($nb_gratuits) {
            $this->nb_gratuits = $nb_gratuits;
        }


        
    

}