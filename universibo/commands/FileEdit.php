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

class FileEdit extends UniversiboCommand {

	function execute() {
		
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();
		
		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
		{
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		}
		$canale = & Canale::retrieveCanale($_GET['id_canale']);
		$id_canale = $canale->getIdCanale();

		if (!array_key_exists('id_file', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_file']))
		{
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del file richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		}
		$file = & FileItem::selectFileItem($_GET['id_file']);
		if ($file === false)
			Error :: throw (_ERROR_DEFAULT, array ('msg' => "Il file richiesto non è presente su database", 'file' => __FILE__, 'line' => __LINE__));
		
		//$id_canale = $canale->getIdCanale();

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
		// $f13_file = '';
		$f13_titolo = $file->getTitolo();
		$f13_abstract = $file->getDescrizione();
		$f13_parole_chiave =  $file->getParolechiave();
		$f13_categorie = FileItem::getCategorie();
		$f13_categoria = $file->getIdCategoria();
		$f13_tipi = FileItem::getTipi();
		$f13_tipo = $file->getIdTipoFile();
		$f13_data_inserimento = $file->getDataInserimento();
		$f13_permessi_download = $file->getPermessiDownload();
		$f13_permessi_visualizza = $file->getPermessiVisualizza();
		$f13_password_enable = ($file->getPassword() == null);
		$f13_password = '';

		//prendo tutti i canali tra i ruoli più il canale corrente (che per l'admin può essere diverso)
		$elenco_canali = $file->getIdCanali();
		$num_canali = count($elenco_canali);
		for ($i = 0; $i<$num_canali; $i++)
		{
			$id_current_canale = $elenco_canali[$i];
			$current_canale =& Canale::retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			$f13_canale[] = array ('nome_canale'=> $nome_current_canale);
		}


		$f13_accept = false;
		
		if (array_key_exists('f13_submit', $_POST)) 
		{
			$f13_accept = true;

			if ( !array_key_exists('f13_file', $_FILES) ||
			 !array_key_exists('f13_titolo', $_POST) ||
			 !array_key_exists('f13_data_ins_gg', $_POST) || 
			 !array_key_exists('f13_data_ins_mm', $_POST) || 
			 !array_key_exists('f13_data_ins_aa', $_POST) || 
			 !array_key_exists('f13_data_ins_ora', $_POST) || 
			 !array_key_exists('f13_data_ins_min', $_POST) || 
			 !array_key_exists('f13_abstract', $_POST) || 
			 !array_key_exists('f13_parole_chiave', $_POST) || 
			 !array_key_exists('f13_categoria', $_POST) || 
			 !array_key_exists('f13_permessi_download', $_POST) || 
			 !array_key_exists('f13_permessi_visualizza', $_POST) || 
			 !array_key_exists('f13_password', $_POST) || 
			 !array_key_exists('f13_password_confirm', $_POST) || 
			 !array_key_exists('f13_canale', $_POST) ) 
			{
				var_dump($_POST);die();
				Error :: throw (_ERROR_DEFAULT, array ('msg' => 'Il form inviato non è valido', 'file' => __FILE__, 'line' => __LINE__));
				$f13_accept = false;
			}
			
			
			//titolo	
			if (strlen($_POST['f13_titolo']) > 150) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inferiore ai 150 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ($_POST['f13_titolo'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il titolo deve essere inserito obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			} else
				$f13_titolo = $_POST['f13_titolo'];
			
			
			//abstract
			$f13_abstract = $_POST['f13_abstract'];
			
			
			$checkdate_ins = true;
			//data_ins_gg
			if (!ereg('^([0-9]{1,2})$', $_POST['f13_data_ins_gg'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo giorno di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
				$checkdate_ins = false;
			} else
				$f13_data_ins_gg = $_POST['f13_data_ins_gg'];

			//f13_data_ins_mm
			if (!ereg('^([0-9]{1,2})$', $_POST['f13_data_ins_mm'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo mese di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
				$checkdate_ins = false;
			} else
				$f13_data_ins_mm = $_POST['f13_data_ins_mm'];

			//f13_data_ins_aa
			if (!ereg('^([0-9]{4})$', $_POST['f13_data_ins_aa'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo anno di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
				$checkdate_ins = false;
			}
			elseif ($_POST['f13_data_ins_aa'] < 1970 || $_POST['f13_data_ins_aa'] > 2032) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo anno di inserimento deve essere compreso tra il 1970 e il 2032', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
				$checkdate_ins = false;
			} else
				$f13_data_ins_aa = $_POST['f13_data_ins_aa'];

			//f13_data_ins_ora
			if (!ereg('^([0-9]{1,2})$', $_POST['f13_data_ins_ora'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo ora di inserimento non \u00e8 valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ($_POST['f13_data_ins_ora'] < 0 || $_POST['f13_data_ins_ora'] > 23) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 23', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			} else
				$f13_data_ins_ora = $_POST['f13_data_ins_ora'];

			//f13_data_ins_min
			if (!ereg('^([0-9]{1,2})$', $_POST['f13_data_ins_min'])) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ($_POST['f13_data_ins_min'] < 0 || $_POST['f13_data_ins_min'] > 59) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il campo ora di inserimento deve essere compreso tra 0 e 59', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			} else
				$f13_data_ins_min = $_POST['f13_data_ins_min'];

			if ( $checkdate_ins == true && !checkdate($_POST['f13_data_ins_mm'], $_POST['f13_data_ins_gg'], $_POST['f13_data_ins_aa']))
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La data di inserimento specificata non esiste', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			
			$f13_data_inserimento = mktime($_POST['f13_data_ins_ora'], $_POST['f13_data_ins_min'], "0", $_POST['f13_data_ins_mm'], $_POST['f13_data_ins_gg'], $_POST['f13_data_ins_aa']);
			
			//abstract	
			if (strlen($_POST['f13_abstract']) > 3000) {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La descrizione/abstract del file deve essere inferiore ai 3000 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ($_POST['f13_abstract'] == '') {
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La descrizione/abstract del file deve essere inserita obbligatoriamente', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			} else
				$f13_testo = $_POST['f13_abstract'];

			//parole chiave
			if ($_POST['f13_parole_chiave'] != '')
			{	
				$parole_chiave = explode("\n", $_POST['f13_parole_chiave']);
				if (count($parole_chiave) > 4) 
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Si possono inserire al massimo 4 parole chiave', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f13_accept = false;
				}
				else 
				{
					foreach($parole_chiave as $parola)
					{
						if (strlen($parola > 40))
						{
							Error :: throw (_ERROR_NOTICE, array ('msg' => 'La lunghezza massima di una parola chiave è di 40 caratteri', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
							$f13_accept = false;
						}
						else
						{
							$f13_parole_chiave[] = $parola;
						}
					}
				}			
			}
			
			//categoria	
			if (!ereg('^([0-9]{1,9})$', $_POST['f13_categoria'])) 
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo categoria non è ammissibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ( !array_key_exists($_POST['f13_categoria'], $f13_categorie) )
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La categoria inviata contiene un valore non ammissibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			else $f13_categoria = $_POST['f13_categoria'];
			
			//permessi_download	
			if (!ereg('^([0-9]{1,3})$', $_POST['f13_permessi_download'])) 
			{
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il formato del campo minuto di inserimento non è valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			elseif ( $user->isAdmin() ) 
			{
				if ($_POST['f13_permessi_download'] < 0 || $_POST['f13_permessi_download'] > USER_ALL )
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il valore dei diritti di download non è ammessibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' =>& $template));
					$f13_accept = false;
				}
				$f13_permessi_download = $_POST['f13_permessi_download'];
			}
			else 
			{
				if ($_POST['f13_permessi_download'] != USER_ALL || $_POST['f13_permessi_download'] != (USER_STUDENTE & USER_DOCENTE & USER_TUTOR & USER_PERSONALE & USER_COLLABORATORE & USER_ADMIN ) )
				{
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Il valore dei diritti di download non è ammessibile', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' =>& $template));
					$f13_accept = false;
				}
			}			
			
			//password non necessita controlli
			if ($_POST['f13_password'] != $_POST['f13_password_confirm'])
			{ 
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'La password e il campo di verifica non corrispondono', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' =>& $template));
				$f12_accept = false;
			}
			elseif($_POST['f13_password'] != '')
			{ 
				$f13_password = $_POST['f13_password'];
			}
			
			//e i permessi di visualizzazione??
			// li prendo uguali a quelli del canale,
			$f13_permessi_visualizza = $canale->getPermessi();
			// eventualmente dare la possibilità all'admin di metterli diversamente
			
			
			$f13_canali_inserimento = array();
			//controllo i diritti_su_tutti_i_canali su cui si vuole fare l'inserimento
			foreach ($_POST['f13_canale'] as $key => $value)
			{
				$diritti = $user->isAdmin() || (array_key_exists($key,$user_ruoli) && ($user_ruoli[$key]->isReferente() || $user_ruoli[$key]->isModeratore() ));
				if (!$diritti)
				{
					//$user_ruoli[$key]->getIdCanale();
					$canale =& $elenco_canali_retrieve[$key];
					Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di inserimento nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f13_accept = false;
				}
				
				$f13_canali_inserimento = $_POST['f13_canale'];
			}
			
			//echo substr($_FILES['userfile']['name'],-4);
			$estensione = strtolower ( substr($_FILES['f13_file']['name'],-4) );
			if ( $estensione == '.php')
			{
				Error::throw(_ERROR_DEFAULT,array('msg'=>'E\' severamente vietato inserire file con estensione .php','file'=>__FILE__,'line'=>__LINE__));
				$f13_accept = false;
			}	
			elseif (!is_uploaded_file($_FILES['f13_file']['tmp_name'])) 
			{
				Error :: throw(_ERROR_NOTICE, array('msg' => 'Non e\' stato inviato nessun file', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f13_accept = false;
			}
			
			
			
			//esecuzione operazioni accettazione del form
			if ($f13_accept == true) 
			{
				
				$db = FrontController::getDbConnection('main');
				ignore_user_abort(1);
        		$db->autoCommit(false);
			
				$newFile = new FileItem(0, $f13_permessi_download, $f13_permessi_visualizza, $user->getIdUser(), $f13_titolo, $f13_abstract,
				$f13_data_inserimento, time(), $_FILES['f13_file']['size'] / 1024, 0, $_FILES['f13_file']['name'], $f13_categoria, 
				FileItem::guessTipo($_FILES['f13_file']['tmp_name']), md5_file($_FILES['f13_file']['tmp_name']), ($f13_password == null) ? $f13_password : FileItem::passwordHashFunction($f13_password), 
				'', '', '', '', '');
				/* gli ultimi parametri dipendono da altre tabelle e
				 il loro valore viene insegnato internamente a FileItem 
				 bisognerebbe non usare il costruttore per dover fare l'insert
				 ma...*/
				
				$newFile->insertFileItem();
				
				$newFile->setParoleChiave($f13_parole_chiave);

				$nomeFile = $newFile->getNomeFile();
				
				if ( move_uploaded_file($_FILES['f13_file']['tmp_name'],$frontcontroller->getAppSetting('filesPath').$nomeFile ) === false )
				{
					$db->rollback();
					Error :: throw(_ERROR_DEFAULT, array('msg' => 'Errore nella copia del file', 'file' => __FILE__, 'line' => __LINE__));
				}
				
				
				//$num_canali = count($f13_canale);
				//var_dump($f13_canale);
				//var_dump($_POST['f13_canale']);
				foreach ($_POST['f13_canale'] as $key => $value)
				{
					$newFile->addCanale($key);
					$canale =& $elenco_canali_retrieve[$key];
					$canale->setUltimaModifica(time(), true);
				}
				
        		$db->autoCommit(true);
				ignore_user_abort(0);
				
				return 'success';
			}

		} 
		//end if (array_key_exists('f13_submit', $_POST))

		
		// resta da sistemare qui sotto, fare il form e fare debugging
		
		$template->assign('f13_titolo', $f13_titolo);
		$template->assign('f13_abstract', $f13_abstract);
		$template->assign('f13_parole_chiave', $f13_parole_chiave);
		$template->assign('f13_categoria', $f13_categoria);
		$template->assign('f13_categorie', $f13_categorie);
		$template->assign('f13_tipo', $f13_tipo);
		$template->assign('f13_tipi', $f13_tipi);
		$template->assign('f13_abstract', $f13_abstract);
		$template->assign('f13_canale', $f13_canale);
		
		$template->assign('f13_password', $f13_password);
		$template->assign('f13_password_confirm', $f13_password);
		$template->assign('f13_password_enable', ($f13_password_enable) ? 'true' : 'false' );
		$template->assign('f13_permessi_download', $f13_permessi_download);
		$template->assign('f13_permessi_visualizza', $f13_permessi_visualizza);
		$template->assign('f13_data_ins_gg', $krono->k_date('%j',$f13_data_inserimento));
		$template->assign('f13_data_ins_mm', $krono->k_date('%m',$f13_data_inserimento));
		$template->assign('f13_data_ins_aa', $krono->k_date('%Y',$f13_data_inserimento));
		$template->assign('f13_data_ins_ora', $krono->k_date('%H',$f13_data_inserimento));
		$template->assign('f13_data_ins_min', $krono->k_date('%i',$f13_data_inserimento));
		$template->assign('common_canaleURI', $canale->showMe());
		$template->assign('common_langCanaleNome', $canale->getTitolo());

		$this->executePlugin('ShowTopic', array('reference' => 'filescollabs'));
		return 'default';

	}

}

?>