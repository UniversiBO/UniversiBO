<?php
require_once ('PluginCommand'.PHP_EXTENSION);
require_once ('News/ShowNewsLatest'.PHP_EXTENSION);
require_once  ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowSettings is an extension of UniversiboCommand class.
 *
 * Mostra i link agli strumenti per la modifica delle impostazioni personali
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles 
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowSettings extends UniversiboCommand 
{
	function execute(){

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$utente =& $this->getSessionUser();
		

		if ($utente->isAdmin())
		{
			$template->assign('showSettings_showAdminPanel','true');
		}
		else
		{
			$template->assign('showSettings_showAdminPanel','false');
		}
		
		if ($utente->isCollaboratore())
		{
			$template->assign('showSettings_langPreferences',array('[url=index.php?do=ChangePassword]Modifica password[/url]', '[url=]Informazioni personali[/url]', '[url=]Impostazioni personali[/url]','[url=]Modifica preferiti[/url]','[url=https://posta.studio.unibo.it/horde/?username]Posta di ateneo[/url]','[url=]Docenti da contattare[/url]'));
		}
		else
		{
			$template->assign('showSettings_langPreferences',array('[url=index.php?do=ChangePassword]Modifica password[/url]', '[url=]Informazioni personali[/url]', '[url=]Impostazioni personali[/url]','[url=]Modifica preferiti[/url]','[url=https://posta.studio.unibo.it/horde/?username]Posta di ateneo[/url]'));
		}

		$template->assign('showSettings_langTitleAlt','MyPage');
		$template->assign('showSettings_langIntro','Ora ti trovi nella tua pagina personale.
Tramite questa pagina potrai modificare il tuo profilo, le tue impostazioni personali ed avere un accesso veloce e personalizzato alle informazioni scegliendo i contenuti e il loro formato tramite le tue [b]Preferences[/b].');
		
		$template->assign('showSettings_langAdmin',array('[url=https://www.universibo.unibo.it/phppgadmin242/]DB Postgresql locale[/url]', '[url=https://www.universibo.unibo.it/phporacleadmin/]DB Oracle ateneo[/url]', '[url=https://universibo.ing.unibo.it/phpMyAdmin]DB MySql facoltà[/url]', '[url=index.php?do=RegistraStudente]Iscrivi nuovo utente[/url]'));
		
				
		return 'default';						
	}
		
}

?>