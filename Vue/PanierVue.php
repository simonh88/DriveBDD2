<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PanierVue extends MainVue {

    private $no_carte;

    public function __construct($no_carte) {
        $this->no_carte = $no_carte;
        parent::__construct("Affichage panier");
    }

    public function displayBody() {
        $items = Item::getInfosPanier($this->no_carte);
        $infos = Panier::getInfos($this->no_carte);
        ?>
        <body>
            <div class="container">
                <table class="table table-striped">
                    <tr><th>Contenu du panier<th><th> </th></tr>
                    <td> </td>
                    <tr>
                        <th>Libellé</th>
                        <th>Marque</th>
                        <th>Prix</th>
                    </tr>
                    <?php
                    $prix = 0;
                    foreach ($items as $item) {
                        $p = Produit::getProduit($item->getReference());
                        $prix += $p->getPrix_unit_HT();
                        echo( "<tr>
                            <td>" . $p->getLibelle()
                        . "</td>
                           <td>" . $p->getMarque()
                        . "</td>
                           <td>" . $p->getPrix_unit_HT()
                        . "</td></tr>");
                    }
                    echo("<tr><td> </td></tr>"
                            . "<tr><th>". "Total(horsRemises) : ". $prix ." <span class='glyphicon glyphicon-euro'</span></th></tr>")
                    ?>
                </table>
            </div>
        </body>
        <?php
    }

}