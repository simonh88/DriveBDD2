<?php

class SuprProm extends AdminHomeVue {

    public function displayBody() {
        ?>
        <div class="alert alert-danger" role="alert">Etes vous sur de vouloir <strong>supprimer definitivement</strong> cette Promotion ?</div>
        <div  style="
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
            <form class="form-inline" action="drive.php?acces=Admin&a=SuprPromo" method="post">
                <input type="hidden" name='ok' value ='<?php echo $_GET['id']; ?>'>
                <button class="btn btn-danger" role="button">Oui</button>
            </form>
        </div>
        <?php
    }

}
