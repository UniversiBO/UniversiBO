<?php
/**
 * UniversiboCommand is the abstract super class of all command classes
 * used in the universibo application.
 *
 * Adds user authorization and double view (popup/index)
 *
 * @package universibo
 * @version 2.0.0
 * @author  Ilias Bartolini
 * @license http://www.opensource.org/licenses/gpl-license.php
 */

class UniversiboCommand extends BaseCommand {
	
	var $sessionUser;

	function initCommand( &$frontController )
	{
		parent::initCommand( $frontController );
		
		$this->_setUpUser();
		
		$this->_setUpView();
		
		
	}
	
	function _setUpUser()
	{
		
		require_once('User.php');
		
		if (! array_key_exists('id_user',$_SESSION) || ! isset($_SESSION['id_user']) )
		{
		 	$_SESSION['id_user'] = 0;
		}

		
				
	}

	function _setUpView()
	{
		
		$template =& $this->frontController->getTemplateEngine();
        //var_dump($template);

		if ( array_key_exists('pageType', $_GET) && $_GET['pageType']=='popup' )
		{ 
			$template->assign('common_pageType', 'popup');
		}
		else
		{
			$template->assign('common_pageType', 'index');
		}

		$template->assign('common_templateBaseDir',$tpInfo['web_dir'].$tpInfo['styles'][$tpInfo['template_name']]);

		//da config.xml
		$template->assign('common_rootUrl', 'https://universibo.ing.unibo.it/');
		$template->assign('common_rootEmail', 'universibo@joker.ing.unibo.it');
		$template->assign('common_staffEmail', 'staff_universibo@calvin.ing.unibo.it');
		$template->assign('common_alert', 'Il sito è momentaneamente accessibile in sola lettura per attività di manutenzione');


		$template->assign('common_universibo', 'UniversiBO');
		$template->assign('common_metaKeywords', 'universibo, università, facoltà, studenti, bologna, professori, lezioni, materiale didattico, didattica, corsi, studio, studi, novità, appunti, dispense, lucidi, esercizi, esami, temi d\'esame, orari lezione, ingegneria, economia, ateneo');
		$template->assign('common_metaDescription', 'Il portale dedicato agli studenti universitari di Bologna');
		$template->assign('common_title', 'UniversiBO ....il portale dedicato agli studenti universitari di Bologna');
		
		
		//kronos
		$template->assign('common_veryLongDate', 'Sabato 23 Agosto 2003');
		$template->assign('common_longDate', '23 Agosto 2003');
		$template->assign('common_shortDate', '23/07/2003');
		$template->assign('common_time', '15:53');
	
				
	}


}
?>