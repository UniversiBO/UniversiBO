<?php

require_once('UniversiboCommand'.PHP_EXTENSION);
require_once('Canale'.PHP_EXTENSION);


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

class CanaleCommand extends UniversiboCommand {
	
	var $requestCanale;

	
	/**
	 * Restituisce l'id_canale corrente, se non è specificato nella richiesta si considera 
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
	 * Restituisce l'oggetto canale della richiesta corrente
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
	 *
	 * @private  
	 */
	function _setUpCanaleCanale()
	{

		$this->requestCanale =& Canale::selectCanale( $this->getRequestIdCanale() );
			  
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

}

?>

	