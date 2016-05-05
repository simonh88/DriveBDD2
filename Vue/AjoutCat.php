<?php

class AjoutCat extends AdminHomeVue {

    public function __construct() {

        parent::__construct("Ajout Categorie");
    }

    public function displayBody() {
        ?>

<form class="form-horizontal" action="drive.php?acces=Admin&a=AjoutCategorie" method="post" id="form1">
            <fieldset>

                <!-- Form Name -->
                <legend>Categorie</legend>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Categorie</label>  
                    <div class="col-md-4">
                        <input id="textinput" name="nom" placeholder="Nom de la categorie" class="form-control input-md" required="" type="text">

                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nom">Enregistrer</label>
                    <div class="col-md-4">
                        <button id="nom" name="Ajout" class="btn btn-primary"  form="form1" type="submit" >Ajouter</button>
                    </div>
                </div>

            </fieldset>
        </form>


        <?php
    }

}
