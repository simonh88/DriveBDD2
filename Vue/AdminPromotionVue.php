<?php

class AdminPromotionVue extends AdminHomeVue {

    public function displayBody() {
        ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">

                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Promotion Individuel
                        </a>
                        <a href="drive.php?acces=Admin&a=AjoutPromoIndi" class="btn btn-info pull-right" role="button">Ajouter une Promo</a>
                    </h4>

                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Code</th>
                                <th>Debut</th>
                                <th>Fin</th>
                                <th>Limite</th>
                                <th>Reduction</th>
                                <th>Application</th>                                                                
                            </tr>
                            <?php
                            $promoIndi = P_individuelle::getAll();
                            foreach ($promoIndi as $indi) {
                                ?>
                                <tr>
                                    <td><?php echo $indi->getCode_promo() ?></td>
                                    <td><?php echo $indi->getDate_debut() ?></td>
                                    <td><?php echo $indi->getDate_fin() ?></td>
                                    <td><?php echo $indi->getMax_par_client() ?></td>
                                    <td><?php
                                        if ($indi->getReduction_absolue() != null)
                                            echo $indi->getReduction_absolue() . " €";
                                        else
                                            echo $indi->getReduction_relative() . " %";
                                        ?></td>
                                    <td><?php
                                        if ($indi->getImmediate_VF() == 1)
                                            echo "Immediat";
                                        else
                                            echo "Cagnotte";
                                        ?></td>

                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Promotion par Lot
                        </a>
                        <a href="drive.php?acces=Admin&a=AjoutPromoLot" class="btn btn-info pull-right" role="button">Ajouter une Promo</a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Code</th>
                                <th>Debut</th>
                                <th>Fin</th>
                                <th>Limite</th>
                                <th>Nombre Acheté</th>
                                <th>Nombre Offert</th>                                                                
                            </tr>
                            <?php
                            $promoLot = P_lot::getAll();
                            foreach ($promoLot as $lot) {
                                ?>
                                <tr>
                                    <td><?php echo $lot->getCode_promo() ?></td>
                                    <td><?php echo $lot->getDate_debut() ?></td>
                                    <td><?php echo $lot->getDate_fin() ?></td>
                                    <td><?php echo $lot->getMax_par_client() ?></td>
                                    <td><?php echo $lot->getNb_achetes() ?></td>
                                    <td><?php echo $lot->getNb_gratuits() ?></td>

                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        }

    }
    