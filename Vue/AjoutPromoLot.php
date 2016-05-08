<?php

class AjoutPromoLot extends AdminHomeVue {

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
        <link rel="stylesheet" type="text/css" href="lib/datetimepicker/jquery.datetimepicker.css"/>

        <script src="lib/datetimepicker/build/jquery.datetimepicker.full.min.js"></script>
        <script>

            $(function () {
                jQuery('#datetimepicker').datetimepicker({
                });
                jQuery('#datetimepicker2').datetimepicker();
            });

        </script>


        <form method="post" action="drive.php?acces=Admin&a=AjoutPromoLot">

            <div class="form-group">
                <label for="reference">Code Promo</label>
                <input type="text" class="form-control" id="code" placeholder="Code Promo" name="code" required> 
            </div>

            <div class="form-group">
                <label for="Libelle">Date debut</label>
                <input id="datetimepicker" type="text" value=""  required/>
            </div>

            <div class="form-group">
                <label for="Libelle">Date fin</label>
                <input id="datetimepicker2" type="text" value=""  required/>
            </div>

            <div class="form-group">
                <label for="Marque">Limite</label>
                <input type="number" class="form-control" id="marq" placeholder="Limite Max" name="max" min="1" max="9" required>
            </div>
            <div class="form-inline">
                <label for="Reduction">Valeurs de la reduction</label>
                <input type="number" class="form-control" id="Reduction" placeholder="reduction" name="reduc" min="1" max="99" step="0.01" required>

                <div class="radio">
                    <label><input type="radio" name="optradio"> € </label>
                </div>
                <div class="radio">
                    <label class=""><input type="radio" name="optradio"> % </label>
                </div>

            </div>

            <div class="form-inline">
                <label for="immediate">Reduction immediate ? </label>
                <input type="checkbox" class="form-control" id="imd"  name="imd">                                
            </div>

            <div class="form-group">
                <label >Liste des Produit</label>
                <?php $this->ajoutProduit() ?>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Créer</button>
        </form>



        <?php
    }

    public function ajoutProduit() {
        ?><div class="panel-group" id="accordion1">
        <?php
        $collapse = 0;
        $numAccordeon = 2;
        $categories = Categorie::getAll();
        foreach ($categories as $cat) {
            ?>

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $collapse ?> ">
                                <?php echo $cat->getNom() ?>
                            </a></h4>
                        <div class="checkbox ">
                            <label>
                                <input type="checkbox" class="form-control"  name="categorie[ <?php echo $cat->getNom(); ?> ]" >
                            </label> 

                        </div>


                    </div>

                    <div id="collapse<?php
                    echo $collapse;
                    $collapse++;
                    ?>" class="panel-body collapse">
                        <div class="panel-inner">
                            <!--***************************-->
                            <div class="panel-group" id="accordion<?php
                            echo $numAccordeon;
                            $numAccordeon++
                            ?>">
                                     <?php
                                     $rayons = $cat->getSous();
                                     foreach ($rayons as $rayon) {
                                         ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                                                    <?php echo $rayon->getNom(); ?>
                                                </a></h4>
                                            <div class="checkbox ">
                                                <label>
                                                    <input type="checkbox" class="form-control"  name="<?php echo ($cat->getNom() . "[ " . $rayon->getNom() . " ]"); ?> ]" >
                                                </label> 

                                            </div>
                                        </div>
                                        <div id="collapse<?php
                                        echo $collapse;
                                        $collapse++;
                                        ?>" class="panel-body collapse">
                                            <div class="panel-inner">

                                                <!--***************************-->
                                                <div class="panel-group" id="accordion<?php
                                                echo $numAccordeon;
                                                $numAccordeon++
                                                ?>">
                                                         <?php
                                                         $srayons = $rayon->getSous();
                                                         foreach ($srayons as $srayon) {
                                                             ?>
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                                                                        <?php echo $srayon->getNom(); ?>
                                                                    </a></h4>
                                                                <div class="checkbox ">
                                                                    <label>
                                                                        <input type="checkbox" class="form-control"  name="<?php echo ($rayon->getNom() . "[ " . $srayon->getNom() . " ]"); ?> ]" >
                                                                    </label> 

                                                                </div>
                                                            </div>
                                                            <?php if (!empty($srayon->getSous())) { ?>
                                                                <div id="collapse<?php
                                                                echo $collapse;
                                                                $collapse++;
                                                                ?>" class="panel-body collapse">
                                                                    <div class="panel-inner">

                                                                        <!--***************************-->
                                                                        <div class="panel-group" id="accordion<?php
                                                                        echo $numAccordeon;
                                                                        $numAccordeon++
                                                                        ?>">
                                                                                 <?php
                                                                                 $ssrayons = $srayon->getSous();
                                                                                 foreach ($ssrayons as $ssrayon) {
                                                                                     ?>
                                                                                <div class="panel panel-default">
                                                                                    <div class="panel-heading">
                                                                                        <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                                                                                                <?php echo $ssrayon->getNom(); ?>
                                                                                            </a></h4>
                                                                                        <div class="checkbox ">
                                                                                            <label>
                                                                                                <input type="checkbox" class="form-control"  name="<?php echo ($srayon->getNom() . "[ " . $ssrayon->getNom() . " ]"); ?> ]" >
                                                                                            </label> 

                                                                                        </div>
                                                                                    </div><div id="collapse<?php
                                                                                    echo $collapse;
                                                                                    $collapse++;
                                                                                    ?>" class="panel-body collapse">
                                                                                        <div class="form-group">
                                                                                            <?php
                                                                                            $produits = SSR_P::getAllProduit($ssrayon->getNom());
                                                                                            foreach ($produits as $value) {
                                                                                                ?>
                                                                                                <input type="checkbox" class="form-control"  name="<?php echo $ssrayon->getNom() . "[ " . $value->getReference() . " ]" ?>">                                
                                                                                                <label ><?php echo $value->getLibelle() ?></label>                                                                                            
                                                                                                <?php
                                                                                            }
                                                                                            ?>

                                                                                        </div>


                                                                                    </div>
                                                                                    <?php
                                                                                    ?>
                                                                                </div><?php
                                                                            }
                                                                            ?>
                                                                        </div>                                                                         
                                                                        <!--***************************-->

                                                                    </div>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                ?> <div id="collapse<?php
                                                                echo $collapse;
                                                                $collapse++;
                                                                ?>" class="panel-body collapse">

                                                                    <div class="form-group">
                                                                        <?php
                                                                        $produits = SR_P::getAllProduit($srayon->getNom());
                                                                        foreach ($produits as $value) {
                                                                            ?>
                                                                            <input type="checkbox" class="form-control"  name="<?php echo $srayon->getNom() . "[ " . $value->getReference() . " ]" ?>">                                
                                                                            <label ><?php echo $value->getLibelle() . "     " . $value->getMarque() ?></label>                                                                                            
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </div>



                                                                </div><?php
                                                            }
                                                            ?>
                                                        </div><?php
                                                    }
                                                    ?>
                                                </div>
                                                <!--***************************-->

                                            </div>
                                        </div>

                                    </div><?php
                                }
                                ?>
                            </div>
                            <!--***************************-->
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>


        <?php
    }

}
