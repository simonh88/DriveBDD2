<?php

class ProduitVue extends MainVue {

    private $tableau;

    public function __construct($tableauProduit) {
        parent::__construct("Prpduit");
        $this->tableau = $tableauProduit;
    }

    public function displayBody() {
        ?>
        <table class="table table-striped">
            <tr>
                <th>Libellé</th>
                <th>Marque</th>
                <th>Prix</th>

            </tr>
            
                <?php
                foreach ($this->tableau as $produit) {

                    echo( "<tr>
        <td>" . $produit->getLibelle()
                    . "</td>
         <td>" . $produit->getMarque()
                    . "</td>
        <td>" . $produit->getPrix_unit_HT()
                    . "</td></tr>");
                }
                ?>



            </tr>
        </table>
        <?php
    }

}
