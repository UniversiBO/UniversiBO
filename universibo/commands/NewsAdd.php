<?php    

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('News/NewsItem'.PHP_EXTENSION);

/**
 * NewsAdd: si occupa dell'inserimento di una news in un canale
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class NewsAdd extends CanaleCommand {

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

		$template->assign('NewsAdd_back', $canale->showMe());
		
		$krono = & $frontcontroller->getKrono();

		// valori default form
		$f7_titolo = '';
		$f7_data_ins_gg = $krono->k_date('%j');
		$f7_data_ins_mm = $krono->k_date('%m');
		$f7_data_ins_aa = $krono->k_date('%Y');
		$f7_data_ins_ora = $krono->k_date('%H');
		$f7_data_ins_min = $krono->k_date('%i');
		$f7_data_scad_gg = '';
		$f7_data_scad_mm = '';
		$f7_data_scad_aa = '';
		$f7_data_scad_ora = '';
		$f7_data_scad_min = '';
		$f7_testo = '';
		$f7_urgente = false;
		$f7_scadenza = false;
		$f7_canale = array ();

		$elenco_canali = array($id_canale);
		$ruoli_keys = array_keys($user_ruoli);
		$num_ruoli = count($ruoli_keys);
		for ($i = 0; $i<$num_ruoli; $i++)
		{
			if ($id_canale != $ruoli_keys[$i])
				$elenco_canali[] = $user_ruoli[$ruoli_keys[$i]]->getIdCanale();
		}
		
		/*
		//come fo a prendere l'uri dove si trova l'utente?
		
		$template->assign('back_command', $id_canale);
		$template->assign('back_id_canale', $id_canale);
		*/
		
		$num_canali = count($elenco_canali);
		for ($i = 0; $i<$num_canali; $i++)
		{
			$id_current_canale = $elenco_canali[$i];
			$current_canale =& Canale::retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			$spunta = ($id_canale == $id_current_canale ) ? 'true' :'false';
			$f7_canale[] = array ('id_canale'=> $id_current_canale, 'nome_canale'=> $nome_current_canale, 'spunta'=> $spunta);
		}
		
		$f7_accept = false;
		
		if (array_key_exists('f7_submit', $_POST)) {
			$f7_accept = true;

			if (!array_key_exists('f7_titolo', $_POST) || !array_key_exists('f7_data_ins_gg', $_POST) || !array_key_exists('f7_data_ins_mm', $_POST) || !array_key_exists('f7_data_ins_aa', $_POST) || !array_key_exists('f7_data_ins_ora', $_POST) || !array_key_exists('f7_data_ins_min', $_POST) || !array_key_exists('f7_data_scad_gg', $_POST) || !array_key_exists('f7_data_scad_mm', $_POST) || !array_key_exists('f7_data_scad_aa', $_POST) || !array_key_exists('f7_data_scad_ora', $_POST) || !array_key_exists('f7_data_scad_min', $_POST) || !array_key_exists('f7_testo', $_POST)) {
				Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Il form inviato non è valido', 'file' => __FILE__, 'line' => __LINE__));
				$f7_accept = false;
			}

			//titolo	
			if (strlen($_POST['f7_titolo']) > 150) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inferiore ai 150 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			}
			elseif ($_POST['f7_titolo'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inserito obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			} else
				$f7_titolo = $_POST['f7_titolo'];
			
			$checkdate_ins = true;
			//data_ins_gg
			if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_gg'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo giorno di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
				$checkdate_ins = false;
			} else
				$f7_data_ins_gg = $_POST['f7_data_ins_gg'];

			//f7_data_ins_mm
			if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_mm'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo mese di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
				$checkdate_ins = false;
			} else
				$f7_data_ins_mm = $_POST['f7_data_ins_mm'];

			//f7_data_ins_aa
			if (!ereg('^([0-9]{4})$', $_POST['f7_data_ins_aa'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo anno di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
				$checkdate_ins = false;
			}
			elseif ($_POST['f7_data_ins_aa'] < 1970 || $_POST['f7_data_ins_aa'] > 2032) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
				$checkdate_ins = false;
			} else
				$f7_data_ins_aa = $_POST['f7_data_ins_aa'];

			//f7_data_ins_ora
			if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_ora'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo ora di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			}
			elseif ($_POST['f7_data_ins_ora'] < 0 || $_POST['f7_data_ins_ora'] > 23) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 23', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			} else
				$f7_data_ins_ora = $_POST['f7_data_ins_ora'];

			//f7_data_ins_min
			if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_ins_min'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			}
			elseif ($_POST['f7_data_ins_min'] < 0 || $_POST['f7_data_ins_min'] > 59) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 59', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			} else
				$f7_data_ins_min = $_POST['f7_data_ins_min'];

			if ( $checkdate_ins == true && !checkdate($_POST['f7_data_ins_mm'], $_POST['f7_data_ins_gg'], $_POST['f7_data_ins_aa']))
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La data di inserimento specificata non esiste', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			}
			
			$data_inserimento = mktime($_POST['f7_data_ins_ora'], $_POST['f7_data_ins_min'], "0", $_POST['f7_data_ins_mm'], $_POST['f7_data_ins_gg'], $_POST['f7_data_ins_aa']);
			$data_scadenza = NULL;
							
			if (array_key_exists('f7_scadenza', $_POST)) {

				$f7_scadenza = true;
				$checkdate_scad = true;
				//data_scad_gg
				if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_gg'])) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo giorno di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
					$checkdate_scad = false;
				} else
					$f7_data_scad_gg = $_POST['f7_data_scad_gg'];

				//f7_data_scad_mm
				if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_mm'])) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo mese di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
					$checkdate_scad = false;
				} else
					$f7_data_scad_mm = $_POST['f7_data_scad_mm'];

				//f7_data_scad_aa
				if (!ereg('^([0-9]{4})$', $_POST['f7_data_scad_aa'])) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo anno di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
					$checkdate_scad = false;
				}
				elseif ($_POST['f7_data_scad_aa'] < 1970 || $_POST['f7_data_scad_aa'] > 2032) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
					$checkdate_scad = false;
				} else
					$f7_data_scad_aa = $_POST['f7_data_scad_aa'];

				//f7_data_scad_ora
				if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_ora'])) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo ora di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				}
				elseif ($_POST['f7_data_scad_ora'] < 0 || $_POST['f7_data_scad_ora'] > 23) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 23', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				} else
					$f7_data_scad_ora = $_POST['f7_data_scad_ora'];

				//f7_data_scad_min
				if (!ereg('^([0-9]{1,2})$', $_POST['f7_data_scad_min'])) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				}
				elseif ($_POST['f7_data_scad_min'] < 0 || $_POST['f7_data_scad_min'] > 59) {
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 59', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				} else
					$f7_data_scad_min = $_POST['f7_data_scad_min'];

				if ( $checkdate_scad == true && !checkdate($_POST['f7_data_scad_mm'], $_POST['f7_data_scad_gg'], $_POST['f7_data_scad_aa']))
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'La data di scadenza specificata non esiste', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				}

				//scadenza posteriore a inserimento
				$data_scadenza = mktime($_POST['f7_data_scad_ora'], $_POST['f7_data_scad_min'], "0", $_POST['f7_data_scad_mm'], $_POST['f7_data_scad_gg'], $_POST['f7_data_scad_aa']);

				if ($data_scadenza < $data_inserimento)
					$f7_accept = false;

			}

			//testo	
			if (strlen($_POST['f7_testo']) > 3000) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il testo della notizia deve essere inferiore ai 3000 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			}
			elseif ($_POST['f7_testo'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il testo della notizia deve essere inserito obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f7_accept = false;
			} else
				$f7_testo = $_POST['f7_testo'];

			//flag urgente
			if (array_key_exists('f7_urgente', $_POST)) {
				$f7_urgente = true;
			}
			
			//diritti_su_tutti_i_canali
			foreach ($_POST['f7_canale'] as $key => $value)
			{
				$diritti = $user->isAdmin() || (array_key_exists($key,$user_ruoli) && ($user_ruoli[$key]->isReferente() || $user_ruoli[$key]->isModeratore() ));
				if (!$diritti)
				{
					//$user_ruoli[$key]->getIdCanale();
					$canale =& Canale::retrieveCanale($key);
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di inserimento nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f7_accept = false;
				}
			}
			
			
			//esecuzione operazioni accettazione del form
			if ($f7_accept == true) {

				//id_news = 0 per inserimento, $id_canali array dei canali in cui inserire
				$notizia = new NewsItem(0, $f7_titolo, $f7_testo, $data_inserimento, $data_scadenza, $data_inserimento, $f7_urgente, false, $user->getIdUser(), $user->getUsername());


				$notizia->insertNewsItem();
					
				//$num_canali = count($f7_canale);
				//var_dump($f7_canale);
				//var_dump($_POST['f7_canale']);
				foreach ($_POST['f7_canale'] as $key => $value)
				{
					$notizia->addCanale($key);
					$canale = Canale::retrieveCanale($key);
					$canale->setUltimaModifica(time(), true);
				}
				return 'success';
			}

		} //end if (array_key_exists('f7_submit', $_POST))

		$template->assign('f7_titolo', $f7_titolo);
		$template->assign('f7_data_ins_mm', $f7_data_ins_mm);
		$template->assign('f7_data_ins_gg', $f7_data_ins_gg);
		$template->assign('f7_data_ins_aa', $f7_data_ins_aa);
		$template->assign('f7_data_ins_ora', $f7_data_ins_ora);
		$template->assign('f7_data_ins_min', $f7_data_ins_min);
		$template->assign('f7_data_scad_gg', $f7_data_scad_gg);
		$template->assign('f7_data_scad_mm', $f7_data_scad_mm);
		$template->assign('f7_data_scad_aa', $f7_data_scad_aa);
		$template->assign('f7_data_scad_ora', $f7_data_scad_ora);
		$template->assign('f7_data_scad_min', $f7_data_scad_min);
		$template->assign('f7_testo', $f7_testo);
		$template->assign('f7_urgente', $f7_urgente);
		$template->assign('f7_scadenza', $f7_scadenza);
		$template->assign('f7_canale', $f7_canale);


		return 'default';

	}

}

?>