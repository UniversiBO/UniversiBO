<?php

require_once('UniversiboCommand'.PHP_EXTENSION);
require_once('Canale'.PHP_EXTENSION);


/**
 * CanaleCommand è la superclasse astratta di tutti i command che utilizzando un oggetto Canale
 *
 * Un Canale è una pagina dinamica con a disposizione il collegamento 
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
	 * Restituisce l'id_canale corrente, se non è specificato nella richiesta HTTP-GET si considera 
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
			else Error::throw(_ERROR_DEFAULT,array('msg'=>'il parametro id_canale non è specificato nella richiesta','file'=>__FILE__,'line'=>__LINE__));
		}

		if (!ereg('^([0-9]+)$', $_GET['id_canale'] ) )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'il parametro id_canale è sintatticamente non valido','file'=>__FILE__,'line'=>__LINE__));

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

		$tipo_canale =  Canale::getTipoCanaleFromId ( $this->getRequestIdCanale() );
		if ($tipo_canale === false )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il canale richiesto non è presente','file'=>__FILE__,'line'=>__LINE__));
		
		$dispatch_array = array (	CANALE_DEFAULT      => 'Canale',
									CANALE_HOME         => 'Canale',
									CANALE_FACOLTA      => 'Facolta',
									CANALE_CDL          => 'Cdl',
									CANALE_INSEGNAMENTO => 'Insegnamento');

		$class_name = $dispatch_array[$tipo_canale];
		require_once($class_name.PHP_EXTENSION);
		
		$this->requestCanale =& call_user_func(array($class_name,'factoryCanale'), $this->getRequestIdCanale());

		//$this->requestCanale =& $class_name::factoryCanale( $this->getRequestIdCanale() );
			  
		if ( $this->requestCanale === false ) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il canale richiesto non è presente','file'=>__FILE__,'line'=>__LINE__));
		
		$canale = $this->getRequestCanale();
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
		$user =& $this->getSessionUser();
		
		if ( ! $canale->isGroupAllowed( $user->getGroups() ) )
			Error::throw(_ERROR_DEFAULT, array('msg'=>'Non ti è permesso l\'accesso al canale selezionato, la sessione potrebbe essere scaduta','file'=>__FILE__,'line'=>__LINE__ ) );
		
		$template->assign( 'common_isSetVisite', 'S' );
		$template->assign( 'common_visite', $canale->getVisite() );
			
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
	
}

?>