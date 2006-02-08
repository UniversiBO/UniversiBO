<?php

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('Files/FileItemStudenti'.PHP_EXTENSION);
require_once ('PluginCommand'.PHP_EXTENSION);

/**
 * ShowAllFilesStudenti e\' un comando che permette di visualizzare tutti i 
 * files studenti presenti su UniversiBO 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Daniele Tiles <daniele.tiles@gmail.com>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
 class ShowAllFilesStudenti extends UniversiboCommand
 {
 	function execute()
 	{
 		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$user =& $this->getSessionUser();	
		$arrayFilesStudenti = array();
		
		if (!array_key_exists('order', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['order'] ) || ($_GET['order'] > 1) )
		{
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUser(), 'msg'=>'L\'ordine richiesto non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		$order = $_GET['order'];
		
		$arrayFilesStudenti = $this->getAllFiles($order);
		$this->executePlugin('ShowAllFilesStudentiTitoli', array('files'=>$arrayFilesStudenti,'chk_diritti'=>false));
		if($order == 0)
		{
			$template->assign('showAllFilesStudenti_url','index.php?do=ShowAllFilesStudenti&order=1');
		    $template->assign('showAllFilesStudenti_lang','Mostra i Files Studenti ordinati per data di inserimento');
		}
		else
		{
			$template->assign('showAllFilesStudenti_url','index.php?do=ShowAllFilesStudenti&order=0');
			$template->assign('showAllFilesStudenti_lang','Mostra i Files Studenti ordinati per nome');
		}
		
 	}
 	
 	function & getAllFiles($order)//c\`era $num
	{ 
		$quale_query = '';
		
		if($order == 0)
		{
			$quale_query = 'titolo';
		}
		else
		{
			$quale_query = 'data_inserimento DESC';
		}
		
		
		$db =& FrontController::getDbConnection('main');
		$query = 'SELECT A.id_file FROM file A, file_studente_canale B 
					WHERE A.id_file = B.id_file AND eliminato!='.$db->quote( FILE_ELIMINATO ).
					'ORDER BY A.'.$quale_query;
//		$res =& $db->limitQuery($query, 0 , $num);
		$res =& $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $this->sessionUser->getIdUser(), 'msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		
		$id_files_studenti_list = array();
	
		while ( $res->fetchInto($row) )
		{
			$id_files_studenti_list[]= $row[0];
		}
		
		$res->free();
		
		$files_studenti_list = FileItemStudenti::selectFileItems($id_files_studenti_list);
		return $files_studenti_list;
		
	}
 }

?>
