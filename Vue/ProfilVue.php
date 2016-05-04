<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProfilVue extends MainVue {

    private $infos;

    public function __construct($infos) {
        $this->infos = $infos;
        parent::__construct("Drive Mon profil");
    }

    public function displayBody() {
        ?>
        <body>
            <div class="bootstrap-iso">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <form action="drive.php?a=Profil&c=isValider" id="monForm" class="form-horizontal" method="post">
                                <div class="form-group ">
                                    <label class="control-label col-sm-2 requiredField" for="nom">
                                        Nom
                                        <span class="asteriskField">
                                            *
                                        </span>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user">
                                                </i>
                                            </div>
                                            <input class="form-control" id="nom" name="nom" placeholder="Fournier" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-sm-2 requiredField" for="prenom">
                                        Pr&eacute;nom
                                        <span class="asteriskField">
                                            *
                                        </span>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user-plus">
                                                </i>
                                            </div>
                                            <input class="form-control" id="prenom" name="prenom" placeholder="Hubert" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-sm-2 requiredField" for="email">
                                        Email
                                        <span class="asteriskField">
                                            *
                                        </span>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at">
                                                </i>
                                            </div>
                                            <input class="form-control" id="email" name="email" placeholder="exemple@exemple.com" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label col-sm-2 requiredField" for="tel">
                                        Telephone
                                        <span class="asteriskField">
                                            *
                                        </span>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-tty">
                                                </i>
                                            </div>
                                            <input class="form-control" id="tel" name="tel" placeholder="0329354720" type="text"/>
                                        </div>
                                        <span class="help-block" id="hint_tel">
                                            Vous pouvez aussi mettre votre num&eacute;ro de portable
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <button class="btn btn-primary " name="submit" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </body>
        <?php
    }

}
