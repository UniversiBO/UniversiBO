<?php

include ('UniversiboCommand'.PHP_EXTENSION);

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

		$fc =& $this->getFrontController() 
		$template =& $fc->getTemplateEngine();
		$utente =& $fc->getSessionUser();


		if ($utente->isAdmin())
		{
			$template->assign('mypage_showAdminPanel','true');
		}
		else
		{
			$template->assign('mypage_showAdminPanel','false');
		}

		$template->assign('mypage_intro','Ora ti trovi nella tua pagina personale.<br />
Tramite questa pagina potrai modificare il tuo profilo, le tue impostazioni personali ed
avere un accesso veloce e personalizzato alle informazioni scegliendo i contenuti 
e il loro formato tramite le tue 
<font class="NormalC">Preferences</font>.');
		$template->assign('mypage_preferences',array('pw'=>'Modifica password', 'info'=>'Informazioni personali', 'setting'=>'Impostazioni personali','mail'=>'Posta di ateneo'));
		$template->assign('mypage_admin',array('postgre'=>'DB Postgresql locale', 'oracle'=>'DB Oracle ateneo', 'mysql'=>'DB MySql facoltà', 'nuovi'=>'Iscrivi nuovo utente'));
		return 'default';						
	}
}

?>