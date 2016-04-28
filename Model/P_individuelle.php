<?php

class P_individuelle extends Promotion{
	
    private $code_promo;
    private $reduction_absolue;
    private $reduction_relative;
    private $immediate_VF;
        
    //GETTER
    function getCode_promo() {
        return $this->code_promo;
    }

    function getReduction_absolue() {
        return $this->reduction_absolue;
    }

    function getReduction_relative() {
        return $this->reduction_relative;
    }

    function getImmediate_VF() {
        return $this->immediate_VF;
    }

    //SETTER
    function setCode_promo($code_promo) {
        $this->code_promo = $code_promo;
    }

    function setReduction_absolue($reduction_absolue) {
        $this->reduction_absolue = $reduction_absolue;
    }

    function setReduction_relative($reduction_relative) {
        $this->reduction_relative = $reduction_relative;
    }

    function setImmediate_VF($immediate_VF) {
        $this->immediate_VF = $immediate_VF;
    }



}
