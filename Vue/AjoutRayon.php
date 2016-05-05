<?php

class AjoutRayon extends AdminHomeVue {

    public function __construct() {

        parent::__construct("Ajout Rayon");
    }

    public function displayBody() {
        ?>

        <form class="form-horizontal" action="drive.php?acces=Admin&a=AjoutRayon" method="post" id="form1">
            <fieldset>

                <!-- Form Name -->
                <legend>Rayon</legend>
                
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Rayon</label>  
                    <div class="col-md-4">
                        <input type="hidden" name="categorie" value="<?php echo $_GET["id"]?>">
                        <input id="textinput" name="nom" placeholder="Nom du Rayon" class="form-control input-md" required="" type="text">

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
