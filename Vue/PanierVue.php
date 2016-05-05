<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PanierVue extends MainVue {

    private $items;
    private $infos;

    public function __construct($produits, $infos) {
        $this->items = $produits;
        $this->infos = $infos;
        parent::__construct("Affichage panier");
    }

    public function displayBody() {
        $montant = $this->infos->getMontant();
        ?>
        <body>
            <div class="container">
                <table class="table table-striped text-center">
                    <tr><th>Contenu du panier<th><th> </th><td></td><td></td></tr>
                    <td></td><td></td><td></td><td></td><td></td>
                    <tr>
                        <th class="text-center">Libellé</th>
                        <th class="text-center">Marque</th>
                        <th class="text-center">Prix</th>
                        <th class="text-center">Quantite</th>
                        <th></th>
                    </tr>
                    <?php
                    $prix = 0;
                    $i = 0;
                    foreach ($this->items as $item) {
                        $p = Produit::getProduit($item->getReference());
                        $prix += $p->getPrix_unit_HT();
                        echo( "<tr>
                            <td>" . $p->getLibelle()
                        . "</td>
                           <td>" . $p->getMarque()
                        . "</td>
                           <td>" . $p->getPrix_unit_HT()
                        . "</td>"
                        . "<td>" . $item->getQuantite() . "</td>");
                        ?>
                        <td>
                            <form class="form-inline" action="drive.php?a=AffPanier&c=enleveProduit" method="post" id="<?php echo($i) ?>">
                                <div class="form-group">
                                    <input type="hidden" name="ref" value="<?php echo($p->getReference()) ?>">
                                </div>
                                <div class="form-group">
                                    <input type="number" name="qte" step="-1" value="-1" max="-1" min="-<?php echo($item->getQuantite()) ?>">
                                </div>
                                <button type="submit" class="btn btn-default" form="<?php echo($i) ?>">Ajouter au panier</button>
                            </form>
                        </td></tr>
                        <?php
                        $i ++;
                    }
                    echo("<tr><td> </td><td></td><td> </td><td></td><td></td></tr>"
                    . "<tr><td> </td><td> </td><td> </td><td></td><th>" . "Total(horsRemises) : " . $montant . " <span class='glyphicon glyphicon-euro'</span></th></tr>")
                    ?>
                </table>
                <a href="drive.php?c=ViderPanier&a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-danger">Vider le panier <span class="glyphicon glyphicon-remove"</span></button></a>
            </div>
        </body>
        <?php
    }

}
