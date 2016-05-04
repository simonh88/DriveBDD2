<?php

class ConnexionVue extends MainVue {
    var $msg;
    public function __construct($mesg = false) {
        $this->msg = $mesg;
        parent::__construct("Connexion Drive");
    }
    
    public function displayBody() {
        if($this->msg){
            ?><div class="alert alert-danger" role="alert"><?php echo $this->msg ?></div><?php
        }
        ?>  <a class="btn btn-default" href="drive.php?acces=Admin&a=Accueil" role="button">Acces Admin</a><div  style="
              display: inline-block;
              position: fixed;
              top: 0;
              bottom: 0;
              left: 0;
              right: 0;
              width: 200px;
              height: 100px;
              margin: auto;
              ">            
            <form class="form-inline" action="drive.php?a=Check" method="post">
                <div class="form-group">
                    <input class="form-control form-control-lg" type="text" name="carte" placeholder="numero carte fidelite">
                </div>
                <button class="btn btn-info" role="button">Connexion</button>
            </form>
        </div>
        <?php
    }

    public function displayBandeau() {
        
    }

}
