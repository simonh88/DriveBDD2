<?php

class ConnexionVue extends MainVue {

    public function displayBody() {
        ?>  <div class="header">
            <form class="form-inline">
                <div class="form-group">
                    <input class="form-control form-control-lg" placeholder="numero carte fidelite">
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>
        </div>
        <?php
    }

    public function displayBandeau() {
        
    }

}
