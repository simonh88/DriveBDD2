<?php
/*
 * Contient les informations de connexion de la base données
 */
class Database
{
	/*
	 * Hote de la base de donnée 
	 */
	public static $host = '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=oracle.depinfo.uhp-nancy.fr)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=depinfo)))';
		
	/*
	 * Utilisateur de la base de donnée
	 */
	public static $user = 'etud045';
	
	/*
	 * Mot de passe de la base de donnée
	 */
	public static $password = 'azertoto';
}

?>
