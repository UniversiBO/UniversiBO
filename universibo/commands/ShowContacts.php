<?php

include ('UniversiboCommand'.PHP_EXTENSION);

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
 
class ShowContacts extends UniversiboCommand {
	function execute()
	{

		$template =& $this->frontController->getTemplateEngine();
		
		$template->assign('contacts_altTitle', 'Chi Siamo');
		$template->assign('contacts_intro', 'Lo sviluppo di questo sito è principalmente opera di un team di studenti che ha lavorato in stretto contatto con l\'amministratore di sistema: un tecnico informatico che si è lasciato appassionare dal progetto. Qui di seguito ci presentiamo indicandovi una divisione in ruoli per aiutarvi nel decidere chi contattare, qualora aveste quesiti o consigli da rivolgerci.');

		$contacts_path = $this->frontController->appSettings['contactsPath'];
		$template->assign('contacts_path', $contacts_path);
		
	

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT u.username, c.intro, c.ruolo, u.email, c.recapito, c.obiettivi, c.foto, u.id_utente FROM collaboratore c, utente u WHERE c.id_utente=u.id_utente';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows = 0) return false;
		
		$arrayContatti=array();     //l'array di array da passare al template
		
		while($res->fetchInto($row)){
			$arrayContatti[]=array('username'=>$row[0], 'intro'=>$row[1], 'ruolo'=>$row[2], 'email'=>$row[3], 'recapito'=>$row[4], 'obiettivi'=>$row[5], 'foto'=>$row[6], 'id_utente'=>$row[7]);
		}
		$template->assign('contacts_personal', $arrayContatti);
		
		
		return 'default';						
	}
}

?>