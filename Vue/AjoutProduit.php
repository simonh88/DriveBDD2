<?php

class AjoutProduit extends AdminHomeVue {

    var $msg;
    var $produit;

    public function __construct($msg = false) {
        $this->msg = $msg;
        parent::__construct();
    }

    public function displayBody() {
        if ($this->msg) {
            ?><div class="alert alert-danger" role="alert"><?php echo $this->msg ?></div><?php
        }
        ?>

        <form method="post" action="drive.php?acces=Admin&a=AjoutProduit" enctype="multipart/form-data">

            <div class="form-group">
                <label for="reference">Reference</label>
                <input type="number" class="form-control" id="ref" placeholder="reference"name="ref" required> 
            </div>
            <div class="form-group">
                <label for="Libelle">Libelle</label>
                <input type="text" class="form-control" id="lib" placeholder="libelle"name="lib" required >
            </div>
            <div class="form-group">
                <label for="Marque">Marque</label>
                <input type="text" class="form-control" id="marq" placeholder="Marque"name="marq" required>
            </div>
            <div class="form-group">
                <label for="Prix">Prix</label>
                <input type="number" class="form-control" id="prix" placeholder="Prix"name="prix" required>
            </div>

            <div class="form-group">
                <label for="Liquide">Est ce Liquide</label>
                <input type="checkbox" class="form-control" id="liqu" value="V"name="liqu">
            </div>

            <div class="form-group">
                <label for="Prix au Kilo">Kilo</label>
                <input type="number" class="form-control" id="kilo" placeholder="Kilo"name="kilo" required>
            </div>

            <div class="form-group">
                <label for="Quantité Stock">Quantité Stock</label>
                <input type="number" class="form-control" id="qute" placeholder="Stock"name="qute" required>
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input type="file" id="img" accept="image/*" name="img" required>
            </div>


            <div class="form-group">
                <label for="img">Sous Rayon ou Sous Sous rayon</label>
                <select name="sous" required>
                    <option disabled>─SousRayon─</option>
                    <?php
                    $sr = Sous_rayon::getAll();
                    foreach ($sr as $value) {
                        echo("<option>" . $value->getNom() . "</option>");
                    }
                    ?>
                    <option disabled>─SousSousRayon─</option>
                    <?php
                    $ssr = Sous_sous_rayon::getAll();
                    foreach ($ssr as $value) {
                        echo("<option>" . $value->getNom() . "</option>");
                    }
                    ?>           
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-default">Créer</button>
        </form>



        <?php
    }

}
