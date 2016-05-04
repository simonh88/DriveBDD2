<?php

class AdminHomeVue extends MainVue {
    
    public function __construct() {
        parent::__construct("Administrateur");
    }

    public function displayBody() {
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="list-group" style ="margin-top: 200px">
                        <a href="#" class="list-group-item active btn">Accueil Administrateur</a>

                        <a class="list-group-item btn btn-default "href="drive.php?acces=Admin&a=MenuCategorie"role="button">Accces Admin Categorie, Rayon,etc...</a>

                        <a class="list-group-item btn btn-default " href="drive.php?acces=Admin&a=MenuPromo" role="button">Acces Admin Promotion</a>

                        <a class="list-group-item btn btn-default "href="drive.php?acces=Admin&a=MenuProduit" role="button"> Acces Admin Produit</a>

                        <a class="list-group-item btn btn-default active" href="drive.php?a=Accueil" role="button"> Retour</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function displayBandeau() {
        //RIEN NON RIEN DE RIEN, JE NE REGRETTE RIEN
    }

}
