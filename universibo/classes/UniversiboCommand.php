<?php

require_once('User'.PHP_EXTENSION);

/**
 * UniversiboCommand is the abstract super class of all command classes
 * used in the universibo application.
 *
 * Adds user authorization and double view (popup/index)
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class UniversiboCommand extends BaseCommand {
	
	/**
	 * User
	 * @private 
	 */
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
	 * Restituisce true se un utente (anche ospite) è stato registrato nella sessione corrente
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
	 * Può essere chiamata solo dopo che è stata eseguita initCommand altrimenti
	 * il valore di ritorno è indefinito
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
		
		$template =& $frontController->getTemplateEngine();
		$template->assign('error_notice_present', 'false');
		
		$this->_setUpUserUniversibo();
		
		$this->_setUpTemplateUniversibo();
		
	}
	
	
	
	/**
	 * Ridefinisce il metodo della classe padre
	 * Si occupa di raccogliere tutti gli errori non ancora lanciati
	 */ 
	function shutdownCommand()
	{
		parent::shutdownCommand();
		
		while ( ($current_error = Error::retrieve(_ERROR_NOTICE)) !== false )
		{
			echo $current_error->throw();
		}
		
		while ( ($current_error = Error::retrieve(_ERROR_DEFAULT)) !== false )
		{
			echo $current_error->throw();
		}
		
		while ( ($current_error = Error::retrieve(_ERROR_CRITICAL)) !== false )
		{
			echo $current_error->throw();
		}
		
	}
	
	
	
	
	/**
	 * Inizializza le informazioni utente dell' UniversiboCommand
	 *
	 * @private
	 */
	function _setUpUserUniversibo()
	{
		
		if (! $this->sessionUserExists() )
		{
			$this->sessionUser = new User(0, USER_OSPITE);
			$this->setSessionIdUtente(0);
		}
		elseif ( $this->getSessionIdUtente() >= 0 )
		{
			$this->sessionUser =& User::selectUser( $this->getSessionIdUtente() );
//			echo $this->sessionUser->getUsername();
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
	function _setUpTemplateUniversibo()
	{
		
		$template =& $this->frontController->getTemplateEngine();
		$krono =& $this->frontController->getKrono();
        //var_dump($template);
		
		if ( array_key_exists('pageType', $_GET) && $_GET['pageType']=='popup' )
		{
			$template->assign('common_pageType', 'popup');
			$this->_setUpTemplatePopupUniversibo();
		}
		else
		{
			$template->assign('common_pageType', 'index');
			$this->_setUpTemplateIndexUniversibo();
		}
		
		//riferimenti per ottimizzare gli accessi
		$templateInfo =& $this->frontController->templateInfo;
		$fc = $this->getFrontController();
		
		$template->assign('common_templateBaseDir', $templateInfo['web_dir'].$templateInfo['styles'][$templateInfo['template_name']]);
		
		$temp_template_list = $this->frontController->templateEngine['styles'];
		$template_list = array ();
		$i = 0;
		foreach ($temp_template_list as $key => $value)
		{
			$template_list[$i] = array('uri' => 'index.php?setTemplate='.$key , 'label' => $key );
			$i++;
		}
		
		$template->assign('common_templateList', $template_list );
		
		$request_protocol = (array_key_exists('HTTPS',$_SERVER) && $_SERVER['HTTPS']=='on')? 'https':'http';
		
		// http | https
		$template->assign('common_protocol',	$request_protocol);
		// www.universibo.unibo.it
		$template->assign('common_hostName',	$_SERVER['HTTP_HOST']);
		// https://www.universibo.unibo.it/path_universibo2/
		// $template->assign('common_rootUrl',		$request_protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$this->frontController->rootUrl);
		// https://www.universibo.unibo.it/path_universibo2/receiver.php
		$template->assign('common_receiverUrl',	$request_protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']);
		// https://www.universibo.unibo.it/path_universibo2/receiver.php?do=SomeCommand
		$template->assign('common_requestUri',	$request_protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		// /path_universibo2/receiver.php?do=SomeCommand
		$template->assign('common_shortUri',	$_SERVER['REQUEST_URI']);
		
		$template->assign('common_homepage',	'Homepage');
		$template->assign('common_homepageUri',	'index.php?do=ShowHome');

		require_once ('ForumApi'.PHP_EXTENSION);
		$forum = new ForumApi();
		$template->assign('common_forum',		'Forum');
		$template->assign('common_forumDir',	$forum->getPath() );
		$template->assign('common_forumUri',	$forum->getMainUri() );
		
		$template->assign('common_homepage',	'Homepage');
		$template->assign('common_homepageUri',	'index.php?do=ShowHome');

		$template->assign('common_rootEmail',	$fc->getAppSetting('rootEmail') );
		$template->assign('common_infoEmail',	$fc->getAppSetting('infoEmail') );
		$template->assign('common_staffEmail',	$fc->getAppSetting('staffEmail') );
		$template->assign('common_alert',		$fc->getAppSetting('alertMessage') );
		
		//generali
		$template->assign('common_universibo',		'UniversiBO');
		$template->assign('common_metaKeywords',	'universibo, università, facoltà, studenti, bologna, professori, lezioni, materiale didattico, didattica, corsi, studio, studi, novità, appunti, dispense, lucidi, esercizi, esami, temi d\'esame, orari lezione, ingegneria, economia, ateneo');
		$template->assign('common_metaDescription',	'Il portale dedicato agli studenti universitari di Bologna');
		$template->assign('common_title',			'UniversiBO ...il portale dedicato agli studenti universitari di Bologna');
		
		//kronos
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
	function _setUpTemplateIndexUniversibo()
	{
		
		$template =& $this->frontController->getTemplateEngine();
		$krono =& $this->frontController->getKrono();
			
		//solo nella pagine index
		$curr_mday=date("j");  //inizializzo giorno corrente
		$curr_mese=date("n");  //inizializzo mese corrente
		$curr_anno=date("Y");  //inizializzo anno corrente
		$logoType = 'default';
		if    ($curr_mese==8) $logoType = 'estate'; 
		elseif($curr_mday==8 && $curr_mese==3) $logoType = '8marzo';
		elseif($curr_mday==31 && $curr_mese==11) $logoType = 'halloween';
		elseif($curr_mday==14 && $curr_mese==2) $logoType = 'svalentino';
		elseif(($curr_mese==12 && $curr_mday>=8) || ($curr_mese==1 && $curr_mday<=7) ) $logoType = 'natale';
		elseif((easter_date($curr_anno)==mktime(0,0,0,$curr_mese,$curr_mday,$curr_anno) ) || (easter_date($curr_anno)==mktime(0,0,0,$curr_mese,$curr_mday-1,$curr_anno) )) $logoType = 'pasqua';
		elseif(false) $logoType = 'carnevale';  //cambiare questa riga a carnevale o trovare il modo per calcolarlo
		
		$template->assign('common_logoType', $logoType); //estate/natale/8marzo/pasqua/carnevale/svalentino/halloween/ecc...
		$template->assign('common_logo', 'Logo UniversiBO');
		
		
		$template->assign('common_setHomepage', 'Imposta Homepage');
		$template->assign('common_addBookmarks', 'Aggiungi ai preferiti');
		
		$session_user = $this->getSessionUser();
		if ($session_user->isOspite())
		{
			$template->assign('common_userLoggedIn', 'false');
			
		}
		else
		{
			$template->assign('common_userLoggedIn', 'true');
			$template->assign('common_userUsername', $session_user->getUsername());
			//$livelli = User::groupsNames();
			$template->assign('common_userLivello', $session_user->getUserGroupsNames());

			$template->assign('common_langWelcomeMsg', 'Benvenuto');
			$template->assign('common_langUserLivello', 'Il tuo livello di utenza è');
			
		}
		
		$template->assign('common_settings', 'Impostazioni');
		$template->assign('common_settingsUri', 'index.php?do=ShowSettings');

		$template->assign('common_myUniversiBO', 'my UniversiBO');
		$template->assign('common_myUniversiBOUri', 'index.php?do=MyUniversiBO');

		$template->assign('common_fac', 'Facoltà');
		require_once('Facolta'.PHP_EXTENSION);
		$elenco_facolta =& Facolta::selectFacoltaElenco();
		//var_dump($elenco_facolta);
		
		$num_facolta = count($elenco_facolta);
		$i = 0;
		$session_user =& $this->getSessionUser();
		$session_user_groups = $session_user->getGroups();
		$common_facLinks = array();
		for ($i=0; $i<$num_facolta; $i++)
		{
			if ( $elenco_facolta[$i]->isGroupAllowed( $session_user_groups ) ) 
			{
				$common_facLinks[$i] = array (); 
				$common_facLinks[$i]['uri']   = 'index.php?do=ShowFacolta&amp;id_canale='.$elenco_facolta[$i]->getIdCanale();  
				$common_facLinks[$i]['label'] = $elenco_facolta[$i]->getNome(); 			
			}
		}
		$template->assign('common_facLinks', $common_facLinks);
		
		$template->assign('common_services', 'Servizi');
		$common_servicesLinks = array();
		$common_servicesLinks[] = array ('label'=>'Appunti - Latex', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Biblioteca', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Erasmus', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Eventi', 'uri'=>'http://www.example.com'); 
		$common_servicesLinks[] = array ('label'=>'Moderatori', 'uri'=>'http://www.example.com'); 
		$template->assign('common_servicesLinks', $common_servicesLinks);
		
		$template->assign('common_info', 'Informazioni');
		$template->assign('common_help', 'Help');
		$template->assign('common_helpUri', 'index.php?do=ShowHelp');
		$template->assign('common_helpByTopic', 'Help per argomenti');
		$template->assign('common_helpByTopicUri', 'index.php?do=ShowHelpTopic');
		$template->assign('common_rules', 'Regolamento');
		$template->assign('common_rulesUri', 'index.php?do=ShowRules');
		$template->assign('common_contacts', 'Contatti - (chi siamo)');
		$template->assign('common_contactsUri', 'index.php?do=ShowContacts');
		$template->assign('common_contribute', 'Collabora');
		$template->assign('common_contributeUri', 'index.php?do=ShowContribute');
		$template->assign('common_credits', 'Credits');
		$template->assign('common_creditsUri', 'index.php?do=ShowCredits');
		
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
												'Con il contenuto delle pagine appartenenti a questo sito non si è voluto ledere i diritti di nessuno, quindi nel malaugurato caso che questo possa essere avvenuto, vi invitiamo a contattarci affinchè le parti in discussione vengano eliminate o chiarite.');
		
		$template->assign( 'common_isSetVisite', 'N' );
		
		
	}
	


	/**
	 * Inizializza le variabili del template per le pagine popup
	 *
	 * @private
	 * @todo implementare  
	 */
	function _setUpTemplatePopupUniversibo()
	{
		
	}
		
}
?>