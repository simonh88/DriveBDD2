<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('location:drive.php?a=Accueil');
    /*
     * TODO 
     * 
     * INSERT PANIER lorsque le client n'en a pas (check lors de la 
     * connexion du client)
     *
     * 
     * INSERT PLanning DateDefautPlanning (avec limit -1)
     * 
     * INSERT INTO PANIER(nocarte, VIDE_VF, DatePlanningDefault,0,0)
     * 
     * DatePDefault = date du lendemain
     * Pourra etre changer lors du paiement
     *
     * FLUSH PANIER && ITEM lors du payement payement (ou boutton)
     * 
     * UPDATE dateValidation et de montant (lors du Payement)
     * 
     * 
     *Rajouter un fonction dans Planning ou Panier qui verif si 
     *
     * select count(*) from Panier where Date_Heure = DateDefaultHeure <
     * select nbmax from Planning
     * 
     * si Planning n'existait pas * INSERT PLANNING dateCHoisi
     * 
     * pour lors du choix de la date de livraison
     * 
     * INSERT PLanning -> Simon
     * INSERT PANIER -> Tristan
     * DELETE ON CASCADE PANIER -> Tristan
     * UPDATE PANIER -> Tristan
     * DELETE ITEM -> SImon
     * UPDATE ITEM  -> Simon
     * fonction getNBPanier -> verifNombreLivraison -> SImon
     */
?>


