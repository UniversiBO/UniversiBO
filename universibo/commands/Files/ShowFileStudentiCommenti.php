<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('Files/FileItemStudenti'.PHP_EXTENSION);
require_once ('User'.PHP_EXTENSION);

/**
 * ShowFileStudentiCommenti é un'implementazione di PluginCommand.
 *
 * Mostra i file del canale
 * Il BaseCommand che chiama questo plugin deve essere un'implementazione di CanaleCommand.
 * 
 *
 * @package universibo
 * @subpackage News
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowFileStudentiCommenti extends PluginCommand {
	
	//todo: rivedere la questione diritti per uno studente...
	
	/**
	 * Esegue il plugin
	 *
	 * @param l'id del file di cui si voglio i commenti
	 */
	function execute($param)
	{
		//$flag_chkDiritti	=  $param['chk_diritti'];
//		var_dump($param['id_notizie']);
//		die();
		
		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();

		
		$id_canale = $param['id_canale'];
		$user_ruoli =& $user->getRuoli();

		$personalizza_not_admin = false;

		if (array_key_exists($id_canale, $user_ruoli) || $user->isAdmin())
		{
			$personalizza = true;
			
			if (array_key_exists($id_canale, $user_ruoli))
			{
				$ruolo =& $user_ruoli[$id_canale];
				
				$personalizza_not_admin = true;
				$referente      = $ruolo->isReferente();
				$moderatore     = $ruolo->isModeratore();
				$ultimo_accesso = $ruolo->getUltimoAccesso();
			}
			
		}
		else
		{
			$personalizza   = false;
			$referente      = false;
			$moderatore     = false;
			$ultimo_accesso = $user->getUltimoLogin();
		}
/*		
		$canale_news = $this->getNumNewsCanale($id_canale);

		$template->assign('showNews_desc', 'Mostra le ultime '.$num_news.' notizie del canale '.$id_canale.' - '.$titolo_canale);
*/

		$elenco_commenti =& $this->getCommenti($param['id_file']);
		$num_commenti =& $this->quantiCommenti($param['id_file']);
		$elenco_commenti_tpl = array();
//		var_dump($elenco_commenti);
//	    die();
		
		
		if ($elenco_commenti ==! false )
		{
			for ($i = 0; $i < $num_commenti; $i++)
			{
				
				$id_utente =& $elenco_commenti[$i][0];
				$commenti['commento'] =& $elenco_commenti[$i][1];
				$commenti['voto'] =& $elenco_commenti[$i][2];
				$commenti['userLink'] = ('index.php?do=ShowUser&id_utente='.$id_utente);
				$commenti['userNick'] = User::getUsernameFromId($id_utente);
				
				$elenco_commenti_tpl[$i] = $commenti;
//				var_dump($elenco_commenti_tpl);
//				die();
				
				$this_moderatore = ($user->isAdmin() || ($moderatore && $file->getIdUtente()==$user->getIdUser()));
			}
			
						
			$template->assign('showFileStudentiCommenti_langCommentiAvailableFlag', 'true');
			$template->assign('showFileStudentiCommenti_commentiList', $elenco_commenti_tpl);
		}	
	else {$template->assign('showFileStudentiCommenti_langCommentiAvailableFlag', 'false');
		 }
			
	}
	
	
	/**
	 * Preleva da database i commenti del file identificato da $id_file
	 *
	 * @static 
	 * @param int $id_file identificativo su database del file studente
	 * @return array elenco dei commenti
	 */
	function &getCommenti($id_file)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT id_utente,commento,voto FROM file_studente_commenti WHERE id_file_studente='.$db->quote($id_file).' ORDER BY voto DESC';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$commenti_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$commenti_list[]= $row;
		}
		
		$res->free();
		
		return $commenti_list;
		
	}
	
	
	/**
	 * Conta il numero dei commenti presenti per il file
	 *
	 * @static 
	 * @param int $id_file identificativo su database del file studente
	 * @return numero dei commenti
	 */
	function &quantiCommenti($id_file)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT count(*) FROM file_studente_commenti WHERE id_file_studente = '.$db->quote($id_file).' GROUP BY id_file_studente';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$res->fetchInto($row);
		$res->free();
		
		return $row[0];
		
	}
	
	
}

?>