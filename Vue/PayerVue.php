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
                    <h3>Vous venez d'être débité</h3>
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
                        echo("<h3>Montant à payer :" . $this->prixAPayer . " euros</h3>");
                        ?>
                        <h3>Veulliez choisir la date de retrait</h3>
                        <link rel="stylesheet" type="text/css" href="lib/datetimepicker/jquery.datetimepicker.css"/>

                        <script src="lib/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>                       
                            <script type="text/javascript">
                                $(function () {

                                    $('#datetimepicker12').datetimepicker({
                                        inline: true,
                                        sideBySide: true,
                                        minDate: 0,
                                        onGenerate: function (ct) {
                                            jQuery(this).find('.xdsoft_date.xdsoft_weekend')
                                                    .addClass('xdsoft_disabled');
                                        },
                                        weekends: ['01.01.2014', '02.01.2014', '03.01.2014', '04.01.2014', '05.01.2014', '06.01.2014'],
                                        allowTimes: [
                                            '8:00','8:30','9:00','9:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'
                                        ]
                                    });
                                });
                            </script>
                        

                        <form class="form-inline" action="drive.php?a=Payer&c=validPayement" method="post">
                            <input id="datetimepicker12" type="text" value="" name="date" required/>
                            <input type="hidden" name="eurosCarte" value="<?php echo($this->eurosCarte) ?>">
                            <input type="hidden" name="eurosADeduire" value="<?php echo($this->eurosAEnlever) ?>">
                            <button type="submit" name="submit" style="display: block; width: 30%;" class="btn btn-success">Finaliser</button>
                        </form>
                        <?php
                    }
                }
                ?>
            </div>
        </body>
        <?php
    }

}
