<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Collaboratore'.PHP_EXTENSION);

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
		$user =& $this->getSessionUser();
		if (!array_key_exists('id_utente',$_GET) && !ereg( '^([0-9]{1,10})$' , $_GET['id_utente'] ) ) 
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $user->getIdUtente(), 'msg'=>'L\'utente cercato non ? valido','file'=>__FILE__,'line'=>__LINE__)); 
					

		$contacts_path = $frontcontroller->getAppSetting('contactsPath');

		$collaboratore =& Collaboratore::selectCollaboratore(81);
		$curr_user =& $collaboratore->getUser();
		$arrayContatti = array('username'=>$curr_user->getUsername(),
								 'intro'=>$collaboratore->getIntro(),
								 'ruolo'=>$collaboratore->getRuolo(),
								 'email'=>$curr_user->getEmail(),
								 'recapito'=>$collaboratore->getRecapito(),
								 'obiettivi'=>$collaboratore->getObiettivi(),
								 'foto'=>$collaboratore->getFotoFilename(),
								 'id_utente'=>$collaboratore->getIdUtente()
								);

		$template->assign('collaboratore_collaboratore', $arrayContatti);
		
		$template->assign('collaboratore_langAltTitle', 'Chi Siamo');
		$template->assign('collaboratore_langIntro', 'Scheda informativa di');
		$template->assign('contacts_path', $contacts_path);
		
		return 'default';
	}
}

?>