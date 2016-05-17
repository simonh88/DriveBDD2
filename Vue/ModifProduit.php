<?php

class ModifProduit extends AdminHomeVue {

    var $msg;
    var $produit;

    public function __construct($msg = false) {
        $this->msg = $msg;
        if (isset($_GET["id"])) {
            $this->produit = Produit::getProduit($_GET["id"]);
        }
        parent::__construct();
    }

    public function displayBody() {
        if ($this->msg) {
            ?><div class="alert alert-danger" role="alert"><?php echo $this->msg ?></div><?php
        }
        ?>

        <form method="post" action="drive.php?acces=Admin&a=ModifProduit" enctype="multipart/form-data">

            <div class="form-group">
                <label for="reference">Reference</label>
                <input type="number" class="form-control" id="ref" placeholder="reference" name="ref" readonly value="<?php echo $this->produit->getReference() ?>"> 
            </div>
            <div class="form-group">
                <label for="Libelle">Libelle</label>
                <input type="text" class="form-control" id="lib" placeholder="libelle"name="lib"  value="<?php echo $this->produit->getLibelle() ?>">
            </div>
            <div class="form-group">
                <label for="Marque">Marque</label>
                <input type="text" class="form-control" id="marq" placeholder="Marque"name="marq" value="<?php echo $this->produit->getMarque() ?>">
            </div>
            <div class="form-group">
                <label for="Prix">Prix</label>
                <input type="number" class="form-control" id="prix" step="0.01" placeholder="Prix"name="prix" value="<?php echo $this->produit->getPrix_kilo_ou_litre() ?>">
            </div>

            <div class="form-group">
                <label for="Liquide">Est ce Liquide</label>
                <input type="checkbox" class="form-control" id="liqu" value="V" name="liqu"<?php if ($this->produit->getLiquide_VF() == "V") { ?>checked<?php } ?>>
            </div>

            <div class="form-group">
                <label for="Prix au Kilo">Kilo</label>
                <input type="number" class="form-control" id="kilo" placeholder="Kilo"name="kilo" value="<?php echo $this->produit->getPrix_kilo_ou_litre() ?>">
            </div>

            <div class="form-group">
                <label for="Quantité Stock">Quantité Stock</label>
                <input type="number" class="form-control" id="qute" placeholder="Stock"name="qute" value="<?php echo $this->produit->getQuandtite_stock() ?>">
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <img src="<?php echo $this->produit->getFichier_image() ?>" height="42">
                <input type="file" id="img" accept="image/*" name="img" value="<?php echo $this->produit->getFichier_image() ?>">
            </div>


            <div class="form-group">
                <label for="img">Sous Rayon ou Sous Sous rayon</label>
                <select name="sous" required>
                    <option disabled>─SousRayon─</option>
                    <?php
                    $sr = Sous_rayon::getAll();
                    foreach ($sr as $value) {
                        if (SR_P::getSR($this->produit->getReference()) == $value->getNom()) {
                            echo("<option selected>" . $value->getNom() . "</option>");
                        } else {

                            echo("<option>" . $value->getNom() . "</option>");
                        }
                    }
                    ?>
                    <option disabled>─SousSousRayon─</option>
                    <?php
                    $ssr = Sous_sous_rayon::getAll();
                    foreach ($ssr as $value) {
                        if (SSR_P::getSSR($this->produit->getReference()) == $value->getNom()) {
                            echo("<option selected>" . $value->getNom() . "</option>");
                        } else {

                            echo("<option>" . $value->getNom() . "</option>");
                        }
                    }
                    ?>           
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-default">Modifier</button>
        </form>



        <?php
    }

}
