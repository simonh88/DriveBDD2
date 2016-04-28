<?php

class Objet_promo{
    private $code_promo;
    private $reference;
    
    //GETTER
    function getCode_promo() {
        return $this->code_promo;
    }

    function getReference() {
        return $this->reference;
    }

    //SETTER
    function setCode_promo($code_promo) {
        $this->code_promo = $code_promo;
    }

    function setReference($reference) {
        $this->reference = $reference;
    }


}
