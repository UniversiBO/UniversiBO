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
		
		if (!array_key_exists('id_file', $param) || !ereg('^([0-9]{1,9})$', $param['id_file'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id del file richiesto non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		$bc        =& $this->getBaseCommand();
		$user      =& $bc->getSessionUser();
		$fc        =& $bc->getFrontController();
		$template  =& $fc->getTemplateEngine();
		$krono     =& $fc->getKrono();
		
		
		$file =& FileItem::selectFileItem($param['id_file']);
		
        $directoryFile = $fc->getAppSetting('filesPath');
		$nomeFile = $file->getIdFile().'_'.$file->getNomeFile();
		
		if (!$user->isGroupAllowed( $file->getPermessiVisualizza() ) )
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Non è permesso visualizzare il file.
			Non possiedi i diritti necessari, la sessione potrebbe essere scaduta.', 'file' => __FILE__, 'line' => __LINE__, 'log' => true));


		if (($user->isAdmin() || $user->getIdUser() == $file->getIdUtente() ))
		{
			$file_tpl['modifica']     = 'Modifica';
			$file_tpl['modifica_link']= 'index.php?do=FileEdit&id_file='.$file->getIdFile();
			$file_tpl['elimina']      = 'Elimina';
			$file_tpl['elimina_link'] = 'index.php?do=FileDelete&id_file='.$file->getIdFile();
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
		
		$template->assign('fileShowInfo_downloadUri', 'index.php?do=FileDownload&id_file='.$file->getIdFile());
		$template->assign('fileShowInfo_uri', 'index.php?do=FileShowInfo&id_file='.$file->getIdFile());
		$template->assign('fileShowInfo_titolo', $file->getTitolo());
		$template->assign('fileShowInfo_descrizione', $file->getDescrizione());
		$template->assign('fileShowInfo_userLink', 'ShowUser&id_utente='.$file->getIdUtente());
		$template->assign('fileShowInfo_username', $file->getUsername());
		$template->assign('fileShowInfo_dataInserimento', $krono->k_date('%j/%m/%Y', $file->getDataInserimento()));
		$template->assign('fileShowInfo_new', ($file->getDataModifica() < $user->getUltimoLogin() ) ? 'true' : 'false' );
		$template->assign('fileShowInfo_nomeFile', $nomeFile);
		$template->assign('fileShowInfo_dimensione',  $file->getDimensione());
		$template->assign('fileShowInfo_download',  $file->getDownload());
		$template->assign('fileShowInfo_hash',  $file->getHashFile());
		$template->assign('fileShowInfo_categoria', $file->getCategoriaDesc());
		$template->assign('fileShowInfo_tipo', $file->getTipoDesc());
		$template->assign('fileShowInfo_icona', $fc->getAppSetting('filesTipoIconePath').$file->getTipoIcona());
		$template->assign('fileShowInfo_info', $file->getTipoInfo());
		$template->assign('fileShowInfo_canali', $canali_tpl);
		$template->assign('fileShowInfo_paroleChiave', $file->getParoleChiave());
		
		return ;
		
	}

}

?>