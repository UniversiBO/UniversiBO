<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/ShowNewsLatest'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);
require_once  ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowMyPage is an extension of UniversiboCommand class.
 *
 * Mostra la MyPage dell'utente loggato, con le ultime 5 notizie e 
 * gli ultimi 5 files presenti nei canali da lui aggiunti...
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles 
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowMyUniversiBO extends UniversiboCommand 
{
	function execute()
	{
		
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$utente =& $this->getSessionUser();
		
		
		if($utente->isOspite())
			Error::throw(_ERROR_DEFAULT, array('msg' => 'Non è permesso ad utenti non registrati eseguire questa operazione. La sessione potrebbe essere scaduta', 'file' => __FILE__, 'line' => __LINE__));

		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
		{
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		}
		$id_canale = $_GET['id_canale']
		$canale = & Canale::retrieveCanale($id_canale);

		$ruoli =& $utente->getRuoli();
		
		if(!array_key_exists($id_canale, $ruoli))
		{
			//sistemare ...decidere
			$nome = ''
			$notifica = 'T'
			$nascosto = false;
			$ruolo = new Ruolo($utente->getIdUser(), $id_canale, , time(), false, false, true, , false);
		}
		else
		{
			$ruolo =& $ruoli[$id_canale];
			$ruolo->
		}
		
	}
	
	
}

?>