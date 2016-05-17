<?php

class AdminCategorieVue extends AdminHomeVue {

    public function __construct() {

        parent::__construct("Liste Admin Categorie");
    }

    public function displayBody() { // BIG ... Vraiment.. BIG..et vraiment sale, pas reussi en recurcif pour simplifier les accordeon
        ?><a href="drive.php?acces=Admin&a=AjoutCategorie" style="display: block; width: 100%;" class="btn btn-primary">Ajouter une Categorie</a>
        <div class="panel-group" id="accordion1">
            <?php
            $collapse = 0;
            $numAccordeon = 2;
            $categories = Categorie::getAll();
            foreach ($categories as $cat) {
                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="pull-right">
                            <a href="drive.php?acces=Admin&a=AjoutRayon&id=<?php echo $cat->getNom() ?>" class="btn btn-primary text-right" role="button">Ajouter un Rayon</a>
                            <a href="drive.php?acces=Admin&a=SuprCategorie&id=<?php echo $cat->getNom() ?>" class="btn btn-danger text-right" role="button">Supprimer</a>                                
                        </div>
                        <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse<?php echo $collapse ?> ">

                                <?php echo $cat->getNom() ?>

                        </h4>

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
                                            <div class="pull-right">
                                                <a href="drive.php?acces=Admin&a=AjoutSRayon&id=<?php echo $rayon->getNom() ?>" class="btn btn-primary text-right" role="button">Ajouter un Sous Rayon</a>
                                                <a href="drive.php?acces=Admin&a=SuprRayon&id=<?php echo $rayon->getNom() ?>" class="btn btn-danger text-right" role="button">Supprimer</a>                                
                                            </div>
                                            <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                                                    <?php echo $rayon->getNom(); ?>
                                                </a></h4>
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
                                                                <div class="pull-right">
                                                                    <a href="drive.php?acces=Admin&a=AjoutSSRayon&id=<?php echo $srayon->getNom() ?>" class="btn btn-primary text-right" role="button">Ajouter un Sous Sous Rayon</a>
                                                                    <a href="drive.php?acces=Admin&a=SuprSRayon&id=<?php echo $srayon->getNom() ?>" class="btn btn-danger text-right" role="button">Supprimer</a>                                
                                                                </div>
                                                                <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                                                                        <?php echo $srayon->getNom(); ?>
                                                                    </a></h4>
                                                            </div>
                                                            <?php
                                                            $jajajaja = $srayon->getSous();
                                                            if (!empty($jajajaja)) {
                                                                ?>
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
                                                                                        <div class="pull-right">

                                                                                            <a href="drive.php?acces=Admin&a=SuprSSRayon&id=<?php echo $ssrayon->getNom() ?>" class="btn btn-danger text-right" role="button">Supprimer</a>                                
                                                                                        </div>
                                                                                        <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $numAccordeon ?>" href="#collapse<?php echo $collapse ?> ">
                            <?php echo $ssrayon->getNom(); ?>
                                                                                            </a></h4>
                                                                                    </div>
                                                                                    <?php
                                                                                    $collapse++;
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
                                                                $collapse++;
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

    /* public function accordeon($variable) {

      $this->collapse++;
      ?>
      <div class="panel panel-default">
      <div class="panel-heading">
      <h4 class="panel-title"><a class="panel-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $this->numAccordeon ?>" href="#collapse<?php echo $this->collapse ?> ">
      <?php echo $variable->getNom() ?>
      </a></h4>
      </div>
      <div id="collapse<?php echo $this->collapse ?>" class="panel-body collapse">
      <div class="panel-inner">
      <?php
      $sousVar = $variable->getSous();
      if(empty($sousVar) || $sousVar == false){
      echo
      }
      ?>
      </div>
      </div>
      </div>
      <?php
      } */
}
