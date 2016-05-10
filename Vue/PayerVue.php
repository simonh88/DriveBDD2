<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PayerVue extends MainVue {

    private $infos;
    private $isPayer;
    private $eurosCarte;
    private $prixAPayer;
    private $eurosAEnlever;

    public function __construct($infos, $isPayer, $eurosCarte, $prixAPayer, $eurosAEnlever) {
        $this->infos = $infos;
        $this->isPayer = $isPayer;
        $this->eurosCarte = $eurosCarte;
        $this->prixAPayer = $prixAPayer;
        $this->eurosAEnlever = $eurosAEnlever;
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
                    <h3>Vous avez utilisez <?php echo($this->eurosAEnlever); ?> euro(s) de votre carte</h3>
                    <h3>Votre nouveau solde de votre carte : <?php echo($this->eurosCarte) ?> euro(s)</h3>
                    
                    <?php
                } else {
                    if (!($this->infos->getMontant() > 0)) {
                        ?>
                        <div class="alert alert-warning"><strong>Attention!</strong> Votre panier est pour l'instant vide.</div>
                        <button type="button" class="btn btn-success disabled">Payer</button>
                        <?php
                    } else {
                        echo("<h3>Montant à payer :" . $this->prixAPayer ." euros</h3>");
                        ?>
                         <form class="form-inline" action="drive.php?a=Payer&c=validPayement" method="post" id="isPayer">
                             <input type="hidden" name="eurosCarte" value="<?php echo($this->eurosCarte) ?>">
                             <input type="hidden" name="eurosADeduire" value="<?php echo($this->eurosAEnlever) ?>">
                             <button type="submit" class="btn btn-success" form="isPayer">Payer</button>
                         </form>
                <?php }} ?>
                </div>
            </body>
            <?php
        }
    }
    