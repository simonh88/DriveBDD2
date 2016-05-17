<?php

class AjoutSSRayon extends AdminHomeVue {

    public function __construct() {

        parent::__construct("Ajout Sous Sous Rayon");
    }

    public function displayBody() {
        ?>

        <form class="form-horizontal" action="drive.php?acces=Admin&a=AjoutSSRayon" method="post" id="form1">
            <fieldset>

                <!-- Form Name -->
                <legend>Sous Sous Rayon</legend>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">Sous Sous Rayon</label>  
                    <div class="col-md-4">
                        <input type="hidden" name="srayon" value="<?php echo $_GET["id"] ?>">
                        <input id="textinput" name="nom" placeholder="Nom du Sous Sous Rayon" class="form-control input-md" required="" type="text">

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
