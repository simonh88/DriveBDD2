<?php
class Promotion{
	//Attributs de promotion
	
	private $code_promo;
	private $date_debut;
	private $date_fin;
	private $max_par_client;
	
}

class P_individuelle extends Promotion{
	
	private $reduction_absolue;
	private $reduction_relative;
	private $immediate_VF;
}

class P_lot extends Promotion{
	private $nb_achetes;
	private $nb_gratuits;
}
?>