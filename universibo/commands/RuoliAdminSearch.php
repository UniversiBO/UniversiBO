<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);

/**
 * NewsDelete: elimina una notizia, mostra il form e gestisce la cancellazione 
 * 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class RuoliAdminSearch extends UniversiboCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();

		
		$template->assign('common_canaleURI', $_SERVER['HTTP_REFERER']);
		$template->assign('common_langCanaleNome', 'indietro');
		
		$user =& $this->getSessionUser();
		
		$referente = false;
		
		$user_ruoli = $user->getRuoli();
		$ruoli = array();
		
							
		if (array_key_exists('id_canale', $_GET))
		{
			if (!ereg('^([0-9]{1,9})$', $_GET['id_canale']))
				Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
			
			$canale = & Canale::retrieveCanale($_GET['id_canale']);
			$id_canale = $canale->getIdCanale();
			
			$template->assign('common_canaleURI', $canale->showMe());
			$template->assign('common_langCanaleNome', 'a '.$canale->getTitolo());
			
			if (array_key_exists($id_canale, $user_ruoli)) 
			{
				$ruolo = & $user_ruoli[$id_canale];
				
				$referente = $ruolo->isReferente();
			}
			
			$canale_ruoli = $canale->getRuoli();
			$ruoli_keys = array_keys($canale_ruoli);
			foreach($ruoli_keys as $key)
			{
				if ($canale_ruoli[$key]->isReferente() || $canale_ruoli[$key]->isModeratore() )
				{
					$ruoli[] =& $canale_ruoli[$key];
					$user =& User::selectUser($ruolo->getIdUser());
					//var_dump($user);
					$contactUser = array();
					$contactUser['utente_link']  = 'index.php?do=ShowUser&id_utente='.$user->getIdUser();
					$contactUser['nome']  = $user->getUserPublicGroupName();
					$contactUser['label'] = $user->getUsername();
					$contactUser['ruolo'] = ($ruolo->isReferente()) ? 'R' :  (($ruolo->isModeratore()) ? 'M' : 'none');
					//var_dump($ruolo);
					//$arrayUsers[] = $contactUser;
					$arrayPublicUsers[$user->getUserPublicGroupName(false)][] = $contactUser;
					
				}
			}
			
		}
		
		
		die();
		if (!($user->isAdmin() || $referente ) )
			Error :: throw (_ERROR_DEFAULT, array ('msg' => "Non hai i diritti per modificare i diritti degli utenti su questa pagina.\nLa sessione potrebbe essere scaduta.", 'file' => __FILE__, 'line' => __LINE__));
		
		//$elenco_canali = array ($id_canale);
		$ruoli_keys = array_keys($user_ruoli);
		$num_ruoli = count($ruoli_keys);
		for ($i = 0; $i < $num_ruoli; $i ++)
		{
			$elenco_canali[] = $user_ruoli[$ruoli_keys[$i]]->getIdCanale();
		}
		
		$file_canali =& $file->getIdCanali();
		
		$f14_canale = array();
		$num_canali = count($file_canali);
		for ($i = 0; $i < $num_canali; $i ++)
		{
			$id_current_canale = $file_canali[$i];
			$current_canale = & Canale :: retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			if (in_array($id_current_canale, $file->getIdCanali())) 
			{
				$f14_canale[] = array ('id_canale' => $id_current_canale, 'nome_canale' => $nome_current_canale, 'spunta' => 'true');
			}
		}
		
		$f14_accept = false;
		
		//postback
		
		if (array_key_exists('f14_submit', $_POST)  )
		{
			
			$f14_accept = true;
			
			$f14_canale_app = array();
			//controllo diritti su ogni canale di cui è richiesta la cancellazione
			if (array_key_exists('f14_canale', $_POST))
			{
				foreach ($_POST['f14_canale'] as $key => $value)
				{
					$diritti = $user->isAdmin() || (array_key_exists($key, $user_ruoli) && ($user_ruoli[$key]->isReferente() || ($user_ruoli[$key]->isModeratore() && $autore)));
					if (!$diritti)
					{
						//$user_ruoli[$key]->getIdCanale();
						$canale = & Canale::retrieveCanale($key);
						Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di eliminazione nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
						$f14_accept = false;
					}
					else
						$f14_canale_app[$key] = $value;
				}
			}
			elseif(count($f14_canale) > 0)
			{
				$f14_accept = false;
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Devi selezionare almeno una pagina:', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			}
			
		}
		
		
		//accettazione della richiesta
		if ($f14_accept == true)
		{
//			var_dump($_POST['f14_canale'] );
//			die();
			//cancellazione dai canali richiesti
			foreach ($f14_canale_app as $key => $value)
			{
				$file->removeCanale($key);
				$canale = Canale::retrieveCanale($key);					
			}
			
			$file->deleteFileItem();
			/**
			 * @TODO elenco dei canali dai quali è stata effetivamente cancellata la notizia
			 */
			$template->assign('fileDelete_langSuccess', "Il file è stato cancellato con successo dalle pagine scelte.");
			
			return 'success';
		}
		
		//visualizza notizia
		//$param = array('id_notizie'=>array($_GET['id_news']), 'chk_diritti' => false );
		//$this->executePlugin('ShowNews', $param );
		
		$template->assign('f14_langAction', "Elimina il file dalle seguenti pagine:");
		$template->assign('f14_canale', $f14_canale);
		$template->assign('fileDelete_flagCanali', (count($f14_canale)) ? 'true' : 'false');
		
		$this->executePlugin('ShowTopic', array('reference' => 'filescollabs'));
		
		return 'default';
	}

}

?>