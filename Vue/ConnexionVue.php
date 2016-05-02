<?php

class ConnexionVue extends MainVue {
    var $msg;
    public function __construct($mesg = false) {
        $this->msg = $mesg;
        parent::__construct("Connexion Drive");
    }
    
    public function displayBody() {
        if($this->msg){
            ?><div class="alert alert-success" role="alert">Mauvais Client</div><?php
        }
        ?>  <div  style="
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
            <form class="form-inline" method="post">
                <div class="form-group">
                    <input class="form-control form-control-lg" name="carte" placeholder="numero carte fidelite">
                </div>
                <a class="btn btn-info" href="index.php?a=check" role="button">Connexion</a>
            </form>
        </div>
        <?php
    }

    public function displayBandeau() {
        
    }

}
