<?php

require_once  ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowRules is an extension of UniversiboCommand class.
 *
 * It shows rules page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowSettings extends UniversiboCommand {
	function execute(){

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		$utente =& $this->getSessionUser();


		if ($utente->isAdmin())
		{
			$template->assign('mypage_showAdminPanel','true');
		}
		else
		{
			$template->assign('mypage_showAdminPanel','false');
		}
		
		if ($utente->isModeratore())
		{
			$template->assign('mypage_langPreferences',array('[url=]Modifica password[/url]', '[url=]Informazioni personali[/url]', '[url=]Impostazioni personali[/url]','[url=]Modifica preferiti[/url]','[url=https://posta.studio.unibo.it/horde/?username]Posta di ateneo[/url]','[url=]Docenti da contattare[/url]'));
		}
		else
		{
			$template->assign('mypage_langPreferences',array('[url=]Modifica password[/url]', '[url=]Informazioni personali[/url]', '[url=]Impostazioni personali[/url]','[url=]Modifica preferiti[/url]','[url=https://posta.studio.unibo.it/horde/?username]Posta di ateneo[/url]'));
		}

		$template->assign('mypage_langTitleAlt','MyPage');
		$template->assign('mypage_langIntro','Ora ti trovi nella tua pagina personale.
Tramite questa pagina potrai modificare il tuo profilo, le tue impostazioni personali ed avere un accesso veloce e personalizzato alle informazioni scegliendo i contenuti e il loro formato tramite le tue <font class="NormalC">Preferences</font>.');
		
		$template->assign('mypage_langAdmin',array('[url=https://www.universibo.unibo.it/phppgadmin242/]DB Postgresql locale[/url]', '[url=https://www.universibo.unibo.it/phporacleadmin/]DB Oracle ateneo[/url]', '[url=https://universibo.ing.unibo.it/phpMyAdmin]DB MySql facoltà[/url]', '[url=index.php?do=RegistraStudente]Iscrivi nuovo utente[/url]'));
		return 'default';						
	}
}

?>