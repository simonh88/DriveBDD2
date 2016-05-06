<?php

class ProduitVue extends MainVue {

    private $tableau;
    private $where;

    public function __construct($tableauProduit, $where) {
        parent::__construct("Produit");
        $this->tableau = $tableauProduit;
        $this->where = $where;
    }

    public function displayBody() {
        ?>
        <body>
            <div class="container">
                <table class="table table-striped">
                    <tr>
                        <th>Image</th>
                        <th>Libellé</th>
                        <th>Marque</th>
                        <th>Prix</th>
                        <th>Quantité à ajouter</th>
                        
                    </tr>
                    <?php
                    $i = 0;
                    foreach ($this->tableau as $produit) {
                        
                        echo( '<tr>
                            <td><img src="'.$produit->getFichier_image() .'" height="42">
        <td>' . $produit->getLibelle()
                        . "</td>
         <td>" . $produit->getMarque()
                        . "</td>
        <td>" . $produit->getPrix_unit_HT());
                        ?>
                    </td><td><?php echo($produit->getQuandtite_stock()); ?>
                    <form class="form-inline" action="drive.php?a=<?php echo($_GET["a"]) ?>&c=<?php echo($this->where) ?>&d=ajoutPanier" method="post" id="<?php echo($i) ?>">
                        <div class="form-group">
                            <input type="hidden" name="ref" value="<?php echo($produit->getReference()) ?>">
                            <input type="hidden" name="where" value="<?php if(!empty($_GET["c"])){ echo($_GET["c"]);} ?>">
                        </div>
                        <div class="form-group">
                            <input type="number" name="qte" step="1" value="1" min="1" max="<?php echo($produit->getQuandtite_stock()) ?>">
                        </div>
                        <button type="submit" class="btn btn-default" form="<?php echo($i) ?>">Ajouter au panier</button>
                    </form>
                </td>
                </tr>
            <?php $i ++;} ?>
        </table>    
        </div>
        </body>
        <?php 
        
    }

}
