<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('ForumApi'.PHP_EXTENSION);


/**
 * Login is an extension of UniversiboCommand class.
 *
 * Manages Users Login/Logout actions
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class Login extends UniversiboCommand {
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
		
		$referer = (array_key_exists('f1_referer',$_POST)) ? $_POST['f1_referer'] : $_SERVER['HTTP_REFERER'];
		
		if ( array_key_exists('f1_submit',$_POST) )
		{
			
			if (!$this->sessionUser->isOspite())
			{
				Error::throwError(_ERROR_DEFAULT,array('msg'=>'Il login pu? essere eseguito solo da utenti che non hanno ancora eseguito l\'accesso','file'=>__FILE__,'line'=>__LINE__));
			}
			
			if (! User::isUsernameValid($_POST['f1_username']) )
				Error::throwError(_ERROR_NOTICE,array('msg'=>'Username non valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			
	//		if (! User::isPasswordValid($_POST['f1_password']) )
	//			Error::throwError(_ERROR_DEFAULT,array('msg'=>'Password non valida, lunghezza minima 5 caratteri','file'=>__FILE__,'line'=>__LINE__));
			
			$user = User::selectUserUsername($_POST['f1_username']);
			
			if ($user === false)
			{
				Error::throwError(_ERROR_NOTICE,array('msg'=>'Non esistono utenti con lo username inserito','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			}
			elseif( $user->getPasswordHash() != User::passwordHashFunction($_POST['f1_password']) )
			{
				Error::throwError(_ERROR_NOTICE,array('msg'=>'Password errata','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			}
			else
			{
				$_POST['f1_password'] = '';  //resettata per sicurezza
				$this->setSessionIdUtente($user->getIdUser());
				$fc->setStyle($user->getDefaultStyle());
				
				$forum = new ForumApi;
				$forum->login($user);
				
				if ( !strstr('do',$referer) || strstr('do=ShowHome', $referer) )
					FrontController::redirectCommand('ShowMyUniversiBO');
				else
					FrontController::goTo($referer);
				
				
			}
			$_POST['f1_password'] = '';  //resettata per sicurezza
		
		}
		
		$f1_username = (array_key_exists('f1_username', $_POST)) ? '' : $_POST['f1_username'] = '';
		$f1_password = '';
		
		$template->assign('login_langLogin','Login');
		$template->assign('f1_referer_value',$referer);
		$template->assign('f1_username_value',$_POST['f1_username']);
		$template->assign('f1_password_value','');

		return ;

	}
}

?>