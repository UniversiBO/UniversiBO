<?php    

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * ShowFileInfo: mostra tutte le informazioni correlate ad un file
 *
 * @package universibo
 * @subpackage Files
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class ShowFileInfo extends PluginCommand {
	
	/**
	 * Esegue il plugin
	 *
	 * @param array $param id_file obbligatorio, id_canale facoltativo  
	 */
	function execute($param) 
	{
		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		
		if (!array_key_exists('id_file', $param) || !ereg('^([0-9]{1,9})$', $param['id_file'] )  )
		{
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUtente(), 'msg'=>'L\'id del file richiesto non ? valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
				
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();
		
		
		$template->assign('common_canaleURI', array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '' );
		$template->assign('common_langCanaleNome', 'indietro');
		
		if (array_key_exists('id_canale', $param) && ereg('^([0-9]{1,9})$', $param['id_canale']))
		{
			$canale = & Canale::retrieveCanale($param['id_canale']);
			$template->assign('common_canaleURI', $canale->showMe());
			$template->assign('common_langCanaleNome', 'a '.$canale->getTitolo());
		}
				
		$file =& FileItem::selectFileItem($param['id_file']);
		
		if ($file === false)
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUtente(), 'msg' => "Il file richiesto non ? presente su database", 'file' => __FILE__, 'line' => __LINE__));
		
		//var_dump($file);
        $directoryFile = $fc->getAppSetting('filesPath');
		$nomeFile = $file->getIdFile().'_'.$file->getNomeFile();
		
		if (!$user->isGroupAllowed( $file->getPermessiVisualizza() ) )
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUtente(), 'msg' => 'Non ? permesso visualizzare il file.
			Non possiedi i diritti necessari, la sessione potrebbe essere scaduta.', 'file' => __FILE__, 'line' => __LINE__, 'log' => true));

		$template->assign('showFileInfo_editFlag', 'false');
		$template->assign('showFileInfo_deleteFlag', 'false');
		
		//mancano dei diritti
		if (($user->isAdmin() || $user->getIdUser() == $file->getIdUtente() ))
		{
//			$file_tpl['modifica']     = 'Modifica';
//			$file_tpl['modifica_link']= 'index.php?do=FileEdit&id_file='.$file->getIdFile();
//			$file_tpl['elimina']      = 'Elimina';
//			$file_tpl['elimina_link'] = 'index.php?do=FileDelete&id_file='.$file->getIdFile();
			$template->assign('showFileInfo_editFlag', 'true');
			$template->assign('showFileInfo_deleteFlag', 'true');
			$template->assign('showFileInfo_editUri', 'index.php?do=FileEdit&id_file='.$file->getIdFile());
			$template->assign('showFileInfo_deleteUri', 'index.php?do=FileDelete&id_file='.$file->getIdFile());
		}
		
		
		$canali_tpl = array();
		$id_canali = $file->getIdCanali();
		foreach($id_canali as $id_canale)
		{ 
			$canale =& Canale::retrieveCanale($id_canale);
			$canali_tpl[$id_canale] = array();
			$canali_tpl[$id_canale]['titolo'] = $canale->getTitolo();
			$canali_tpl[$id_canale]['uri'] = $canale->showMe();
		}
		
		$template->assign('showFileInfo_downloadUri', 'index.php?do=FileDownload&id_file='.$file->getIdFile());
		$template->assign('showFileInfo_langDelete', 'Elimina');
		$template->assign('showFileInfo_langDownload', 'Scarica');
		$template->assign('showFileInfo_langEdit', 'Modifica');
		$template->assign('showFileInfo_uri', 'index.php?do=showFileInfo&id_file='.$file->getIdFile());
		$template->assign('showFileInfo_titolo', $file->getTitolo());
		$template->assign('showFileInfo_descrizione', $file->getDescrizione());
		$template->assign('showFileInfo_userLink', 'ShowUser&id_utente='.$file->getIdUtente());
		$template->assign('showFileInfo_username', $file->getUsername());
		$template->assign('showFileInfo_dataInserimento', $krono->k_date('%j/%m/%Y', $file->getDataInserimento()));
		$template->assign('showFileInfo_new', ($file->getDataModifica() < $user->getUltimoLogin() ) ? 'true' : 'false' );
		$template->assign('showFileInfo_nomeFile', $nomeFile);
		$template->assign('showFileInfo_dimensione',  $file->getDimensione());
		$template->assign('showFileInfo_download',  $file->getDownload());
		$template->assign('showFileInfo_hash',  $file->getHashFile());
		$template->assign('showFileInfo_categoria', $file->getCategoriaDesc());
		$template->assign('showFileInfo_tipo', $file->getTipoDesc());
		$template->assign('showFileInfo_icona', $fc->getAppSetting('filesTipoIconePath').$file->getTipoIcona());
		$template->assign('showFileInfo_info', $file->getTipoInfo());
		$template->assign('showFileInfo_canali', $canali_tpl);
		$template->assign('showFileInfo_paroleChiave', $file->getParoleChiave());
		
		return ;
		
	}

}

?>