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
    private $estValider;

    public function __construct($produits, $infos, $promo, $estValider) {
        $this->items = $produits;
        $this->infos = $infos;
        $this->promo = $promo;
        $this->estValider = $estValider;
        parent::__construct("Affichage panier");
    }

    public function displayBody() {
        $montant = $this->infos->getMontant();
        $cli = Client::getInfosClient($_SESSION["user"]);
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
                            $q = $item->getQuantite();
                            $prix += $p->getPrix_unit_HT() * $q;
                            $eurosCarte = 0;
                        } else {
                            $p = Produit::getProduit($item->getReference());
                            $pos = $this->appartient($item->getReference());
                            $eurosCarte = $this->promo[0]["CAGNOTTE"]; //On recup tout les euros qui vont aller sur la carte
                            if (((int) $pos > -1)) {
                                $prix = $promo[$pos]["PRIXFINAL"];
                                $q = $promo[$pos]["QUANTITE"];
                            } else {
                                $prix = $p->getPrix_unit_HT() * $item->getQuantite();
                                $q = $item->getQuantite();
                            }
                        }
                        $prixFinal += $prix;
                        echo( "<tr>
                            <td>" . $p->getLibelle()
                        . "</td>
                           <td>" . $p->getMarque()
                        . "</td>
                           <td>" . $prix
                        . "</td>"
                        . "<td>");
                        echo($q . "</td>");

                        if (!$this->estValider) {
                            ?>
                            <td>
                                <form class="form-inline" action="drive.php?a=AffPanier&c=enleveProduit" method="post" id="<?php echo($i) ?>">
                                    <div class="form-group">
                                        <input type="hidden" name="ref" value="<?php echo($p->getReference()) ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="qte" step="-1" value="-1" max="-1" min="-<?php echo($item->getQuantite()) ?>">
                                    </div>
                                    <button type="submit" class="btn btn-default" form="<?php echo($i) ?>">Supprimer du panier</button>
                                </form>
                            </td></tr>
                            <?php
                        } else {
                            echo("<td></td>");
                        }
                        $i ++;
                    }
                    if (!$this->estValider) {
                        echo("<tr><td> </td><td></td><td> </td><td></td><td></td></tr>"
                        . "<tr><td> </td><td> </td><td> </td><td></td><th>" . "Total(horsRemises) : " . $montant . " <span class='glyphicon glyphicon-euro'</span></th></tr>")
                        ?>
                    </table>
                    <a href="drive.php?c=ViderPanier&a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-danger">Vider le panier <span class="glyphicon glyphicon-remove"</span></button></a>
                    <a href="drive.php?c=ValiderPanier&a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-success">Valider le panier <span class="glyphicon glyphicon-arrow-up"</span></button></a>
                    <?php
                } else {
                    if ($prixFinal == 0) {
                        ?>
                        <div class="alert alert-warning"><strong>Attention !</strong><?php echo(" Votre panier est vide"); ?></div>
                        <?php
                    } else {
                        echo("<tr><td> </td><td></td><td> </td><td></td><td></td></tr>"
                        . "<tr><td> </td><td> </td><td> </td><td></td><th>" . "Total(Remises comprises) : " . $prixFinal . " <span class='glyphicon glyphicon-euro'</span></th></tr>");
                        ?>
                    </table>
                    <h4>Ces courses vous feraient gagner <?php echo($eurosCarte); ?> euros sur votre carte de fidélité si vous finalisez la commande.</h4>
                    <a href="drive.php?a=<?php echo($_GET["a"]); ?>"><button type="button" class="btn btn-danger">Annuler la validation <span class="glyphicon glyphicon-remove"</span></button></a>
                    <form class="form-inline" action="drive.php?a=Payer" method="post" id="valPanier">
                        <input type="hidden" name="eurosCarte" value="<?php echo($eurosCarte) ?>">
                        <input type="hidden" name="prixFinal" value="<?php echo($prixFinal) ?>">
                        <br><br>
                        Vous avez <?php echo($cli->getCredit_carte()) ?> euros à votre disposition.<br>
                        Voulez vous en utiliser?<br>
                        <input type="number" name="eurosADeduire" step="0.01" value="0" min="0" max="<?php
                        if ($cli->getCredit_carte() < $prixFinal) {
                            $max = $cli->getCredit_carte();
                        } else {
                            $max = $prixFinal;
                        }
                        echo($max)
                        ?>">
                        <button type="submit" class="btn btn-succes" form="valPanier">Payer <span class="glyphicon glyphicon-euro"</span></button>
                    </form>
                <?php
                }
            }
            ?>
        </div>
        </body>
        <?php
    }

    private function appartient($ref) {
        $trouver = 0;
        foreach ($this->promo as $p) {
            if ($p["REFERENCE"] == $ref) {
                return $trouver;
            }
            $trouver ++;
        }
        return -1;
    }

}
