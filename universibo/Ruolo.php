<?php

define('RUOLO_MODERATORE'  ,1);
define('RUOLO_REFERENTE'   ,2);

define('NOTIFICA_NONE'   ,0);
define('NOTIFICA_URGENT' ,1);
define('NOTIFICA_ALL'    ,2);


/**
 * Classe Ruolo, contiene informazioni relative alle proprietà che legano uno User ad un Canale
 *
 * Contiene le informazioni che legano un utente ad un canale, 
 * i diritti di accesso (moderatore, referente, ecc...)
 * l'istante dell'ultimo accesso, l'inserimento o meno tra i bookmark/preferiti/my_universibo
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */



class Ruolo {

	var $id_utente = 0; 
	var $id_canale = 0;
	var $user = NULL; //riferimento al canale
	var $canale = NULL;  //riferimento all'utente

	var $ultimoAccesso = 0; 
	var $tipoNotifica = '';
	var $nome = '';

	var $my_unversibo = true; 
	var $moderatore = false; 
	var $referente = false; 

	
	
	function Ruolo($id_utente, $id_canale, $nome, $ulitmo_accesso, $moderatore, $referente, $my_universibo, $notifica, $user=NULL, $canale=NULL)
	{
		
	}
	
	
	
	
	function selectRuolo($id_utente, $id_canale)
	{
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ultimo_accesso, ruolo, my_universibo, notifica, nome FROM utente_argomento WHERE id_utente = '.$db->quote($id_utente).' AND id_canale= '.$db->quote($id_canale);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows > 1) Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
		if( $rows = 0) return false;

		$row = $res->fetchRow();
		$ruolo =& new Ruolo($id_utente, $id_canale, $row[4], $row[0], $row[1]==RUOLO_MODERATORE, $row[1]==RUOLO_REFERENTE, $row[2]=='S', $row[3]);
		return $ruolo;
		
	}

	function updateRuolo()
	{
		
	}

	function insertRuolo()
	{
		
	}

	function deleteRuolo()
	{
		
	}
    
}

?>