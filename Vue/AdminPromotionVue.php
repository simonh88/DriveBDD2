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
                                <th>Action</th>
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
                                    <td><a href="drive.php?acces=Admin&a=SuprPromo&id=<?php echo $indi->getCode_promo() ?>" class="btn btn-danger" role="button">Supprimer</a></td>
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
                                <th>Action</th>
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
                                    <td><a href="drive.php?acces=Admin&a=SuprPromo&id=<?php echo $lot->getCode_promo() ?>" class="btn btn-danger" role="button">Supprimer</a></td>
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
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Produits en Promotion
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>Logo</th>
                                <th>Reference</th>
                                <th>Libelle</th>
                                <th>Marque</th>
                                <th>Type de Promo</th>
                                <th>Code_Promo</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $item = Objet_promo::getAll();
                            foreach ($item as $objet) {
                                $produit = Produit::getProduit($objet->getReference());
                                $promo = Promotion::getPromotion($objet->getCode_promo());
                                ?>
                                <tr>
                                    <td><img src="<?php echo $produit->getFichier_image() ?>" height="42"></td>
                                    <td><?php echo $produit->getReference() ?></td>
                                    <td><?php echo $produit->getLibelle() ?></td>
                                    <td><?php echo $produit->getMarque() ?></td>
                                    <td><?php
                                        if ($promo instanceof P_lot)
                                            echo "Par Lot";
                                        else
                                            echo "Individuelle";
                                        ?></td>
                                    <td><?php echo $promo->getCode_promo() ?></td>
                                    <td><a href="drive.php?acces=Admin&a=SuprObjet&id=<?php echo $produit->getReference() ?>" class="btn btn-danger" role="button">Supprimer</a></td>
                                </tr>

                                <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}
