<?php    

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * FileAdd: si occupa dell'inserimento di un file in un canale
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class FileAdd extends CanaleCommand {

	function execute() {

		$user = & $this->getSessionUser();
		$canale = & $this->getRequestCanale();
		$user_ruoli = & $user->getRuoli();
		$id_canale = $canale->getIdCanale();

		$referente = false;
		$moderatore = false;

		if (array_key_exists($id_canale, $user_ruoli)) {
			$ruolo = & $user_ruoli[$id_canale];

			$referente = $ruolo->isReferente();
			$moderatore = $ruolo->isModeratore();
		}
		
		if (!($user->isAdmin() || $referente || $moderatore)) 
			Error :: throw (_ERROR_DEFAULT, array ('msg' => "Non hai i diritti per inserire una notizia\n La sessione potrebbe essere scaduta", 'file' => __FILE__, 'line' => __LINE__));
		
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();

		// valori default form
		$f12_file = '';
		$f12_titolo = '';
		$f12_abstract = '';
		$f12_parole_chiave = '';
		$f12_categoria = '';
		$f12_data_ins_gg = $krono->k_date('%j');
		$f12_data_ins_mm = $krono->k_date('%m');
		$f12_data_ins_aa = $krono->k_date('%Y');
		$f12_data_ins_ora = $krono->k_date('%H');
		$f12_data_ins_min = $krono->k_date('%i');
		$f12_permessi_download = '';
		$f12_permessi_visualizza = '';
		$f12_password = false;
		$f12_canale = array ();

		//prendo tutti i canali tra i ruoli più il canale corrente (che per l'admin può essere diverso)
		$elenco_canali = array($id_canale);
		$ruoli_keys = array_keys($user_ruoli);
		$num_ruoli = count($ruoli_keys);
		for ($i = 0; $i<$num_ruoli; $i++)
		{
			if ($id_canale != $ruoli_keys[$i] && ($user->isAdmin() || $user_ruoli[$ruoli_keys[$i]]->isModeratore() || $user_ruoli[$ruoli_keys[$i]]->isReferente()) )
				$elenco_canali[] = $user_ruoli[$ruoli_keys[$i]]->getIdCanale();
		}
		
		$num_canali = count($elenco_canali);
		for ($i = 0; $i<$num_canali; $i++)
		{
			$id_current_canale = $elenco_canali[$i];
			$current_canale =& Canale::retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			$spunta = ($id_canale == $id_current_canale ) ? 'true' :'false';
			$f12_canale[] = array ('id_canale'=> $id_current_canale, 'nome_canale'=> $nome_current_canale, 'spunta'=> $spunta);
		}
		
		$f12_accept = false;
		
		if (array_key_exists('f12_submit', $_POST)) {
			$f12_accept = true;

			if (!array_key_exists('f12_titolo', $_POST) ||
			 !array_key_exists('f12_data_ins_gg', $_POST) || 
			 !array_key_exists('f12_data_ins_mm', $_POST) || 
			 !array_key_exists('f12_data_ins_aa', $_POST) || 
			 !array_key_exists('f12_data_ins_ora', $_POST) || 
			 !array_key_exists('f12_data_ins_min', $_POST) || 
			 !array_key_exists('f12_abstract', $_POST) || 
			 !array_key_exists('f12_parole_chiave', $_POST) || 
			 !array_key_exists('f12_categoria', $_POST) || 
			 !array_key_exists('f12_permessi_download', $_POST) || 
			 !array_key_exists('f12_permessi_visualizza', $_POST) || 
			 !array_key_exists('f12_password', $_POST) || 
			 !array_key_exists('f12_canale', $_POST) ) 
			 {
				Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Il form inviato non è valido', 'file' => __FILE__, 'line' => __LINE__));
				$f12_accept = false;
			}

			//titolo	
			if (strlen($_POST['f12_titolo']) > 150) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inferiore ai 150 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			elseif ($_POST['f12_titolo'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inserito obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			} else
				$f12_titolo = $_POST['f12_titolo'];
			
			$checkdate_ins = true;
			//data_ins_gg
			if (!ereg('^([0-9]{1,2})$', $_POST['f12_data_ins_gg'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo giorno di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
				$checkdate_ins = false;
			} else
				$f12_data_ins_gg = $_POST['f12_data_ins_gg'];

			//f12_data_ins_mm
			if (!ereg('^([0-9]{1,2})$', $_POST['f12_data_ins_mm'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo mese di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
				$checkdate_ins = false;
			} else
				$f12_data_ins_mm = $_POST['f12_data_ins_mm'];

			//f12_data_ins_aa
			if (!ereg('^([0-9]{4})$', $_POST['f12_data_ins_aa'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo anno di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
				$checkdate_ins = false;
			}
			elseif ($_POST['f12_data_ins_aa'] < 1970 || $_POST['f12_data_ins_aa'] > 2032) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
				$checkdate_ins = false;
			} else
				$f12_data_ins_aa = $_POST['f12_data_ins_aa'];

			//f12_data_ins_ora
			if (!ereg('^([0-9]{1,2})$', $_POST['f12_data_ins_ora'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo ora di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			elseif ($_POST['f12_data_ins_ora'] < 0 || $_POST['f12_data_ins_ora'] > 23) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 23', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			} else
				$f12_data_ins_ora = $_POST['f12_data_ins_ora'];

			//f12_data_ins_min
			if (!ereg('^([0-9]{1,2})$', $_POST['f12_data_ins_min'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			elseif ($_POST['f12_data_ins_min'] < 0 || $_POST['f12_data_ins_min'] > 59) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 59', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			} else
				$f12_data_ins_min = $_POST['f12_data_ins_min'];

			if ( $checkdate_ins == true && !checkdate($_POST['f12_data_ins_mm'], $_POST['f12_data_ins_gg'], $_POST['f12_data_ins_aa']))
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La data di inserimento specificata non esiste', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			
			$data_inserimento = mktime($_POST['f12_data_ins_ora'], $_POST['f12_data_ins_min'], "0", $_POST['f12_data_ins_mm'], $_POST['f12_data_ins_gg'], $_POST['f12_data_ins_aa']);
			
			//abstract	
			if (strlen($_POST['f12_abstract']) > 3000) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La descrizione/abstract del file deve essere inferiore ai 3000 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			elseif ($_POST['f12_abstract'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La descrizione/abstract del file deve essere inserita obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			} else
				$f12_testo = $_POST['f12_abstract'];

			//parole chiave	
			$parole_chiave = explode("\n", $_POST['f12_parole_chiave']);
			if (count($parole_chiave) > 4) 
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Si possono inserire al massimo 4 parole chiave', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			else 
			{
				foreach($parole_chiave as $parola)
				{
					if (strlen($parola > 40))
					{
						Error :: throw (_ERROR_NOTICE, array ('msg' => 'La lunghezza massima di una parola chiave è di 40 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
						$f12_accept = false;
					} 
				}
			}			
			
			//permessi_download	
			if (!ereg('^([0-9]{1,9})$', $_POST['f12_categoria'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo categoria non è ammissibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}

			//permessi_download	
			if (!ereg('^([0-9]{1,3})$', $_POST['f12_permessi_download'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f12_accept = false;
			}
			elseif ( $user->isAdmin() ) 
			{
				if ($_POST['f12_permessi_download'] < 0 || $_POST['f12_permessi_download'] > USER_ALL )
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il valore dei diritti di download non è ammessibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' =>& $template));
					$f12_accept = false;
				}
			}
			else 
			{
				if ($_POST['f12_permessi_download'] != USER_ALL || $_POST['f12_permessi_download'] != (USER_STUDENTE & USER_DOCENTE & USER_TUTOR & USER_PERSONALE & USER_COLLABORATORE & USER_ADMIN ) )
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il valore dei diritti di download non è ammessibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' =>& $template));
					$f12_accept = false;
				}
			}			
			
			//password non necessita controlli
			
			
			//e i permessi di visualizzazione??
			
			
			//diritti_su_tutti_i_canali
			foreach ($_POST['f12_canale'] as $key => $value)
			{
				$diritti = $user->isAdmin() || (array_key_exists($key,$user_ruoli) && ($user_ruoli[$key]->isReferente() || $user_ruoli[$key]->isModeratore() ));
				if (!$diritti)
				{
					//$user_ruoli[$key]->getIdCanale();
					$canale =& Canale::retrieveCanale($key);
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di inserimento nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f12_accept = false;
				}
			}
			
			
			//esecuzione operazioni accettazione del form
			if ($f12_accept == true) {

				//id_news = 0 per inserimento, $id_canali array dei canali in cui inserire
				$notizia = new NewsItem(0, $f12_titolo, $f12_testo, $data_inserimento, $data_scadenza, $data_inserimento, $f12_urgente, false, $user->getIdUser(), $user->getUsername());


				$notizia->insertNewsItem();
					
				//$num_canali = count($f12_canale);
				//var_dump($f12_canale);
				//var_dump($_POST['f12_canale']);
				foreach ($_POST['f12_canale'] as $key => $value)
				{
					$notizia->addCanale($key);
					$canale = Canale::retrieveCanale($key);
					$canale->setUltimaModifica(time(), true);
				}
				return 'success';
			}

		} //end if (array_key_exists('f12_submit', $_POST))

		$template->assign('f12_titolo', $f12_titolo);
		$template->assign('f12_data_ins_mm', $f12_data_ins_mm);
		$template->assign('f12_data_ins_gg', $f12_data_ins_gg);
		$template->assign('f12_data_ins_aa', $f12_data_ins_aa);
		$template->assign('f12_data_ins_ora', $f12_data_ins_ora);
		$template->assign('f12_data_ins_min', $f12_data_ins_min);


		return 'default';

	}

}

?>