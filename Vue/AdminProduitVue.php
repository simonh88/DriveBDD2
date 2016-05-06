<?php

class AdminProduitVue extends AdminHomeVue {

    var $res;

    public function __construct($resultat = null) {
        $this->res = $resultat;
        parent::__construct();
    }

    public function displayBody() {
        ?><a href="drive.php?acces=Admin&a=AjoutProduit" style="display: block; width: 100%;" class="btn btn-success">Ajouter un produit</a>
        <form class="form-inline" action="drive.php?acces=Admin&a=Recherche" method="post">
            <div class="form-group">
                <label for="exampleInputName2">Recherche : </label>
                <input type="text" class="form-control" id="exampleInputName2" placeholder="Reference du Produit">
            </div>
            <button type="submit" class="btn btn-default">Recherche du produit</button>
        </form>

        <?php
        if ($this->res == null) {
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
                    <th> Modifier </th>
                    <th> Supprimer </th>
                </tr>
                <?php
                foreach ($allProduit as $produit) {
                    ?>
                    <tr>
                        <th><img src="<?php echo $produit->getFichier_image() ?>" height="42"></th>
                        <th><?php echo $produit->getReference() ?></th>
                        <th><?php echo $produit->getLibelle() ?></th>
                        <th><?php echo $produit->getPrix_unit_HT() ?></th>
                        <th><?php echo $produit->getPrix_kilo_ou_litre() ?></th>
                        <th><?php echo $produit->getMarque() ?></th>
                        <th><?php echo $produit->getQuandtite_stock() ?></th>
                        <th><?php echo $produit->getLiquide_VF() ?></th>
                        <th><a href="drive.php?acces=Admin&a=ModifProduit&id=<?php echo $produit->getReference() ?>" class="btn btn-info text-right" role="button">Modifier</a></th>  
                        <th><a href="drive.php?acces=Admin&a=SuprProduit&id=<?php echo $produit->getReference() ?>" class="btn btn-danger text-right" role="button">Supprimer le Produit</a></th>
                    </tr>



                    <?php
                }
                ?>

            </table>
            <?php
        }
    }

    /*
     * boissons.jpg
     * fruits_legumes.jpg
     * viandes.jpg
     * poissons.jpg
     */
}
