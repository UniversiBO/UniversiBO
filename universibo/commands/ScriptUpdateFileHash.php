<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);


/**
 * ChangePassword is an extension of UniversiboCommand class.
 *
 * Si occupa della modifica della password di un utente
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptUpdateFileHash extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
		$user =& $this->getSessionUser();
		
		if(!$user->isAdmin())
			Error::throw(_ERROR_DEFAULT,array('msg'=>'La modifica della password non può essere eseguita da utenti con livello ospite.'."\n".'La sessione potrebbe essere scaduta, eseguire il login','file'=>__FILE__,'line'=>__LINE__));
		
		
		
	}
}

?>
