<?php

require_once ('PluginCommand'.PHP_EXTENSION);
require_once  ('UniversiboCommand'.PHP_EXTENSION);

require_once  ('ForumApi'.PHP_EXTENSION);

/**
 * ShowPersonalSettings is an extension of UniversiboCommand class.
 *
 * Mostra un form con cui modificare le impostazioni personali
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles 
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowPersonalSettings extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $this->frontController->getTemplateEngine();
		$user =& $this->getSessionUser();
		
		if ($this->sessionUser->isOspite())
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'La modifica delle impostazioni personali non pu� essere eseguita da utenti con livello ospite.'."\n".'La sessione potrebbe essere scaduta, eseguire il login','file'=>__FILE__,'line'=>__LINE__));
		}
		
		$template->assign('showPersonalSettings_langEmail','Modifica Email');
		$template->assign('showPersonalSettings_langPhone','Cellulare:');
		$template->assign('showPersonalSettings_langNotifyLevel','Livelli di notifica:');
		$template->assign('showPersonalSettings_langStyle','Stile preferito:');
		$template->assign('showPersonalSettings_langInfoChangeSettings','In questa pagina potete modificare l\'email e il numero di cellulare dove volete ricevere le notifiche, di cui potete specificare il livello'."\n".'Inoltre, potrete scegliere lo stile che preferite.');
		$template->assign('showPersonalSettings_langHelp','Per qualsiasi problema o spiegazioni contattate lo staff all\'indirizzo [email]'.$fc->getAppSetting('infoEmail').'[/email].'."\n".
							'In ogni caso non comunicate mai le vostre password di ateneo, lo staff non � tenuto a conoscerle');

		// valori default form
		$f20_email 			=	$user->getEmail();
		$f20_cellulare 		=	$user->getPhone();
		$f20_livelli_notifica = Ruolo::getLivelliNotifica();
		$f20_livello_notifica = $user->getLivelloNotifica();
		$f20_personal_style	= $user->getDefaultStyle();
		if($f20_personal_style == "black")
			{
			$f20_stili = array("black","unibo");
			}
			else{$f20_stili = array("unibo","black");}
						
		$f20_accept = false;
		$flag_tel = true;
		
		if ( array_key_exists('f20_submit', $_POST)  )
		{
			$f20_accept = true;
			
			//var_dump($_POST);
			if ( !array_key_exists('f20_email', $_POST) ||
				 !array_key_exists('f20_cellulare', $_POST)||
				 !array_key_exists('f20_livello_notifica', $_POST)) 
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il form inviato non � valido','file'=>__FILE__,'line'=>__LINE__ ));
				$f20_accept = false;
			}
			
			//telefono
			if ( (strlen($_POST['f20_cellulare']) > 50)||!ereg('^([0-9]{0,50})$', $_POST['f20_cellulare'])) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il numero di cellulare indicato pu� essere massimo 50 cifre','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f20_accept = false;
			}
			else $q20_cellulare = $f20_cellulare = $_POST['f20_cellulare'];
			
			//mail
			if ( strlen($_POST['f20_email']) > 50 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'L\' indirizzo e-mail indicato pu� essere massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f20_accept = false;
			}
			elseif ( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['f20_email']) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Inserire un indirizzo e-mail valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f20_accept = false;
			}
			else $q20_email = $f20_email = $_POST['f20_email'];	
			
			//livello notifiche
			if(!array_key_exists($_POST['f20_livello_notifica'], $f20_livelli_notifica) )
				{
					Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Il livello di notifica scelto non � valido', 'file' => __FILE__, 'line' => __LINE__));
					$f20_accept = false;
				}
				else
					$f20_livello_notifica = $_POST['f20_livello_notifica'];	
			//style
			if(!array_key_exists($_POST['f20_personal_style'], $f20_stili) )
				{
					Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Lo stile scelto non � valido', 'file' => __FILE__, 'line' => __LINE__));
					$f20_accept = false;
				}
				else
					$f20_personal_style = $f20_stili[$_POST['f20_personal_style']];		
		}

		if ( $f20_accept == true )
		{
			$user->updateEmail($q20_email);
			$user->setPhone($q20_cellulare);
			$user->setDefaultStyle($f20_personal_style);
			$user->setLivelloNotifica($f20_livello_notifica);
			$user->updateUser();

			$forum = new ForumApi();
			$forum->updateUserStyle($user);
			
			$fc->setStyle($f20_personal_style);
			$template->assign('showPersonalSettings_thanks',"Le impostazioni personali sono state modificate con successo, si consiglia di testarne il corretto funzionamento.\n".
								'Per qualsiasi problema o spiegazioni contatta lo staff all\'indirizzo [email]'.$fc->getAppSetting('infoEmail').'[/email].');
			
			return 'success';
			
		}
		
		// riassegna valori form
		$template->assign('f20_email',	$f20_email);
		$template->assign('f20_cellulare',	$f20_cellulare);
		$template->assign('f20_livello_notifica',	$f20_livello_notifica);
		$template->assign('f20_livelli_notifica',	$f20_livelli_notifica);
		$template->assign('f20_personal_style',	$f20_personal_style);
		$template->assign('f20_stili',	$f20_stili);
		$template->assign('f20_submit',		'Invia');

		return 'default';
		
	}
}

?>