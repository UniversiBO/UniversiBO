<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * ShowFileTitoli è un'implementazione di PluginCommand.
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
 
class ShowFileTitoli extends PluginCommand {
	
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param nessu parametro  
	 */
	function execute($param)
	{
		//$flag_chkDiritti	=  $param['chk_diritti'];
//		var_dump($param['id_notizie']);
//		die();
		
		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$canale    =& $bc->getRequestCanale();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();


		$id_canale = $canale->getIdCanale();
		$titolo_canale =  $canale->getTitolo();
		$ultima_modifica_canale =  $canale->getUltimaModifica();
		$user_ruoli =& $user->getRuoli();

		$personalizza_not_admin = false;

		$template->assign('showFileTitoli_addFileFlag', 'false');
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
			
			if ( $user->isAdmin() || $referente || $moderatore )
			{
				$template->assign('showFileTitoli_addFileFlag', 'true');
				$template->assign('showFileTitoli_addFile', 'Invia un nuovo file');
				$template->assign('showFileTitoli_addFileUri', 'index.php?do=FileAdd&id_canale='.$id_canale);
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
//		var_dump($elenco_id_news);
//		die();
//		var_dump($elenco_id_news);
//		die();

		$elenco_id_file =& $this->getFileCanale($id_canale);
		
		
		//var_dump($elenco_id_file); die();
		$elenco_file =& FileItem::selectFileItems($elenco_id_file);
		//var_dump($elenco_file); die();

		$elenco_file_tpl = array();

		if ($elenco_file ==! false )
		{
			
			$ret_file = count($elenco_file);

			for ($i = 0; $i < $ret_file; $i++)
			{
				$file =& $elenco_file[$i];
				//var_dump($file);
				$this_moderatore = ($user->isAdmin() || ($moderatore && $file->getIdUtente()==$user->getIdUser()));
		
				$permessi_lettura = $file->getPermessiVisualizza();
				if ($user->isGroupAllowed($permessi_lettura))
				{			
					$elenco_file_tpl[$i]['titolo']       = $file->getTitolo();
					//$elenco_file_tpl[$i]['notizia']      = $file->getNotizia();
					$elenco_file_tpl[$i]['data']         = $krono->k_date('%j/%m/%Y - %H:%i', $file->getDataInserimento());
					//echo $personalizza,"-" ,$ultimo_accesso,"-", $file->getUltimaModifica()," -- ";
					//$elenco_file_tpl[$i]['nuova']        = ($flag_chkDiritti && $personalizza_not_admin && $ultimo_accesso < $file->getUltimaModifica()) ? 'true' : 'false'; 
					$elenco_file_tpl[$i]['nuova']        = ($personalizza_not_admin && $ultimo_accesso < $file->getDataModifica()) ? 'true' : 'false';
					$elenco_file_tpl[$i]['autore']       = $file->getUsername();
					$elenco_file_tpl[$i]['autore_link']  = 'ShowUser&id_utente='.$file->getIdUtente();
					$elenco_file_tpl[$i]['id_autore']    = $file->getIdUtente();
					$elenco_file_tpl[$i]['modifica']     = '';
					$elenco_file_tpl[$i]['modifica_link']= '';
					$elenco_file_tpl[$i]['elimina']      = '';
					$elenco_file_tpl[$i]['elimina_link'] = '';
					//if ( ($user->isAdmin() || $referente || $this_moderatore)  && $flag_chkDiritti)
					if (($user->isAdmin() || $referente || $this_moderatore))
					{
						$elenco_file_tpl[$i]['modifica']     = 'Modifica';
						$elenco_file_tpl[$i]['modifica_link']= 'index.php?do=FileEdit&id_file='.$file->getIdFile().'&id_canale='.$id_canale;
						$elenco_file_tpl[$i]['elimina']      = 'Elimina';
						$elenco_file_tpl[$i]['elimina_link'] = 'index.php?do=FileDelete&id_file='.$file->getIdFile().'&id_canale='.$id_canale;
					}
					$elenco_file_tpl[$i]['dimensione'] = $file->getDimensione();
					$elenco_file_tpl[$i]['download_uri'] = '';
					$permessi_download = $file->getPermessiDownload();
					if ($user->isGroupAllowed($permessi_download))
						$elenco_file_tpl[$i]['download_uri'] = 'index.php?do=FileDownload&id_file='.$file->getIdFile().'&id_canale='.$id_canale;
					$elenco_file_tpl[$i]['categoria'] = $file->getCategoriaDesc();
					$elenco_file_tpl[$i]['show_info_uri'] = 'index.php?do=FileShowInfo&id_file='.$file->getIdFile().'&id_canale='.$id_canale;
				}
			}
		
		}
		
		$num_file = count($elenco_file_tpl);
		if ( $num_file == 0 )
		{
			$template->assign('showFileTitoli_langFileAvailable', 'Non ci sono file da visualizzare');
			$template->assign('showFileTitoli_langFileAvailableFlag', 'false');
		}
		else
		{
			$template->assign('showFileTitoli_langFileAvailable', 'Ci sono '.$num_file.' file');
			$template->assign('showFileTitoli_langFileAvailableFlag', 'true');
		}
		
		$template->assign('showFileTitoli_fileList', $elenco_file_tpl);

		
	}
	
	
	/**
	 * Preleva da database i file del canale $id_canale
	 *
	 * @static 
	 * @param int $id_canale identificativo su database del canale
	 * @return array elenco FileItem , array vuoto se non ci sono file
	 */
	function &getFileCanale($id_canale)
	{
	 	
	 	$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT A.id_file  FROM file A, file_canale B 
					WHERE A.id_file = B.id_file AND eliminato!='.$db->quote( FILE_ELIMINATO ).
					' AND B.id_canale = '.$db->quote($id_canale).' 
					ORDER BY A.data_inserimento DESC';
		$res =& $db->query($query);
		
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$id_file_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$id_file_list[]= $row[0];
		}
		
		$res->free();
		
		return $id_file_list;
		
	}
}

?>