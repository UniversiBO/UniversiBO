<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('ForumApi'.PHP_EXTENSION);


/**
 * RegStudente is an extension of UniversiboCommand class.
 *
 * Si occupa della registrazione degli studenti
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class RegUser extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
		
		$session_user =& $this->getSessionUser();
		if (!$session_user->isAdmin())
		{
			Error::throwError(_ERROR_DEFAULT,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'L\'iscrizione manuale di nuovi utenti pu? essere effettuata solo da utenti Admin','file'=>__FILE__,'line'=>__LINE__));
		}
		
		$template->assign('f34_submit',		'Registra');
		$template->assign('regStudente_langRegAlt','Registrazione');
/*		$template->assign('regStudente_langMail','e-mail di ateneo:');
		$template->assign('regStudente_langPassword','Password:');
		$template->assign('regStudente_langUsername','Username:');
		$template->assign('regStudente_domain','@studio.unibo.it');
		$template->assign('regStudente_langInfoUsername','E\' necessario scegliere uno Username che sar? utilizzato per i futuri accessi e che sar? anche il vostro nome identificativo all\'interno di UniversiBO.
Il sistema generer? una password casuale che sar? inviata alla vostra casella e-mail d\'ateneo.');
		$template->assign('regStudente_langInfoReg','Per garantire la massima sicurezza, l\'identificazione degli studenti al loro primo accesso avviene tramite la casella e-mail d\'ateneo e la relativa password.
Se non possedete ancora la e-mail di ateneo andate sul sito [url]http://www.unibo.it[/url] cliccate sul "Login" in alto a destra e seguite le istruzioni.
Per problemi indipendenti da noi [b]la casella e-mail verr? creata nelle 24 ore successive[/b] e potete accedervi tramite il sito [url]https://posta.studio.unibo.it[/url], vi preghiamo di apettare che la mail di ateneo sia attiva prima di iscrivervi.');
		$template->assign('regStudente_langReg','Regolamento per l\'utilizzo dei servizi:');
		$template->assign('regStudente_langPrivacy','Informativa sulla privacy:');
		$template->assign('regStudente_langConfirm','Confermo di aver letto il regolamento');
		$template->assign('regStudente_langHelp','Per qualsiasi problema o spiegazioni contattate lo staff all\'indirizzo [email]'.$fc->getAppSetting('infoEmail').'[/email].'."\n".
							'In ogni caso non comunicate mai le vostre password di ateneo, lo staff non ? tenuto a conoscerle');
*/

		
		// valori default form
		$f34_username =	'';
		$f34_email =	'';
		$f34_livello =	0;
		
		$f34_accept = false;
		
		if ( array_key_exists('f34_submit', $_POST)  )
		{
			$f34_accept = true;
			//var_dump($_POST);
			if ( !array_key_exists('f34_username', $_POST) ||
				 !array_key_exists('f34_email', $_POST) ||
				 !array_key_exists('f34_livello', $_POST) ) 
			{
				Error::throwError(_ERROR_DEFAULT,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Il form inviato non ? valido','file'=>__FILE__,'line'=>__LINE__ ));
				$f34_accept = false;
			}
			
			//ad_user
			if ( $_POST['f34_email'] == '' ) {
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Inserire la e-mail','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			elseif(!eregi('^([[:alnum:]])+\.[[[:alnum:]]+$',$_POST['f34_email'])){
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'La mail di ateneo inserita '.$_POST['f34_email'].' non ? sintatticamente valida','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			else
			{
				$f34_email = strtolower($_POST['f34_email']);
				$q34_email = strtolower($f34_email);
			}
			
			
			//username
			if ( $_POST['f34_username'] == '' ) {
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Scegliere uno username','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			elseif ( !User::isUsernameValid( $_POST['f34_username'] ) ){
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Nello username sono permessi fino a 25 caratteri alfanumerici con lettere accentate, spazi, punti, underscore','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			elseif ( User::usernameExists( $_POST['f34_username'] ) ){
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Lo username richiesto ? gi? stato registrato da un altro utente','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			else $q34_username = $f34_username = $_POST['f34_username'];
			
			//livello
			if ( $_POST['f34_livello'] == '' ) {
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Il livello inserito ? vuoto','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			elseif ( $_POST['f34_livello'] != USER_STUDENTE &&
					 $_POST['f34_livello'] != USER_COLLABORATORE &&
					 $_POST['f34_livello'] != USER_TUTOR &&
					 $_POST['f34_livello'] != USER_DOCENTE &&
					 $_POST['f34_livello'] != USER_ADMIN &&
					 $_POST['f34_livello'] != USER_PERSONALE ) 
			{
				Error::throwError(_ERROR_NOTICE,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Il livello inserito non ? tra quelli ammissibili','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f34_accept = false;
			}
			else $q34_livello = $f34_livello = $_POST['f34_livello'];
			
		}

		if ( $f34_accept == true )
		{
			//controllo active directory
			$randomPassword = User::generateRandomPassword();
			$notifica = ($q34_livello == USER_STUDENTE || $q34_livello == USER_COLLABORATORE || $q34_livello == USER_ADMIN || $q34_livello == USER_TUTOR ) ? NOTIFICA_ALL : NOTIFICA_NONE;
			
			$new_user = new User(-1, $q34_livello, $q34_username ,User::passwordHashFunction($randomPassword), $q34_email, $notifica, 0, '', '', $fc->getAppSetting('defaultStyle') );
			
			if ($new_user->insertUser() == false)
				Error::throwError(_ERROR_DEFAULT,array('id_utente' => $session_user->getIdUtente(), 'msg'=>'Si ? verificato un errore durente la registrazione dell\'account username '.$q34_username.' mail '.$q34_email,'file'=>__FILE__,'line'=>__LINE__));

			$forum = new ForumApi();
			$forum->insertUser($new_user);
			//	Error::throwError(_ERROR_DEFAULT,'msg'=>'Si ? verificato un errore durente la registrazione dell\'account username '.$q34_username.' mail '.$q34_email,'file'=>__FILE__,'line'=>__LINE__));
			
			$mail =& $fc->getMail();

			$mail->AddAddress($new_user->getEmail());

			$mail->Subject = "Registrazione UniversiBO";
			$mail->Body = "Benvenuto \"".$new_user->getUsername()."\"!!\nCi ? stata inoltrata una richiesta di iscrizione al sito UniversiBO\n\n".
			     "Per accedere al sito utilizza l'indirizzo ".$fc->getAppSetting('rootUrl')."\n\n".
				 "Le informazioni per permetterti l'accesso ai servizi offerti sono:\n".
				 "Username: ".$new_user->getUsername()."\n".
				 "Password: ".$randomPassword."\n\n".
				 "Questa password e' stata generata in modo casuale: sul sito  e' disponibile nella pagina delle tue impostazioni personali la funzionalita' per poterla cambiare a tuo piacimento\n\n".
				 "Qualora avessi ricevuto questa e-mail per errore, segnalalo rispondendo a questo messaggio";
			
			$msg = "L'iscrizione ? stata registrata con successo ma non ? stato possibile inviarti la password tramite e-mail\n".
				 "Le informazioni per permetterti l'accesso ai servizi offerti da UniversiBO sono:\n".
				 "Username: ".$new_user->getUsername()."\n".
				 "Password: ".$randomPassword."\n\n";
			
			if(!$mail->Send()) Error::throwError(_ERROR_DEFAULT,array('id_utente' => $session_user->getIdUtente(), 'msg'=>$msg, 'file'=>__FILE__, 'line'=>__LINE__));
			
			$template->assign('regStudente_thanks',"Benvenuto \"".$new_user->getUsername()."\"!!\n \nL'iscrizione ? stata registrata con successo.\nLe informazioni per permetterti l'accesso ai servizi offerti dal portale sono state inviate al tuo indirizzo e-mail di ateneo\n".
									'Per qualsiasi problema o spiegazioni contatta lo staff all\'indirizzo [email]'.$fc->getAppSetting('infoEmail').'[/email].');
			
			//elimino la password
			$randomPassword = '';
			$mail->Body = '';
			$msg = '';
			
			return 'success';
			
		}
		
		$array_livelli = array();
		$array_nomi = User::groupsNames();
		foreach($array_nomi as $key => $value)
		{
			if ($key != USER_OSPITE)
				$array_livelli[$key] = $value; 
		}
		// riassegna valori form
		$template->assign('f34_username',	$f34_username);
		$template->assign('f34_livelli',	$array_livelli);
		$template->assign('f34_livello',	$f34_livello);
		$template->assign('f34_email',		$f34_email);
		$template->assign('f34_submit',		'Registra');
		
		return 'default';
		
	}
	
}

?>