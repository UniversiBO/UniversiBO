<?php

require_once('UniversiboCommand'.PHP_EXTENSION);
require_once('Canale'.PHP_EXTENSION);


/**
 * CanaleCommand ? la superclasse astratta di tutti i command che utilizzando un oggetto Canale
 *
 * Un Canale ? una pagina dinamica con a disposizione il collegamento 
 * verso i vari servizi tramite un indentificativo, gestisce i diritti di
 * accesso per i diversi gruppi e diritti particolari 'ruoli' per alcuni utenti,
 * fornisce sistemi di notifica e per assegnare un nome ad un canale
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class CanaleCommand extends UniversiboCommand 
{
	/**
	 * @private 
	 */
	var $requestCanale;

	
	/**
	 * Restituisce l'id_canale corrente, se non ? specificato nella richiesta HTTP-GET si considera 
	 * default l'homepage id_canale = 1
	 *
	 * @static
	 * @return int
	 */
	function getRequestIdCanale()
	{
		if (!array_key_exists('id_canale', $_GET ) )
		{
			if ($this->frontController->getCommandRequest() == 'ShowHome') return 1;
			else Error::throw(_ERROR_DEFAULT,array('msg'=>'il parametro id_canale non ? specificato nella richiesta','file'=>__FILE__,'line'=>__LINE__));
		}

		if (!ereg('^([0-9]+)$', $_GET['id_canale'] ) )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'il parametro id_canale ? sintatticamente non valido','file'=>__FILE__,'line'=>__LINE__));

		return intval($_GET['id_canale']);
	}

	
	/**
	 * Restituisce l'oggetto canale della richiesta web corrente
	 *
	 * @return Canale
	 */
	function &getRequestCanale()
	{
		return $this->requestCanale;
	}

	
	/**
	 * Inizializza il CanaleCommand ridefinisce l'init() dell'UniversiboCommand.
	 */
	function initCommand( &$frontController )
	{
		
		parent::initCommand( $frontController );
		
		$this->_setUpCanaleCanale();
		
		$this->_setUpTemplateCanale();
		
	}


	/**
	 * Inizializza le informazioni del canale di CanaleCommand 
	 * Esegue il dispatch inizializzndo il corretto sottotipo di 'canale' 
	 *
	 * @private  
	 */
	function _setUpCanaleCanale()
	{
		
		$this->requestCanale =& Canale::retrieveCanale($this->getRequestIdCanale());
		
		//$this->requestCanale =& $class_name::factoryCanale( $this->getRequestIdCanale() );
		
		if ( $this->requestCanale === false ) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il canale richiesto non è presente','file'=>__FILE__,'line'=>__LINE__));
		
		$canale =& $this->getRequestCanale();
		$user =& $this->getSessionUser();
		
		if ( ! $canale->isGroupAllowed( $user->getGroups() ) )
			Error::throw(_ERROR_DEFAULT, array('msg'=>'Non ti è permesso l\'accesso al canale selezionato, la sessione potrebbe essere scaduta','file'=>__FILE__,'line'=>__LINE__ ) );
		
		$canale->addVisite();
			
	}
	
	
	
	/**
	 * Inizializza le informazioni del canale di CanaleCommand
	 *
	 * @private  
	 */
	function _setUpTemplateCanale()
	{
		
		$template =& $this->frontController->getTemplateEngine();
        //var_dump($template);
		$canale =& $this->getRequestCanale();
		$id_canale = $this->getRequestIdCanale();
		$user =& $this->getSessionUser();
		
		if(!$user->isOspite())
		{
			$user_ruoli =& $user->getRuoli();
			if (array_key_exists($id_canale, $user_ruoli) && $user_ruoli[$id_canale]->isMyUniversiBO())
			{
				$template->assign( 'common_canaleMyUniversiBO', 'remove');
				$template->assign( 'common_langCanaleMyUniversiBO', 'Rimuovi questa pagina da MyUniversiBO');
				$template->assign( 'common_canaleMyUniversiBO', 'index.php?do=MyUniversiBORemove&id_canale='.$canale->getIdCanale());
			}
			else
			{
				$template->assign( 'common_canaleMyUniversiBO', 'add');
				$template->assign( 'common_langCanaleMyUniversiBO', 'Aggiungi questa pagina a MyUniversiBO');
				$template->assign( 'common_canaleMyUniversiBO', 'index.php?do=MyUniversiBOAdd&id_canale='.$canale->getIdCanale());
			}
		}
		else
		$template->assign( 'common_langCanaleMyUniversiBO', '');
		
		$template->assign( 'common_isSetVisite', 'true' );
		$template->assign( 'common_visite', $canale->getVisite() );
		$template->assign( 'common_langCanaleNome', $canale->getNome());
		$template->assign( 'common_canaleURI', $canale->showMe());
		
	}


	/**
	 * Imposta l'ultimo accesso dell'utente al canale
	 *
	 * @return boolean true se avvenuta con successo
	 */
	function updateUltimoAccesso()
	{
		$id_canale = $this->getRequestIdCanale();
		$user =& $this->getSessionUser();
		$user_ruoli =& $user->getRuoli();
		
		if (array_key_exists($id_canale, $user_ruoli))
		{
			$user_ruoli[$id_canale]->updateUltimoAccesso(time(), true);
		}
	}


	/**
	 * Chiude il CanaleCommand ridefinisce lo shutdownCommand() dell'UniversiboCommand.
	 */
	function shutdownCommand()
	{
		
		
		if (!$this->isPopup())
		{		
			$template =& $this->frontController->getTemplateEngine();
			$canale =& $this->getRequestCanale();
			$user =& $this->getSessionUser();
			
			//informazioni del menu contatti
			$attivaContatti = $user->isAdmin();
			
			$attivaModificaDiritti = $user->isAdmin();
			
			$arrayPublicUsers = array();
			$arrayRuoli =& $canale->getRuoli();
			//var_dump($arrayRuoli);
			$keys = array_keys($arrayRuoli);
			foreach ($keys as $key)
			{
				$ruolo =& $arrayRuoli[$key];
				//var_dump($ruolo);
				if ($ruolo->isReferente() || $ruolo->isModeratore())
				{
					$attivaContatti = true;
					
					if ($ruolo->isReferente() && $ruolo->getIdUser() == $user->getIdUser())
						$attivaModificaDiritti = true;
					
					$user =& User::selectUser($ruolo->getIdUser());
					//var_dump($user);
					$contactUser = array();
					$contactUser['utente_link']  = 'index.php?do=ShowUser&id_utente='.$user->getIdUser();
					$contactUser['nome']  = $user->getUserPublicGroupName();
					$contactUser['label'] = $user->getUsername();
					$contactUser['ruolo'] = ($ruolo->isReferente()) ? 'R' :  (($ruolo->isModeratore()) ? 'M' : 'none');
					//var_dump($ruolo);
					//$arrayUsers[] = $contactUser;
					$arrayPublicUsers[$user->getUserPublicGroupName(false)][] = $contactUser;
				}
			}
			//ordina $arrayCanali
			//usort($arrayUsers, array('CanaleCommand','_compareMyUniversiBO'));
			
			//assegna al template
			if ($attivaContatti)
			{
				
				uksort($arrayPublicUsers, "strcmp");
				
				$template->assign('common_contactsCanaleAvailable', 'true');
				$template->assign('common_langContactsCanale', 'Contatti');
				//$template->assign('common_contactsCanale', $arrayUsers);
				$template->assign('common_contactsCanale', $arrayPublicUsers);
				$template->assign('common_contactsEdit', array('label' => 'Modifica diritti', 'uri' => 'index.php?do=RuoliAdminSearch&id_canale='.$canale->getIdCanale() ) ) ;
				$template->assign('common_contactsEditAvailable', ($attivaModificaDiritti) ? 'true' : 'false');
			}
			
			
			//$template->assign('common_contactsCanaleAvailable', 'false');
			
			
		}
		
		$this->updateUltimoAccesso();
		
		parent::shutdownCommand();
	}
	
}

?>