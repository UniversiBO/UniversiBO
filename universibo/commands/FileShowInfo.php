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
		$user =& $this->getSessionUser();
		
		
		$file =& FileItem::selectFileItem($_GET['id_file']);
		
        $directoryFile = $frontcontroller->getAppSetting('filesPath');
		$nomeFile = $file->getIdFile().'_'.$file->getNomeFile();
		
		if (!$user->isGroupAllowed( $file->getPermessiVisualizza() ) )
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Non è permesso visualizzare il file.
			Non possiedi i diritti necessari, la sessione potrebbe essere scaduta.', 'file' => __FILE__, 'line' => __LINE__, 'log' => true));


		$template->assign('fileShowInfo_Uri', 'index.php?do=FileShowInfo&id_file='.$file->getIdFile());
		$template->assign('fileShowInfo_Titolo', $file->getTitolo());
		$template->assign('fileShowInfo_Descrizione', $file->getDescrizione());
		$template->assign('fileShowInfo_Username', $file->getUsername());
		$template->assign('fileShowInfo_DataInserimento', $file->getDataInserimento());
		$template->assign('fileShowInfo_New', ($file->getDataModifica() < $user->getUltimoAccesso() ) ? 'true' : 'false' );
		$template->assign('fileShowInfo_NomeFile', $nomeFile);
		$template->assign('fileShowInfo_Hash',  $file->getHashFile());
		$template->assign('fileShowInfo_', $file->getIdFile());
		$template->assign('fileShowInfo_', $file->getIdFile());
		$template->assign('fileShowInfo_', $file->getIdFile());

		$this->username = $username;
		$this->categoria_desc = $categoria_desc;
		$this->tipo_desc = $tipo_desc;
		$this->tipo_icona = $tipo_icona;
		$this->tipo_info = $tipo_info;


        $directoryFile = $frontcontroller->getAppSetting('directoryFile');
        //$directoryFileUri = $frontcontroller->getAppSetting('directoryFileUri');
		
		$nomeFile = $directoryFile.$file->getNomeFile();
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) 
		{
			// had to make it MSIE 5.5 because if 6 has no "attachment;"
			// in it defaults to "inline"
			$attachment = "";
		}
		else
		{
			$attachment = "attachment;";
		}
		header('Content-Type: application/octet-stream');
		header('Cache-Control: private');
		header('Pragma: dummy-pragma');
		header("Expires: ". gmdate("D, d M Y H:i:s")." GMT"); // Date in the past
		header("Last-Modified: ". gmdate("D, d M Y H:i:s")." GMT"); // always modified
		header("Content-Length: ". @filesize($nomeFile));
		////header("Content-type: application/force-download");
		header("Content-type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: $attachment filename=".basename($nomeFile));
		
		//echo $nomeFile; 
		readfile($nomeFile);
		
		/**
		 * @todo ...da togliere die() dopo che si è messo on-line e tolto il tempo di esecuzione
		 */
		die();
		
		return;
		
	}

}

?>