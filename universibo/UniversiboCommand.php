<?php

/**
 * UniversiboCommand is the abstract super class of all command classes
 * used in the universibo application.
 *
 * Adds user authorization and double view (popup/index)
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class UniversiboCommand extends BaseCommand {
	
	var $sessionUser;



	/**
	 * Restituisce l'id_utente del dello user nella sessione corrente
	 *
	 * @static
	 * @param string $password stringa della password da verificare
	 * @return boolean
	 */
	function getSessionIdUtente()
	{
		return $_SESSION['id_utente'];
	}

	

	/**
	 * Salva l'id_utente dello user nella sessione corrente
	 *
	 * @static
	 * @protected
	 * @param int $id_utente id_utente dello user
	 */
	function setSessionIdUtente($id_utente)
	{
		$_SESSION['id_utente'] = $id_utente;
	}

	

	/**
	 * Restituisce true se un utente (anche ospite) � stato registrato nella sessione corrente
	 *
	 * @static
	 * @return boolean
	 */
	function sessionUserExists()
	{
		return array_key_exists('id_utente', $_SESSION) && isset($_SESSION['id_utente']);
	}



	/**
	 * Restituisce l'oggetto utente della sessione corrente.
	 *
	 * Pu� essere chiamata solo dopo che � stata eseguita initCommand altrimenti
	 * il valore di ritorno � indefinito
	 *
	 * @return User
	 */
	function &getSessionUser()
	{
		return $this->sessionUser;
	}

	

	/**
	 * Inizializza l' UniversiboCommand ridefinisce l'init() del BaseCommand.
	 */
	function initCommand( &$frontController )
	{
		parent::initCommand( $frontController );
		
		$this->_setUpUser();
		
		$this->_setUpTemplate();
		
	}
	


	/**
	 * Inizializza le informazioni utente dell' UniversiboCommand
	 *
	 * @private  
	 */
	function _setUpUser()
	{
		require_once('User.php');
		
		if (! $this->sessionUserExists() )
		{
			$this->sessionUser = new User(0, USER_OSPITE);
			$this->setSessionIdUtente(0);
		}
		elseif ( $this->getSessionIdUtente() >= 0 )
		{
			$this->sessionUser &= User::selectUser( $this->getSessionIdUtente() );
			
		}
		else 
			Error::throw(_ERROR_CRITICAL,array('msg'=>'id_utente registrato nella sessione non valido','file'=>__FILE__,'line'=>__LINE__));
			
	}



	/**
	 * Inizializza le informazioni comuni del template dell' UniversiboCommand
	 * esegue distizione tra pagine con indice completo e popup
	 *
	 * @private  
	 */
	function _setUpTemplate()
	{
		
		$template =& $this->frontController->getTemplateEngine();
        //var_dump($template);

		if ( array_key_exists('pageType', $_GET) && $_GET['pageType']=='popup' )
		{ 
			$template->assign('common_pageType', 'popup');
			$this->_setUpTemplatePopup();
		}
		else
		{
			$template->assign('common_pageType', 'index');
			$this->_setUpTemplateIndex();
		}
		
		//riferimenti per ottimizzare gli accessi
		$templateInfo =& $this->frontController->templateInfo;
		$appSettings =& $this->frontController->appSettings;

		$template->assign('common_templateBaseDir',$templateInfo['web_dir'].$templateInfo['styles'][$templateInfo['template_name']]);

		//da config.xml
		$template->assign('common_rootUrl',   'https://universibo.ing.unibo.it/');
		$template->assign('common_protocol',   'https'); 
		$template->assign('common_hostName',   'universibo.unibo.it');
		$template->assign('common_forumDir',   'forum');
		
		$template->assign('common_rootEmail',  $appSettings['rootEmail'] );
		$template->assign('common_staffEmail', $appSettings['staffEmail'] );
		$template->assign('common_alert',      $appSettings['alertMessage'] );

		//generali
		$template->assign('common_universibo',      'UniversiBO');
		$template->assign('common_metaKeywords',    'universibo, universit�, facolt�, studenti, bologna, professori, lezioni, materiale didattico, didattica, corsi, studio, studi, novit�, appunti, dispense, lucidi, esercizi, esami, temi d\'esame, orari lezione, ingegneria, economia, ateneo');
		$template->assign('common_metaDescription', 'Il portale dedicato agli studenti universitari di Bologna');
		$template->assign('common_title',           'UniversiBO ....il portale dedicato agli studenti universitari di Bologna');
		
		//kronos
		$krono =& $this->frontController->getKrono();
		$template->assign('common_veryLongDate', $krono->k_date() );
		$template->assign('common_longDate',     $krono->k_date('%j %F %Y') );
		$template->assign('common_shortDate',    $krono->k_date('%j/%m/%Y') );
		$template->assign('common_time',         $krono->k_date('%H:%i') );
	
				
	}


	/**
	 * Inizializza le variabili del template per le pagine con indice completo
	 *
	 * @private  
	 */
	function _setUpTemplateIndex()
	{
			
		$template =& $this->frontController->getTemplateEngine();

		//solo nella pagine index
		$template->assign('common_logo', 'Logo UniversiBO');
		$template->assign('common_logoType', 'default'); //estate/natale/8marzo/pasqua/carnevale/svalentino/halloween/ecc...
		$template->assign('common_setHomepage', 'Imposta Homepage');
		$template->assign('common_addBookmarks', 'Aggiungi ai preferiti');

		$template->assign('common_fac', 'Facolt�');
		$common_facLinks = array();
		$common_facLinks[] = array ('label'=>'Ingegneria', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Economia', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Nome facolt�1', 'uri'=>'http://www.example.com'); 
		$common_facLinks[] = array ('label'=>'Nome facolt�2', 'uri'=>'http://www.example.com'); 
		$template->assign('common_facLinks', $common_facLinks);

		$template->assign('common_services', 'Servizi');
		$common_servicesLinks = array();
		$common_servicesLinks[] = array ('label'=>'Appunti - Latex', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Biblioteca', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Eventi', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Moderatori', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Grafica', 'uri'=>'http://www.example.com'); 
		$template->assign('common_servicesLinks', $common_servicesLinks);

		$template->assign('common_info', 'Informazioni');
		$template->assign('common_help', 'Help');
		$template->assign('common_helpUri', 'index.php?do=ShowHelp');
		$template->assign('common_rules', 'Regolamento');
		$template->assign('common_rulesUri', 'index.php?do=ShowRules');
		$template->assign('common_contacts', 'Contatti - (chi siamo)');
		$template->assign('common_contactsUri', 'index.php?do=ShowContacts');
		$template->assign('common_contribute', 'Collabora');
		$template->assign('common_contributeUri', 'index.php?do=ShowContribute');

		$template->assign('common_manifesto', 'Manifesto');
		$template->assign('common_manifestoUri', 'index.php?do=ShowManifesto');

		$template->assign('common_calendar', 'Calendario');
		$common_calendarLink = array ('label'=>'Agosto', 'uri'=>'index.php?do=ShowCalendar&amp;month=8'); 
		$template->assign('common_calendarLink', $common_calendarLink);
		
		$template->assign('common_docUri', 'http://nikita.ing.unibo.it/~eagleone/documentazione_progetto/');
		$template->assign('common_doc', 'Documentazione');
		$template->assign('common_docUri', 'http://nikita.ing.unibo.it/~eagleone/documentazione_progetto/');
		$template->assign('common_project', 'UniversiBO Open Source Project');
		$template->assign('common_projectUri', 'http://universibo.sourceforge.net/');


		$template->assign('common_disclaimer', 'Ogni marchio citato in questa pagina appartiene al legittimo proprietario.'.
												'Con il contenuto delle pagine appartenenti a questo sito non si � voluto ledere i diritti di nessuno, quindi nel malaugurato caso che questo possa essere avvenuto, vi invitiamo a contattarci affinch� le parti in discussione vengano eliminate o chiarite.');

	}
	


	/**
	 * Inizializza le variabili del template per le pagine popup
	 *
	 * @private  
	 */
	function _setUpTemplatePopup()
	{

	}
		
}
?>