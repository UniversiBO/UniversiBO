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
 
class ShowContacts extends UniversiboCommand {
	function execute()
	{

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template->assign('contacts_langAltTitle', 'Chi Siamo');

		$contacts_path = $this->frontController->getAppSetting('contactsPath');
		$template->assign('contacts_path', $contacts_path);
		
	

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT u.username, c.intro, c.ruolo, u.email, c.recapito, c.obiettivi, c.foto, u.id_utente FROM collaboratore c, utente u WHERE c.id_utente=u.id_utente';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;
		
		$arrayContatti=array();     //l'array di array da passare al template
		
		while($res->fetchInto($row))
		{
			$link_foto = ($row[6]!==NULL) ? $row[7].'_'.$row[6] : $this->frontController->getAppSetting('fotoDefault');
			$arrayContatti[] = array('username'=>$row[0], 'intro'=>$row[1], 'ruolo'=>$row[2], 'email'=>$row[3], 'recapito'=>$row[4], 'obiettivi'=>$row[5], 'foto'=>$link_foto, 'id_utente'=>$row[7]);
		}
		$template->assign('contacts_langPersonal', $arrayContatti);
		
		
		
		$template->assign('contacts_langIntro', 'UniversiBO è l\'associazione studentesca universitaria dell\'Ateneo di Bologna che dal Settembre 2004 si impegna a supportare la Web Community degli studenti.
		
		Attraverso l\'utilizzo di tecnologia OpenSource UniversiBO si propone di estendere i confini fisici delle aule e dei muri delle Facoltà, incentivando i partecipanti a partecipare alla vita universitaria attraverso la diffusione e la condivisione delle informazioni. Desidera inoltre porsi come punto di collegamento tra il corpo decente e il mondo studentesco e promuovere e favorire l\'informatizzazione e la filosofia del Software Libero dell\'Ateneo di Bologna.

		Tutte le richieste di aiuto ed informazioni possono essere rivolte all\'indirizzo '.$frontcontroller->getAppSetting('infoEmail').'
		
		Nato nel 2002 dall\'idea di tre amici al momento attuale lo staff è composto da '.$rows.' collaboratori la maggiorparte dei quali sono studenti che danno il loro prezioso contributo anche per piccole attività.
		Qui di seguito ci presentiamo indicandovi una divisione in ruoli per aiutarvi qualora aveste quesiti o bisogno di contattare qualcuno in particolare.');

		
		
		return 'default';
	}
}

?>