<?php

class AjoutProduit extends AdminHomeVue {

    var $msg;
    var $produit;

    public function __construct($msg = false) {
        $this->msg = $msg;
        if (isset($_GET["ref"])) {
            $this->produit = Produit::getProduit($_GET["ref"]);
        }
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
                <input type="number" class="form-control" id="ref" placeholder="reference"name="ref">
            </div>
            <div class="form-group">
                <label for="Libelle">Libelle</label>
                <input type="text" class="form-control" id="lib" placeholder="libelle"name="lib">
            </div>
            <div class="form-group">
                <label for="Marque">Marque</label>
                <input type="text" class="form-control" id="marq" placeholder="Marque"name="marq">
            </div>
            <div class="form-group">
                <label for="Prix">Prix</label>
                <input type="number" class="form-control" id="prix" placeholder="Prix"name="prix">
            </div>

            <div class="form-group">
                <label for="Liquide">Est ce Liquide</label>
                <input type="checkbox" class="form-control" id="liqu" value="V"name="liqu">
            </div>

            <div class="form-group">
                <label for="Prix au Kilo">Kilo</label>
                <input type="number" class="form-control" id="kilo" placeholder="Kilo"name="kilo">
            </div>

            <div class="form-group">
                <label for="Quantité Stock">Quantité Stock</label>
                <input type="number" class="form-control" id="qute" placeholder="Stock"name="qute">
            </div>

            <div class="form-group">
                <label for="img">Image</label>
                <input type="file" id="img" accept="image/*" name="img">
            </div>

            <button type="submit" name="submit" class="btn btn-default">Créer</button>
        </form>



        <?php
    }

}
