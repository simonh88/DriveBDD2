<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PanierVue extends MainVue {

    private $items;
    private $infos;
    private $promo;

    public function __construct($produits, $infos, $promo) {
        $this->items = $produits;
        $this->infos = $infos;
        $this->promo = $promo;
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
                    $prixFinal = 0;
                    $i = 0;
                    $promo = $this->promo;
                    foreach ($this->items as $item) {
                        if (empty($promo)) {
                            $p = Produit::getProduit($item->getReference());
                            $prix += $p->getPrix_unit_HT();
                            $q = $item->getQuantite();
                        }else{
                            $p = Produit::getProduit($item->getReference());
                            $pos = $this->appartient($item->getReference());
                            if(((int)$pos > -1)){
                                $prix = $promo[$pos]["PRIXFINAL"];
                                $q = $promo[$pos]["QUANTITE"];
                            }else{
                                $prix = $p->getPrix_unit_HT() * $item->getQuantite();
                                $q = $item->getQuantite();
                                
                            }
                            $prixFinal += $prix;
                            
                        }
                        echo( "<tr>
                            <td>" . $p->getLibelle()
                        . "</td>
                           <td>" . $p->getMarque()
                        . "</td>
                           <td>" . $prix
                        . "</td>"
                        . "<td>");
                        echo($q . "</td>");
                        if (empty($promo)) {
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
                        } else {
                            echo("<td></td>");
                        }
                        $i ++;
                    }
                    if (empty($promo)) {
                        echo("<tr><td> </td><td></td><td> </td><td></td><td></td></tr>"
                        . "<tr><td> </td><td> </td><td> </td><td></td><th>" . "Total(horsRemises) : " . $montant . " <span class='glyphicon glyphicon-euro'</span></th></tr>")
                        ?>
                    </table>
                    <a href="drive.php?c=ViderPanier&a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-danger">Vider le panier <span class="glyphicon glyphicon-remove"</span></button></a>
                    <a href="drive.php?c=ValiderPanier&a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-success">Valider le panier <span class="glyphicon glyphicon-arrow-up"</span></button></a>
                    <?php
                } else {
                    echo("<tr><td> </td><td></td><td> </td><td></td><td></td></tr>"
                    . "<tr><td> </td><td> </td><td> </td><td></td><th>" . "Total(Remises comprises) : " . $prixFinal . " <span class='glyphicon glyphicon-euro'</span></th></tr>");
                    ?>
                </table>
                <a href="drive.php?a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-danger">Annuler la validation <span class="glyphicon glyphicon-remove"</span></button></a>
                <a href="drive.php?a=Payer"><button type="button" class="btn btn-succes">Payer <span class="glyphicon glyphicon-euro"</span></button></a>
            <?php }
            ?>
        </div>
        </body>
        <?php
    }
    
    private function appartient($ref){
        $trouver = 0;
        foreach ($this->promo as $p){
            if($p["REFERENCE"] == $ref){
                
                return $trouver;
            }
            $trouver ++;
        }
        return -1;
    }

}
