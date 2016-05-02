<?php

class ConnexionVue extends MainVue {

    public function displayBody() {
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
              background-color: #f3f3f3;">
            <form class="form-inline">
                <div class="form-group">
                    <input class="form-control form-control-lg" placeholder="numero carte fidelite">
                </div>
                <a class="btn btn-info" href="#" role="button">Connexion</a>
            </form>
        </div>
        <?php
    }

    public function displayBandeau() {
        
    }

}
