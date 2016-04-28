<?php

class ProduitVue extends MainVue {

    private $tableau;

    public function __construct($tableauProduit) {
        parent::__construct("ListeClientTest");
        $this->tableau = $tableauProduit;
    }

    public function displayBody() {
        ?>
        <table class="table table-striped">
            <tr>
                <th>No</th>
                <th>Carte Credit</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Telephone</th>

            </tr>
            
                <?php
                foreach ($this->tableau as $client) {

                    echo( "<tr>
        <td>" . $client->getNo_carte()
                    . "</td>
         <td>" . $client->getCredit_carte()
                    . "</td>
        <td>" . $client->getNom()
                    . "</td>
        <td>" . $client->getPrenom()
                    . "</td>
        <td>" . $client->getAdresse()
                    . "</td>
       <td>" . $client->getE_mail()
                    . "</td>
       <td>" . $client->getTelephone()
                    . "</td></tr>");
                }
                ?>



            </tr>
        </table>
        <?php
    }

}
