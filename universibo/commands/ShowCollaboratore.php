<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowContacts is an extension of UniversiboCommand class.
 *
 * It shows Contacts page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowCollaboratore extends UniversiboCommand {
	function execute()
	{

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		if (!array_key_exists('id_utente',$_GET) && !ereg( '^([0-9]{1,10})$' , $_GET['id_utente'] ) ) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>'L\'utente cercato non ? valido','file'=>__FILE__,'line'=>__LINE__)); 
					

		$contacts_path = $this->frontController->getAppSetting('contactsPath');

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT u.username, c.intro, c.ruolo, u.email, c.recapito, c.obiettivi, c.foto, u.id_utente FROM collaboratore c, utente u WHERE c.id_utente=u.id_utente AND u.id_utente='.$db->quote($_GET['id_utente']);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throwError(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if($rows = 0) Error::throwError(_ERROR_DEFAULT,array('msg'=>'L\'utente cercato non esiste','file'=>__FILE__,'line'=>__LINE__)); 
		
		$res->fetchInto($row);
		$link_foto = ($row[6]!==NULL) ? $row[7].'_'.$row[6] : $this->frontController->getAppSetting('fotoDefault');
		$arrayContatti = array('username'=>$row[0], 'intro'=>$row[1], 'ruolo'=>$row[2], 'email'=>$row[3], 'recapito'=>$row[4], 'obiettivi'=>$row[5], 'foto'=>$link_foto, 'id_utente'=>$row[7]);

		$template->assign('collaboratore_collaboratore', $arrayContatti);
		
		$template->assign('collaboratore_langAltTitle', 'Chi Siamo');
		$template->assign('collaboratore_langIntro', 'Scheda informativa di');
		$template->assign('contacts_path', $contacts_path);
		
		return 'default';
	}
}

?>