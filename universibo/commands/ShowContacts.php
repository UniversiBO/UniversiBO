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
 
class ShowContacts extends UniversiboCommand {
	function execute()
	{

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$user =& $this->getSessionUser();
				
		$template->assign('contacts_langAltTitle', 'Chi Siamo');

		$contacts_path = $this->frontController->getAppSetting('contactsPath');
		$template->assign('contacts_path', $contacts_path);
		
	

		$db =& FrontController::getDbConnection('main');
	
		$arrayContatti=array();     //l'array di array da passare al template
		$collaboratori =& Collaboratore::selectCollaboratoriAll();
		$num_collaboratori = count($collaboratori);
		for($i = 0 ; $i < $num_collaboratori; $i++ )
		{
			$collaboratore =& $collaboratori[$i];
			$curr_user =& $collaboratore->getUser();
			$arrayContatti[] = array('username'=>$curr_user->getUsername(),
									 'intro'=>$collaboratore->getIntro(),
									 'ruolo'=>$collaboratore->getRuolo(),
									 'email'=>$curr_user->getEmail(),
									 'recapito'=>$collaboratore->getRecapito(),
									 'obiettivi'=>$collaboratore->getObiettivi(),
									 'foto'=>$collaboratore->getFotoFilename(),
									 'id_utente'=>$collaboratore->getIdUtente()
									);

		}
		$template->assign('contacts_langPersonal', $arrayContatti);
		
		
		
		$template->assign('contacts_langIntro', 'UniversiBO è l\'associazione studentesca universitaria dell\'Ateneo di Bologna che dal settembre 2004 supporta la Web Community degli studenti.

Attraverso l\'utilizzo di tecnologie OpenSource, UniversiBO si impegna a estendere i confini delle aule delle Facoltà ponendosi come innovativo luogo d\'incontro virtuale. Grazie alla diffusione e alla condivisione di "informazione", si propone infatti di incentivare gli studenti a partecipare attivamente alla vita universitaria. Desidera inoltre porsi come punto di collegamento tra il corpo docente e il mondo studentesco. Nel contempo promuove e favorisce l\'informatizzazione e la filosofia del Software Libero per l\'Università di Bologna.
 
Tutte le richieste di aiuto ed informazioni possono essere rivolte all\'indirizzo info_universibo@calvin.ing.unibo.it

UniversiBO nasce nel 2002 dall\'idea di tre studenti. Al momento attuale lo Staff è composto invece da circa '.$num_collaboratori.' collaboratori, quasi tutti studenti dell\' Ateneo bolognese.

Qui di seguito si presentano divisi per ruoli nel caso vogliate contattarli nello specifico per ogni vostra esigenza.');

		
		
		return 'default';
	}
}

?>