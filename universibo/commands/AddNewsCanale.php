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
		
		$krono =& $frontcontroller->getKrono();
		
		// valori default form
		$f7_titolo =	'';
		$f7_data_ins_gg =	$krono->k_date('%j');
		$f7_data_ins_mm =	$krono->k_date('%m');
		$f7_data_ins_aa =	$krono->k_date('%Y')'';
		$f7_data_ins_ora =	$krono->k_date('%H');
		$f7_data_ins_min =	$krono->k_date('%i');
		$f7_data_scad_gg =	'';
		$f7_data_scad_mm =	'';
		$f7_data_scad_aa =	'';	
		$f7_data_scad_ora =	'';
		$f7_data_scad_min =	'';
		$f7_testo		= '';
		$f7_urgente		= false;
		$f7_scadenza	= false;
		/*
		 * @todo da gestire
		 */
		$f7_canale[]	= array();
		
		$f7_accept = false;
		
		if (array_key_exists('f7_submit', $_POST)  )
		{
			//var_dump($_POST);
			$f7_accept = true;

			if ( !array_key_exists('f7_titolo', $_POST) ||
				 !array_key_exists('f7_data_ins_gg', $_POST) ||
				 !array_key_exists('f7_data_ins_mm', $_POST) ||
				 !array_key_exists('f7_data_ins_aa', $_POST) ||
				 !array_key_exists('f7_data_ins_ora', $_POST) ||
				 !array_key_exists('f7_data_ins_min', $_POST) ||
				 !array_key_exists('f7_data_scad_gg', $_POST) ||
				 !array_key_exists('f7_data_scad_mm', $_POST) ||
				 !array_key_exists('f7_data_scad_aa', $_POST) ||
				 !array_key_exists('f7_data_scad_ora', $_POST) ||
				 !array_key_exists('f7_data_scad_min', $_POST) ||
				 !array_key_exists('f7_testo', $_POST) ) 
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'Il form inviato non è valido','file'=>__FILE__,'line'=>__LINE__ ));
				$f7_accept = false;
			}	

			//titolo	
			if ( strlen($_POST['f7_titolo']) > 150 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il titolo deve essere inferiore ai 150 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif ( $_POST['f7_titolo'] == '' ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il titolo deve essere inserito obbligatoriamente','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_titolo = $_POST['f7_titolo'];

			//data_ins_gg
			if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_gg'] ) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo giorno di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_data_ins_gg = $_POST['f7_data_ins_gg'];

			//f7_data_ins_mm
			if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_mm'] ) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo mese di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_data_ins_mm = $_POST['f7_data_ins_mm'];

			//f7_data_ins_aa
			if ( !ereg('^([0-9]{4})$', $_POST['f7_data_ins_aa'] ) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo anno di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif($_POST['f7_data_ins_aa'] < 1970 || $_POST['f7_data_ins_aa'] > 2032)
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_data_ins_aa = $_POST['f7_data_ins_aa'];

			//f7_data_ins_ora
			if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_ora'] ) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo ora di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif($_POST['f7_data_ins_ora'] < 0 || $_POST['f7_data_ins_ora'] > 23)
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo ora di inserimento deve essere compreso tra 0 e 23','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_data_ins_ora = $_POST['f7_data_ins_ora'];

			//f7_data_ins_min
			if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_min'] ) ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo minuto di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif($_POST['f7_data_ins_min'] < 0 || $_POST['f7_data_ins_min'] > 59)
			{
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo ora di inserimento deve essere compreso tra 0 e 59','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_data_ins_min = $_POST['f7_data_ins_min'];
			
			////////////
			      if ( !checkdate($_POST['news_scad_mese'],$_POST['news_scad_giorno'],$_POST['news_scad_anno']) ) errore('La data specificata non esiste',__FILE__,__LINE__);
      if ( $_POST['news_scad_ora'] < 0  ||  $_POST['news_scad_ora'] > 23 ) errore('Valore ora deve essere compreso tra 0 e 23',__FILE__,__LINE__);
      if ( $_POST['news_scad_minuto'] < 0  ||  $_POST['news_scad_minuto'] > 59 ) errore('Valore minuto deve essere compreso tra il 0 e 59',__FILE__,__LINE__);
      
			$data_scadenza=mktime($_POST['news_scad_ora'], $_POST['news_scad_minuto'],
      "0", $_POST['news_scad_mese'], $_POST['news_scad_giorno'], $_POST['news_scad_anno']);
		}
			
			
			
			if (array_key_exists('f7_scadenza', $_POST)){
			
				$f7_scadenza = true;
				
				//data_scad_gg
				if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_gg'] ) ) {
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo giorno di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				else $f7_data_scad_gg = $_POST['f7_data_scad_gg'];
	
				//f7_data_scad_mm
				if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_mm'] ) ) {
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo mese di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				else $f7_data_scad_mm = $_POST['f7_data_scad_mm'];
	
				//f7_data_scad_aa
				if ( !ereg('^([0-9]{4})$', $_POST['f7_data_scad_aa'] ) ) {
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo anno di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				elseif($_POST['f7_data_scad_aa'] < 1970 || $_POST['f7_data_scad_aa'] > 2032)
				{
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				else $f7_data_scad_aa = $_POST['f7_data_scad_aa'];
	
				//f7_data_scad_ora
				if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_ora'] ) ) {
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo ora di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				elseif($_POST['f7_data_scad_ora'] < 0 || $_POST['f7_data_scad_ora'] > 23)
				{
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo ora di inserimento deve essere compreso tra 0 e 23','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				else $f7_data_scad_ora = $_POST['f7_data_scad_ora'];
	
				//f7_data_scad_min
				if ( !ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_min'] ) ) {
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il formato del campo minuto di inserimento non è valido','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				elseif($_POST['f7_data_scad_min'] < 0 || $_POST['f7_data_scad_min'] > 59)
				{
					Error::throw(_ERROR_NOTICE,array('msg'=>'Il campo ora di inserimento deve essere compreso tra 0 e 59','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
					$f7_accept = false;
				}
				else $f7_data_scad_min = $_POST['f7_data_scad_min'];
			
			}
			
			//testo	
			if ( strlen($_POST['f7_testo']) > 3000 ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il testo della notizia deve essere inferiore ai 3000 caratteri','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			elseif ( $_POST['f7_testo'] == '' ) {
				Error::throw(_ERROR_NOTICE,array('msg'=>'Il testo della notizia deve essere inserito obbligatoriamente','file'=>__FILE__,'line'=>__LINE__,'log'=>false ,'template_engine'=>&$template ));
				$f7_accept = false;
			}
			else $f7_testo = $_POST['f7_testo'];


			//flag urgente
			if ( array_key_exists('f7_urgente', $_POST) ) {
				$f7_urgente = true;
			}
			
		}


		$template->assign('f7_titolo',			$f7_titolo);
		$template->assign('f7_data_ins_mm',		$f7_data_ins_mm);
		$template->assign('f7_data_ins_gg',		$f7_data_ins_gg);
		$template->assign('f7_data_ins_aa',		$f7_data_ins_aa);
		$template->assign('f7_data_ins_ora',	$f7_data_ins_ora); 
		$template->assign('f7_data_ins_min',	$f7_data_ins_min);
		$template->assign('f7_data_scad_gg',	$f7_data_scad_gg);
		$template->assign('f7_data_scad_mm',	$f7_data_scad_mm);
		$template->assign('f7_data_scad_aa',	$f7_data_scad_aa);
		$template->assign('f7_data_scad_ora',	$f7_data_scad_ora);
		$template->assign('f7_data_scad_min',	$f7_data_scad_min);
		$template->assign('f7_testo',			$f7_testo);
		$template->assign('f7_urgente',			$f7_urgente);
		$template->assign('f7_scadenza',		$f7_scadenza);
		$template->assign('f7_canale',			$f7_canale);
		
		
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