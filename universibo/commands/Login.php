<?php

include ('UniversiboCommand'.PHP_EXTENSION);

/**
 * Login is an extension of UniversiboCommand class.
 *
 * Manages Users Login/Logout actions
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class Login extends UniversiboCommand {
	function execute()
	{
		$fc =& $this->getFrontController();
		//$fc->redirectCommand('ShowHome');
		
		if ( array_key_exists('f1_submit',$_POST) )
		{
		
			if (!$this->sessionUser->isOspite())
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il login pu� essere eseguito solo da utenti che non hanno ancora eseguito l\'accesso','file'=>__FILE__,'line'=>__LINE__));
			}
			
			if (! User::isUsernameValid($_POST['f1_username']) )
				Error::throw(_ERROR_NOTICE,array('msg'=>'Username non valido','file'=>__FILE__,'line'=>__LINE__));
			
	//		if (! User::isPasswordValid($_POST['f1_password']) )
	//			Error::throw(_ERROR_DEFAULT,array('msg'=>'Password non valida, lunghezza minima 5 caratteri','file'=>__FILE__,'line'=>__LINE__));
			
			$user = User::selectUserUsername($_POST['f1_username']);
			
			if ($user === false)
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Username inesistente','file'=>__FILE__,'line'=>__LINE__));
			}
			elseif( $user->getPasswordHash() != md5($_POST['f1_password']) )
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Password errata','file'=>__FILE__,'line'=>__LINE__));
			}
			else
			{
				$_POST['f1_password'] = '';  //resettata per sicurezza
				$this->setSessionIdUtente($user->getIdUser());
				
				//Forum::login($user);
				
				$fc->redirectCommand('ShowHome');
			}
			$_POST['f1_password'] = '';  //resettata per sicurezza
		
		}
		
		$f1_username = (array_key_exists('f1_username', $_POST)) ? '' : $_POST['f1_username'] = '';
		$f1_password = '';
		
		$template =& $this->frontController->getTemplateEngine();
		$template->assign('login_langLogin','Login');
		$template->assign('f1_username_value',$_POST['f1_username']);
		$template->assign('f1_password_value','');

		return ;

	}
}

?>