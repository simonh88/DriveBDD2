<?php

class AdminProduitVue extends AdminHomeVue {

    var $res;

    public function __construct($resultat = null) {
        $this->res = $resultat;
        parent::__construct();
    }

    public function displayBody() {
        $allProduit = Produit::getAll();
        ?>

        <table class="table table-striped">
            <tr>
                <th>Logo</th>
                <th>References</th>
                <th>Libelle</th>
                <th>Prix HT</th>
                <th>Prix / Kg</th>
                <th>marque</th>
                <th>Quantite Stock</th>
                <th>Liquide</th>
            </tr>
            <?php
            foreach ($allProduit as $produit) {
                ?>
            <tr>
                <th><img src="<?php echo $produit->getFichier_image() ?>" height="42"></th>
                <th><?php echo $produit->getReference()?></th>
                <th><?php echo $produit->getLibelle()?></th>
                <th><?php echo $produit->getPrix_unit_HT()?></th>
                <th><?php echo $produit->getPrix_kilo_ou_litre()?></th>
                <th><?php echo $produit->getMarque()?></th>
                <th><?php echo $produit->getQuandtite_stock()?></th>
                <th><?php echo $produit->getLiquide_VF()?></th>
            </tr>



                <?php
            }
            ?>

        </table>
        <?php
    }
    /*
     * boissons.jpg
     * fruits_legumes.jpg
     * viandes.jpg
     * poissons.jpg
     */

}
