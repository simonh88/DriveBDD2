<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PayerVue extends MainVue {

    private $infos;
    private $isPayer;

    public function __construct($infos, $isPayer) {
        $this->infos = $infos;
        $this->isPayer = $isPayer;
        parent::__construct("Payer panier");
    }

    public function displayBody() {
        ?>
        <body>
            <div class="container">
                <?php
                if ($this->isPayer == true) {
                    ?>
                    <div class="alert alert-success"><strong>Félicitation !</strong> Vous venez de payer votre panier</div>
                    <?php
                } else {
                    if (!($this->infos->getMontant() > 0)) {
                        ?>
                        <div class="alert alert-warning"><strong>Attention!</strong> Votre panier est pour l'instant vide.</div>
                        <button type="button" class="btn btn-success disabled">Payer</button>
                        <?php
                    } else {
                        echo("Montant à payer :" . $this->infos->getMontant());
                        ?>
                        <a href="drive.php?a=Payer&c=validPayement"><button type="button" class="btn btn-success">Payer</button>
                <?php }} ?>
                </div>
            </body>
            <?php
        }
    }
    