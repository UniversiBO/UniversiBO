<?php    

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * FileShowInfo: mostra tutte le informazioni correlate ad un file
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class FileShowInfo extends UniversiboCommand {

	function execute() 
	{
		
		if (!array_key_exists('id_file', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_file'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id del file richiesto non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		$frontcontroller = & $this->getFrontController();
		
		$template = & $frontcontroller->getTemplateEngine();
		$krono = & $frontcontroller->getKrono();
		$user =& $this->getSessionUser();
		
		
		$file =& FileItem::selectFileItem($_GET['id_file']);
		
        $directoryFile = $frontcontroller->getAppSetting('filesPath');
		$nomeFile = $file->getIdFile().'_'.$file->getNomeFile();
		
		if (!$user->isGroupAllowed( $file->getPermessiVisualizza() ) )
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Non è permesso visualizzare il file.
			Non possiedi i diritti necessari, la sessione potrebbe essere scaduta.', 'file' => __FILE__, 'line' => __LINE__, 'log' => true));


		if (($user->isAdmin() || $referente || $this_moderatore))
		{
			$file_tpl['modifica']     = 'Modifica';
			$file_tpl['modifica_link']= 'index.php?do=FileEdit&id_file='.$file->getIdFile();
			$file_tpl['elimina']      = 'Elimina';
			$file_tpl['elimina_link'] = 'index.php?do=FileDelete&id_file='.$file->getIdFile();
		}
		
		$template->assign('fileShowInfo_Downloaduri', 'index.php?do=FileDownload&id_file='.$file->getIdFile());
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
		$template->assign('fileShowInfo_icona', $frontcontroller->getAppSetting('filesTipoIconePath').$file->getTipoIcona());
		$template->assign('fileShowInfo_info', $file->getTipoInfo());

		
		return;
		
	}

}

?>