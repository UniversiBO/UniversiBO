<?php

include ('UniversiboCommand'.PHP_EXTENSION);

/**
 * Login is an extension of UniversiboCommand class.
 *
 * Manages Users Login/Logout actions
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class Login extends UniversiboCommand {
	function execute()
	{
	
		if ( array_key_exists('action',$_GET) &&  $_GET['action'] =='login' )
		{
			if (!$this->sessionUser->isOspite())
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il login può essere eseguito solo da utenti che non hanno ancora eseguito l\'accesso','file'=>__FILE__,'line'=>__LINE__));
			}
		}
		
		if (! User::isUsernameValid($_POST['f1_username']) )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Username non valido','file'=>__FILE__,'line'=>__LINE__));
		
//		if (! User::isPasswordValid($_POST['f1_password']) )
//			Error::throw(_ERROR_DEFAULT,array('msg'=>'Password non valida, lunghezza minima 5 caratteri','file'=>__FILE__,'line'=>__LINE__));
		
		$user = User::selectUserUsername($_POST['f1_username']);
		
		if ($user === false)
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Username non valido','file'=>__FILE__,'line'=>__LINE__));
		}
		elseif( $user->getPasswordHash() == md5($_POST['f1_password']) )
		{
			$this->setSessionIdUtente($user->getIdUser());
			$fc =& $this->getFrontController();
			$fc->redirectCommand('ShowHome');
		}		
		else
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Password errata','file'=>__FILE__,'line'=>__LINE__));
		}
		
		$template =& $this->frontController->getTemplateEngine();
		$template->assign('login_langLogin','Login');
		
		return;

	}
}

?>