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
 
class RegStudente extends UniversiboCommand {
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
		
		if (!$this->sessionUser->isOspite())
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'iscrizione può essere richiesta solo da utenti che non hanno ancora eseguito l\'accesso','file'=>__FILE__,'line'=>__LINE__));
		}

		if ( array_key_exists('f4_submit',$_POST) )
		{
			
/*			if (! User::isUsernameValid($_POST['f1_username']) )
				Error::throw(_ERROR_NOTICE,array('msg'=>'Username non valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			
			
			$user = User::selectUserUsername($_POST['f1_username']);
			
			if ($user === false)
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Non esistono utenti con lo username inserito','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			}
			elseif( $user->getPasswordHash() != md5($_POST['f1_password']) )
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Password errata','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
			}
			else
			{
				$_POST['f1_password'] = '';  //resettata per sicurezza
				$this->setSessionIdUtente($user->getIdUser());
				
				$forum = new ForumApi;
				$forum->login($user);
				
				FrontController::redirectCommand('ShowHome');
			}
			$_POST['f1_password'] = '';  //resettata per sicurezza
*/			
		}
		
		$f1_username = (array_key_exists('f1_username', $_POST)) ? '' : $_POST['f1_username'] = '';
		$f1_password = '';
		
		$template->assign('regStudente_langRegAlt','Registrazione');
		$template->assign('regStudente_langMail','e-mail di ateneo:');
		$template->assign('regStudente_langPassword','Password:');
		$template->assign('regStudente_langUsername','Username:');
		$template->assign('regStudente_domain','@studio.unibo.it');
		$template->assign('regStudente_langInfoUsername','E\' necessario scegliere uno Username che sarà utilizzato per i futuri accessi e che sarà anche il vostro nome identificativo all\'interno di UniversiBO.
Il sistema genererà una password casuale che sarà inviata alla vostra casella e-mail d\'ateneo.');
		$template->assign('regStudente_langInfoReg','Per garantire la massima sicurezza, l\'identificazione degli studenti al loro primo accesso avviene tramite la casella e-mail d\'ateneo e la relativa password.
Se non possedete ancora la e-mail di ateneo andate sul sito [url]http://www.unibo.it[/url] cliccate sul "Login" in alto a destra e seguite le istruzioni.
Per problemi indipendenti da noi [b]la casella e-mail verrà creata nelle 24 ore successive[/b] dopo le quali potrete venire ad iscrivervi.');
		$template->assign('regStudente_langReg','Regolamento per l\'utilizzo dei servizi:');
		$template->assign('regStudente_langPrivacy','Informativa sulla privacy:');
		$template->assign('regStudente_langConfirm','Confermo di aver letto il regolamento');

		
		// valori default form
		$f4_username =	'';
		$f4_password =	'';
		$f4_ad_user =	'';
		
		$f4_accept = false;
		
		if ( array_key_exists('f4_submit', $_POST)  )
		{
			//var_dump($_POST);
			if ( !array_key_exists('f4_privacy', $_POST) ||
				 !array_key_exists('f4_regolamento', $_POST) ||
				 !array_key_exists('f4_username', $_POST) ||
				 !array_key_exists('f4_password', $_POST) ||
				 !array_key_exists('f4_ad_user', $_POST) ) 
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il form inviato non è valido','file'=>__FILE__,'line'=>__LINE__ ));
				$f4_accept = false;
			}
			
			//ad_user
			if ( $_POST['f4_ad_user'] == '' ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Inserire la e-mail di ateneo','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif ( strlen($_POST['f4_ad_user']) > 30 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Lo username di ateneo indicato può essere massimo 30 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif(ereg('@studio\.unibo\.it$',$_POST['f4_ad_user'])){
				Error::throw(_ERROR_NOTICE,array('msg'=>'Non inserire il suffisso "@studio.unibo.it" nella email di ateneo','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif(!eregi('^([[:alnum:]])+\.[[[:alnum:]]+$',$_POST['f4_ad_user'])){
				Error::throw(_ERROR_NOTICE,array('msg'=>'La mail di ateneo inserita '.$_POST['f4_ad_user'].' non è sintatticamente valida','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif(User::activeDirectoryUsernameExists($_POST['f4_ad_user'].'@studio.unibo.it')){
				Error::throw(_ERROR_NOTICE,array('msg'=>'La mail di ateneo '.$_POST['f4_ad_user'].'@studio.unibo.it'.' appartiene ad un utente già registrato','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			else{
				$f4_ad_user = $_POST['f4_ad_user'];
				$q4_ad_user = $f4_ad_user.'@studio.unibo.it';
			
			//password
			if ( $_POST['f4_password'] == '' ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Inserire la password della e-mail di ateneo','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif ( strlen($_POST['f4_password']) > 50 ){
				Error::throw(_ERROR_NOTICE,array('msg'=>'La lunghezza massima della password accettata dal sistema è di massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			else $q4_password = $f4_password = $_POST['f4_password'];
			
			//username
			if ( $_POST['f4_username'] == '' ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Scegliere uno username','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif ( !User::isUsernameValid( $_POST['f4_username'] ) ){
				Error::throw(_ERROR_NOTICE,array('msg'=>'Nello username sono permessi fino a 25 caratteri alfanumerici con lettere accentate, spazi, punti, underscore','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			elseif ( User::usernameExists( $_POST['f4_username'] ) ){
				Error::throw(_ERROR_NOTICE,array('msg'=>'Lo username richiesto è già stato registrato da un altro utente','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			else $q4_username = $f4_username = $_POST['f4_username'];
			
			//confirm
			if ( !array_key_exists('f4_confirm', $_POST)) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'E\' neccessario confermare il regolamento per potersi iscrivere','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f4_accept = false;
			}
			
		}

		// riassegna valori form
		$template->assign('f4_regolamento',	file_get_contents($fc->getAppSetting('regolamento')));
		$template->assign('f4_privacy',		file_get_contents($fc->getAppSetting('informativaPrivacy')));
		$template->assign('f4_username',	$f4_username);
		$template->assign('f4_password',	'');
		$template->assign('f4_ad_user',		$f4_ad_user);
		$template->assign('f4_submit',		'Registra');

		if ( $f4_accept == true )
		{
			require_once('ForumApi');
			
			//controllo active directory
			$adl_host = $fc->getAppSetting('adLoginHost');
			$adl_port = $fc->getAppSetting('adLoginPort'); 
			if (! User::activeDirectoryLogin($q4_ad_user, 'studio.unibo.it', $q4_password, $adl_host, $adl_port ) )
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'L\'autenticazione tramite e-mail di ateneo ha fornito risultato negativo','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				return 'default';
			}
			
			$randomPassword = User::generateRandomPassword();
			
			$new_user = new User(-1, USER_STUDENTE, $q4_username ,md5($randomPassword), $q4_ad_user, 0, $q4_ad_user );
			
			if ($new_user->insertUser() == false)
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Si è verificato un errore durente la registrazione dell\'account username '.$q4_username.' mail '.$q4_ad_user,'file'=>__FILE__,'line'=>__LINE__));

			$forum = new ForumApi();
			$forum->insert($new_user);
			//	Error::throw(_ERROR_DEFAULT,'msg'=>'Si è verificato un errore durente la registrazione dell\'account username '.$q4_username.' mail '.$q4_ad_user,'file'=>__FILE__,'line'=>__LINE__));
			
			$mail =& $frontcontroller->getMail();

			$mail->AddAddress($new_user->getEmail());

			$mail->Subject = "Registrazione UniversiBO";
			$mail->Body = "Benvenuto \"".$new_user->getUsername()."\"!!\nFai ora parte di UniversiBO, la community degli studenti dell'universita' di Bologna!\n\n".
			     "Per accedere al sito utilizza l'indirizzo https://www.universibo.unibo.it\n\n".
				 "Le informazioni per permetterti l'accesso ai servizi offerti dal portale sono:\n".
				 "Username: ".$new_user->getUsername()."\n".
				 "Password: ".$randomPassword."\n\n".
				 "Questa password e' stata generata in modo casuale: sul sito  e' disponibile nella pagina delle tue impostazioni personali la funzionalita' per poterla cambiare a tuo piacimento\n\n".
		 		 "Dopo aver fatto il login puoi, modificare il tuo profilo personale per l'inoltro delle News dei tuoi esami preferiti in e-mail\n".
		 		 "Se desideri collaborare al progetto UniversiBO compila il questionario all'indirizzo https://www.universibo.unibo.it/index.php?do=ShowContribute \n\n".
				 "Qualora avessi ricevuto questa e-mail per errore, segnalalo rispondendo a questo messaggio";
			
			$msg = "L'iscrizione è stata registrata con successo ma non è stato possibile inviarti la password tramite e-mail\n".
				 "Le informazioni per permetterti l'accesso ai servizi offerti da UniversiBO sono:\n".
				 "Username: ".$new_user->getUsername()."\n".
				 "Password: ".$randomPassword."\n\n";
			
			//if(!$mail->Send()) Error::throw(_ERROR_DEFAULT,array('msg'=>$msg, 'file'=>__FILE__, 'line'=>__LINE__));
			
			$template->assign('question_thanks',"Grazie per aver compilato il questionario, la tua richiesta è stata inoltrata ai ragazzi che si occupano del contatto dei nuovi collaboratori.\n Verrai ricontattatato da loro non appena possibile");
			
			//elimino la password
			$randomPassword = '';
			$mail->Body = '';
			$msg = '';
			
			return 'reg_success';
			
		}
		
		return 'default';
		
	}
}

?>