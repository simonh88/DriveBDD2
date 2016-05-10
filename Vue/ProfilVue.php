<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProfilVue extends MainVue {

    private $infos;
    private $aValider;
    private $infosCorrects;

    public function __construct($infos, $aValider, $infosCorrects) {
        $this->infos = $infos;
        $this->aValider = $aValider;
        $this->infosCorrects = $infosCorrects;
        parent::__construct("Drive Mon profil");
    }

    public function displayBody() {
        $cli = Client::getInfosClient($_SESSION["user"]);
        if (!$this->aValider) {
            ?><h5>Vous avez <?php echo($cli->getCredit_carte())?> euros sur la carte à votre disposition.</h5> <?php
            if (!$this->infosCorrects) {
                ?>
                <body>
                    <div class="alert alert-danger alert-dismissable text-center"><strong>Erreur : </strong> Les informations entrees sont erronées Veuillez recommencer en entrant un email valide et en ne laissant aucuns champs vides</div>
                    <?php
                }
                ?>

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
                                                <input class="form-control" id="nom" name="nom" placeholder="<?php echo($this->infos->getNom()) ?>" type="text"/>
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
                                                <input class="form-control" id="prenom" name="prenom" placeholder="<?php echo($this->infos->getPrenom()) ?>" type="text"/>
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
                                                <input class="form-control" id="email" name="email" placeholder="<?php echo($this->infos->getE_mail()) ?>" type="text"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="control-label col-sm-2 requiredField" for="adresse">
                                            Adresse
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
                                                <input class="form-control" id="adresse" name="adresse" placeholder="<?php echo($this->infos->getAdresse()) ?>" type="text"/>
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
                                                <input class="form-control" id="tel" name="tel" placeholder="<?php echo($this->infos->getTelephone()) ?>" type="text"/>
                                            </div>
                                            <span class="help-block" id="hint_tel">
                                                Vous pouvez aussi mettre votre num&eacute;ro de portable
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-2">
                                            <button class="btn btn-primary " name="submit" type="submit">
                                                Valider
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
        } else {
            if (!$this->infosCorrects) {//Incorrect, on valide rien, on prévient et il recommence
                $this->aValider = false;
                $this->displayBody(); //Evite la duplication du code de la partie juste au dessus
            } else {//Les infos sont corrects, on valide le changement
                ?>
                <body>
                    <div class="text-center">
                        <div class="alert alert-success"><strong>F&eacute;licitation !</strong> Vous venez de changer vos informations</div>
                        <?php
                        echo("<strong>Voici vos nouvelles informations : <strong/><br/><strong>   Nom : <strong/>" . $this->infos->getNom());
                        echo("<br/><strong>   Prénom : <strong/>" . $this->infos->getPrenom());
                        echo("<br/><strong>   Adresse : <strong/>" . $this->infos->getAdresse());
                        echo("<br/><strong>   Téléphone : <strong/>" . $this->infos->getTelephone());
                        echo("<br/><strong>   Email : <strong/>" . $this->infos->getE_mail());
                        ?>
                    </div>
                </body>
                <?php
            }
        }
    }

}
