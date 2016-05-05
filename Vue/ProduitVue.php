<?php

class ProduitVue extends MainVue {

    private $tableau;

    public function __construct($tableauProduit) {
        parent::__construct("Produit");
        $this->tableau = $tableauProduit;
    }

    public function displayBody() {
        ?>
        <body>
            <div class="container">
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Libellé</th>
                <th>Marque</th>
                <th>Prix</th>
                <th></th>
            </tr>
            
                <?php
                foreach ($this->tableau as $produit) {

                    echo( "<tr>
        <td></td><td>" . $produit->getLibelle()
                    . "</td>
         <td>" . $produit->getMarque()
                    . "</td>
        <td>" . $produit->getPrix_unit_HT()
                    . '</td><td><input type="number" step="1" value="0" min="0" max="'.$produit->getQuandtite_stock().'"></td></tr>');
                }
                ?>



            </tr>
        </table>
            </div>
        </body>
        <?php
    }

}
