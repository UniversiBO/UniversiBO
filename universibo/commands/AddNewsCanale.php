<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * AddNewsCanale: aggiunge una notizia, mostra il form e gestisce l'inserimento 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class AddNewsCanale extends CanaleCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		

		// valori default form
		$f7_titolo =	'';
		$f7_data_ins_gg =	'';
		$f7_data_ins_mm =	'';
		$f7_data_ins_aa =	'';
		$f7_data_ins_ora =	'';
		$f7_data_ins_min =	'';
		$f7_data_scad_gg =	'';
		$f7_data_scad_mm =	'';
		$f7_data_scad_aa =	'';	
		$f7_data_scad_ora =	'';
		$f7_data_scad_min =	'';
		$f7_testo		= false;
		$f7_urgente		= false;
		$f7_scadenza	= false;
		$f7_canale[]	= array();
		
		$f7_accept = false;
		
		if (array_key_exists('f7_submit', $_POST)  )
		{
			//var_dump($_POST);
			$f7_accept = true;

			if ( !array_key_exists('f7_nome', $_POST) ||
				 !array_key_exists('f7_cognome', $_POST) ||
				 !array_key_exists('f7_mail', $_POST) ||
				 !array_key_exists('f7_tel', $_POST) ||
				 !array_key_exists('f7_altro', $_POST) ) 
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il form inviato non è valido','file'=>__FILE__,'line'=>__LINE__ ));
				$f7_accept = false;
			}	

			//nome	
			if ( strlen($_POST['f7_nome']) > 50 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il nome indicato può essere massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}	
			else $q3_nome = $f7_nome = $_POST['f7_nome'];

			//cognome
			if ( strlen($_POST['f7_cognome']) > 50 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il cognome indicato può essere massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $q3_cognome = $f7_cognome = $_POST['f7_cognome'];
			
			//telefono
			if ( strlen($_POST['f7_tel']) > 50 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il numero di cellulare indicato può essere massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $q3_tel = $f7_tel = $_POST['f7_tel'];
			
			//mail
			if ( strlen($_POST['f7_mail']) > 50 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'L\' indirizzo e-mail indicato può essere massimo 50 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif ( !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $_POST['f7_mail']) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Inserire un indirizzo e-mail valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $q3_mail = $f7_mail = $_POST['f7_mail'];
			
			//altro
			$q3_altro = $f7_altro = $_POST['f7_altro'];
			
			//tempo
			if ( !array_key_exists('f7_tempo', $_POST) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Indica quanto tempo utilizzi una connessione internet','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $q3_tempo = $f7_tempo = $_POST['f7_tempo'];
			
			//internet
			if ( !array_key_exists('f7_internet', $_POST) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Indica quanto tempo libero potresti dedicare al progetto','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $q3_internet = $f7_internet = $_POST['f7_internet'];
			
			//privacy
			if ( !array_key_exists('f7_privacy', $_POST) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'E\' necessario acconsentire al trattamento dei dati personali','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			
			//attività offline check
			if ( array_key_exists('f7_offline', $_POST) ) {
				$q3_offline = 'S';
				$f7_offline = true;
			}
			else $q3_offline = 'N';
			
			//moderatore check
			if ( array_key_exists('f7_moderatore', $_POST) ) {
				$q3_moderatore = 'S';
				$f7_moderatore = true;
			}
			else $q3_moderatore = 'N';
			
			//stesura contenuti check
			if ( array_key_exists('f7_contenuti', $_POST) ) {
				$q3_contenuti = 'S';
				$f7_contenuti = true;
			}
			else $q3_contenuti = 'N';
			
			//test check
			if ( array_key_exists('f7_test', $_POST) ) {
				$q3_test = 'S';
				$f7_test = true;
			}
			else $q3_test = 'N';
			
			//grafica check
			if ( array_key_exists('f7_grafica', $_POST) ) {
				$q3_grafica = 'S';
				$f7_grafica = true;
			}
			else $q3_grafica = 'N';
			
			//progettazione check
			if ( array_key_exists('f7_prog', $_POST) ) {
				$q3_prog = 'S';
				$f7_prog = true;
			}
			else $q3_prog = 'N';
			
		}
		
		
		// riassegna valori form
		$template->assign('f7_nome',	$f7_nome);
		$template->assign('f7_cognome',	$f7_cognome);
		$template->assign('f7_mail',	$f7_mail);
		$template->assign('f7_tel',		$f7_tel);
		$template->assign('f7_altro',	$f7_altro); 
		$template->assign('f7_offline',	$f7_offline);
		$template->assign('f7_moderatore',	$f7_moderatore);
		$template->assign('f7_contenuti',	$f7_contenuti);
		$template->assign('f7_test',	$f7_test);
		$template->assign('f7_grafica',	$f7_grafica);
		$template->assign('f7_prog',	$f7_prog);
		$template->assign('f7_tempo',	$f7_tempo);
		$template->assign('f7_internet',	$f7_internet);
		
		
		//esecuzione operazioni accettazione del form
		if ($f7_accept == true)
		{
			//salvataggio form
			$db =& $frontcontroller->getDbConnection('main');
			
			$q3_idQuestionario = $db->nextID('questionario_id_questionari');
			$q3_idUtente = $this->getSessionIdUtente();
			$query = 'INSERT INTO questionario (id_questionario, id_utente, data, nome, cognome, mail, telefono, tempo_disp, tempo_internet, attiv_offline, attiv_moderatore, attiv_contenuti, attiv_test, attiv_grafica, attiv_prog, altro) VALUES ( '.$db->quote($q3_idQuestionario).', '.$db->quote($q3_idUtente).', '.$db->quote(time()).', '.$db->quote($q3_nome).', '.$db->quote($q3_cognome).', '.$db->quote($q3_mail).', '.$db->quote($q3_tel).', '.$db->quote($q3_tempo).', '.$db->quote($q3_internet).', '.$db->quote($q3_offline).', '.$db->quote($q3_moderatore).', '.$db->quote($q3_contenuti).', '.$db->quote($q3_test).', '.$db->quote($q3_grafica).', '.$db->quote($q3_prog).', '.$db->quote($q3_altro).');';
			$res = $db->query($query);
			if (DB::isError($res))
			{ 
				Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__));
				return false;
			}
			

			//invio mail notifica
			$session_user = $this->getSessionUser();
			$mail =& $frontcontroller->getMail();

			$riceventi = $frontcontroller->getAppSetting('questionariReceiver');
			$array_riceventi = explode(';', $riceventi);
			foreach($array_riceventi as $key => $value)
			{
				$mail->AddAddress($value);
			}
			
			$mail->Subject = '[UniversiBO] Nuovo questionario';
			$mail->Body = 'nome: '.$f7_nome."\n".
			    'cognome: '.$f7_cognome."\n".
				'mail: '.$f7_mail."\n".
				'telefono: '.$f7_tel."\n".
				'username: '.$session_user->getUsername()."\n".
				'id_utente: '.$q3_idUtente."\n\n".
				'tempo_disponibile: '.$f7_tempo."\n".
				'tempo_internet: '.$f7_internet."\n".
				'attivita_offline: '.$q3_offline."\n".
				'attivita_moderatore: '.$q3_moderatore."\n".
				'attivita_contenuti: '.$q3_contenuti."\n".
				'attivita_test: '.$q3_test."\n".
				'attivita_grafica: '.$q3_grafica."\n".
				'attivita_prog: '.$q3_prog."\n".
				'altre_informazioni: '.$f7_altro."\n\n";
			
			//var_dump($mail);
			//if(!$mail->Send()) Error::throw(_ERROR_DEFAULT,array('msg'=>'Il questionario è stato salvato ma è stato impossibile inviare la notifica ai coordinatori', 'file'=>__FILE__, 'line'=>__LINE__));
			
			$template->assign('question_thanks',"Grazie per aver compilato il questionario, la tua richiesta è stata inoltrata ai ragazzi che si occupano del contatto dei nuovi collaboratori.\n Verrai ricontattatato da loro non appena possibile");
			return 'questionario_success';
		}				
		return 'default';
	}

}

?>