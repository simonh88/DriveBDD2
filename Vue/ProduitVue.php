<?php

class ProduitVue extends MainVue {

    private $tableau;
    private $where;
    private $dataPromo;

    public function __construct($tableauProduit, $where, $dataPromo) {
        parent::__construct("Produit");
        $this->tableau = $tableauProduit;
        $this->where = $where;
        $this->dataPromo = $dataPromo;
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
                        <th>Info</th>
                        <th>Quantité à ajouter</th>
                        <th>Promotion</th>


                    </tr>
                    <?php
                    $i = 0;
                    foreach ($this->tableau as $produit) {
                        $promo = Objet_promo::getCodePromo($produit->getReference());
                        $codepromo = $promo->getCode_promo();
                        if (empty($codepromo)) {
                            $quantStock = $produit->getQuandtite_stock();
                        } else {
                            $p = Promotion::getPromotion($codepromo);
                            if (!ProduitControler::verifDates($p->getDate_debut(), $p->getDate_fin())) {
                                $quantStock = $produit->getQuandtite_stock();
                            } else {
                                if (Item::existProduitDansPanier($_SESSION["user"], $produit->getReference())) {
                                    $c = Item::getQuantiteDansPanier($_SESSION["user"], $produit->getReference());
                                } else {
                                    $c = 0; //ici c vos 0 parce le client n'en a pas encore dans son panier
                                }
                                $quantStock = $p->getMax_par_client() - $c;
                            }
                        }

                        echo( '<tr>
                            <td><img src="' . $produit->getFichier_image() . '" height="42">
        <td>' . $produit->getLibelle()
                        . "</td>
         <td>" . $produit->getMarque()
                        . "</td>
        <td>" . $produit->getPrix_unit_HT());
                        ?>
                    </td><?php
                    if (Item::existProduitDansPanier($_SESSION["user"], $produit->getReference())) {
                        $qDansPanier = Item::getQuantiteDansPanier($_SESSION["user"], $produit->getReference());
                        echo( "<td>Maximum : " . $produit->getQuandtite_stock() . "<br><br><strong>Vous avez déjà " . $qDansPanier ." ". $produit->getLibelle() . " dans votre panier.<br></strong>");
                    } else {
                        echo( "<td>Maximum : " . $produit->getQuandtite_stock()."<br><br>");
                    }
                    if (!empty($codepromo)) {
                        if ($quantStock < 1) {
                            echo("<br><strong>Attention, vous le payerai plein tarif.</strong>");
                        } else {
                            if (ProduitControler::verifDates($p->getDate_debut(), $p->getDate_fin())) {
                                echo("<br> Promotion pour encore : " . $quantStock . " article(s).");
                            }
                        }
                    }
                    echo("</td>");
                    if (isset($_GET['a']))
                        $line = $_GET['a'];
                    else
                        $line = "Accueil";
                    ?>
                    <td>
                    <form class="form-inline" action="drive.php?a=<?php echo($line) ?>&c=<?php echo($this->where) ?>&d=ajoutPanier" method="post" id="<?php echo($i) ?>">
                        <div class="form-group">
                            <input type="hidden" name="ref" value="<?php echo($produit->getReference()) ?>">
                            <input type="hidden" name="where" value="<?php
                            if (!empty($_GET["c"])) {
                                echo($_GET["c"]);
                            }
                            ?>">
                        </div>
                        <div class="form-group">
                            <input type="number" name="qte" step="1" value="1" min="1" max="<?php echo($produit->getQuandtite_stock()) ?>">
                        </div>
                        <button type="submit" class="btn btn-info" form="<?php echo($i) ?>">Ajouter au panier</button>
                    </form>
                </td>
                <?php
                if (!empty($codepromo)) {
                    if (ProduitControler::verifDates($promo->getDate_debut(), $promo->getDate_fin())) {//Si les dates sont bonnes
                        if ($promo instanceof P_lot) {
                            echo("<td><strong> PROMOTION, pour " . $promo->getNb_achetes() . " achetés " . $promo->getNb_gratuits() . " gratuits</strong></td>");
                        } else {
                            $codeabsolue = $promo->getReduction_absolue();
                            if (empty($codeabsolue)) {
                                if ($promo->getImmediate_VF() == 'V') {//Si c'est vrai reduc immédiate
                                    echo("<td><strong> PROMOTION, vous avez " . $promo->getReduction_relative() . "% en reduction immédiate</strong></td>");
                                } else {
                                    echo("<td><strong> PROMOTION, vous avez " . $promo->getReduction_relative() . "% en fidélité</td>");
                                }
                            } else {
                                if ($promo->getImmediate_VF() == 'V') {//Si c'est vrai reduc immédiate
                                    echo("<td><strong> PROMOTION, vous avez " . $promo->getReduction_absolue() . "<span class='glyphicon glyphicon-euro'></span> en reduction immédiate</strong></td>");
                                } else {
                                    echo("<td><strong> PROMOTION, vous avez " . $promo->getReduction_absolue() . "<span class='glyphicon glyphicon-euro'></span> en reduction en fidélité</strong></td>");
                                }
                            }
                        }
                    }
                    echo("<td></td>");
                } else {
                    echo("<td></td>");
                }
                ?>
                </td>
                <?php
                /* if (!empty($this->dataPromo)) {
                  if ($this->dataPromo[$i] instanceof P_lot) {
                  echo("<td> PROMOTION, pour " . $this->dataPromo[$i]->getNb_achetes() . " achetés " . $this->dataPromo[$i]->getNb_gratuits() . " gratuits</td>");
                  } else {
                  if (empty($this->dataPromo[$i]->getReduction_absolue())) {
                  if ($this->dataPromo[$i]->getImmediate_VF()) {//Si c'est vrai reduc immédiate
                  echo("<td> PROMOTION, vous avez " . $this->dataPromo[$i]->getReduction_relative() . "% en reduction immédiate</td>");
                  } else {
                  echo("<td> PROMOTION, vous avez " . $this->dataPromo[$i]->getReduction_relative() . "<span class='glyphicon glyphicon-euro'></span> en reduction immédiate</td>");
                  }
                  } else {
                  if ($this->dataPromo[$i]->getImmediate_VF()) {//Si c'est vrai reduc immédiate
                  echo("<td> PROMOTION, vous avez " . $this->dataPromo[$i]->getReduction_absolue() . "% en fidélité</td>");
                  } else {
                  echo("<td> PROMOTION, vous avez " . $this->dataPromo[$i]->getReduction_absolue() . "<span class='glyphicon glyphicon-euro'></span> en reduction en fidélité</td>");
                  }
                  }
                  }
                  }
                  ?> */echo("</tr>");
                $i ++;
            }
            ?>
        </table>    
        </div>
        </body>
        <?php
    }

}
