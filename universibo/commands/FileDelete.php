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

class FileDelete extends UniversiboCommand {


	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();

		
		if (!array_key_exists('id_canale', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_canale']))
		{
			Error :: throw (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		}
		$canale = & Canale::retrieveCanale($_GET['id_canale']);
		
		$user =& $this->getSessionUser();
		
		$referente = false;
		$moderatore = false;
			
		$user_ruoli = $user->getRuoli();
		$id_canale = $canale->getIdCanale();
	
		
		if (!array_key_exists('id_file', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_file'] )  )
		{
			Error::throw(_ERROR_DEFAULT,array('msg'=>'L\'id del file richiesto non è valido','file'=>__FILE__,'line'=>__LINE__ ));
		}
		
		/* diritti
		 -admin
		 -autore file
		 -referenti canale
		*/
		
		if (array_key_exists($id_canale, $user_ruoli))
		{
			$ruolo = & $user_ruoli[$id_canale];

			$referente = $ruolo->isReferente();
			$moderatore = $ruolo->isModeratore();
		}

		$file = & FileItem::selectFileItem($_GET['id_file']);
		//$news-> getIdCanali();
		/*var_dump($news->getNotizia());
		die();
		*/		
		$autore = ($user->getIdUser() == $file->getIdUtente());
		if (!($user->isAdmin() || $referente || ($moderatore && $autore)))
			Error :: throw (_ERROR_DEFAULT, array ('msg' => "Non hai i diritti per eliminare il file\n La sessione potrebbe essere scaduta", 'file' => __FILE__, 'line' => __LINE__));
		
		//$elenco_canali = array ($id_canale);
		$ruoli_keys = array_keys($user_ruoli);
		$num_ruoli = count($ruoli_keys);
		for ($i = 0; $i < $num_ruoli; $i ++)
		{
			$elenco_canali[] = $user_ruoli[$ruoli_keys[$i]]->getIdCanale();
		}
		
		$file_canali =& $file->getIdCanali();
		
		
		$num_canali = count($file_canali);
		for ($i = 0; $i < $num_canali; $i ++)
		{
			$id_current_canale = $file_canali[$i];
			$current_canale = & Canale :: retrieveCanale($id_current_canale);
			$nome_current_canale = $current_canale->getTitolo();
			if (in_array($id_current_canale, $file->getIdCanali())) 
			{
				$f13_canale[] = array ('id_canale' => $id_current_canale, 'nome_canale' => $nome_current_canale, 'spunta' => 'true');
			}
		}
		
		$f13_accept = false;
		
		//postback
		
		if (array_key_exists('f13_submit', $_POST)  )
		{
			$f13_accept = true;
			
			//controllo diritti su ogni canale di cui è richiesta la cancellazione
			if (array_key_exists('f13_canale', $_POST))
			{
				foreach ($_POST['f13_canale'] as $key => $value)
				{
					$diritti = $user->isAdmin() || (array_key_exists($key, $user_ruoli) && ($user_ruoli[$key]->isReferente() || ($user_ruoli[$key]->isModeratore() && $autore)));
					if (!$diritti)
					{
						//$user_ruoli[$key]->getIdCanale();
						$canale = & Canale :: retrieveCanale($key);
						Error :: throw (_ERROR_NOTICE, array ('msg' => 'Non possiedi i diritti di eliminazione nel canale: '.$canale->getTitolo(), 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
						$f13_accept = false;
					}
				}
			}
			else
			{
				$f13_accept = false;
				Error :: throw (_ERROR_NOTICE, array ('msg' => 'Devi selezionare almeno un canale:', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
			}
			
		}
		
		
		//accettazione della richiesta
		if ($f13_accept == true)
		{
//			var_dump($_POST['f13_canale'] );
//			die();
			//cancellazione dai canali richiesti
			foreach ($_POST['f13_canale'] as $key => $value)
				{
					$file->removeCanale($key);
					$canale = Canale::retrieveCanale($key);					
				}
			
			$file->deleteFileItem();
			/**
			 * @TODO elenco dei canali dai quali è stata effetivamente cancellata la notizia
			 */
			$template->assign('NewsDelete_langSuccess', "La notizia è stata cancellata dai canali scelti.");
			
			return 'success';
		}
		
		//visualizza notizia
		//$param = array('id_notizie'=>array($_GET['id_news']), 'chk_diritti' => false );
		//$this->executePlugin('ShowNews', $param );
		
		$template->assign('f13_langAction', "Elimina il file dai seguenti canali:");
		$template->assign('f13_canale', $f13_canale);

		$this->executePlugin('ShowTopic', array('reference' => 'filescollabs'));
		
		return 'default';
	}

}

?>