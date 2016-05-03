<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PayerVue extends MainVue {
    
    private $infos;
    
    public function __construct($infos) {
        $this->infos = $infos;
        parent::__construct("Payer panier");
    }
    
    
    public function displayBody() {
        ?>
        <body>
            <div class="container">
                <?php echo("Montant à payer :". $this->infos->getMontant()); ?>
                <button type="button" class="btn btn-success">Payer</button>
            </div>
        </body>
        <?php
    }

}

