<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Files/FileItem'.PHP_EXTENSION);
require_once ('Files/FileItemStudenti'.PHP_EXTENSION);
require_once ('Commenti/CommentoItem'.PHP_EXTENSION);

/**
 * FileStudentiComment: si occupa dell'inserimento di un nuovo commento per il File Studente
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @author Daniele Tiles
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class FileStudentiComment extends UniversiboCommand {

	function execute() {
		
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();

		if ($user->isOspite())
		{
			Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => "Per questa operazione bisogna essere registrati\n la sessione potrebbe essere terminata", 'file' => __FILE__, 'line' => __LINE__));
		}		
		if (!array_key_exists('id_file', $_GET) || !ereg('^([0-9]{1,9})$', $_GET['id_file']))
		{
			Error :: throwError(_ERROR_DEFAULT, array ('msg' => 'L\'id del file richiesto non � valido', 'file' => __FILE__, 'line' => __LINE__));
		}
		$file = & FileItemStudenti::selectFileItem($_GET['id_file']);
		if ($file === false)
			Error :: throwError(_ERROR_DEFAULT, array ('msg' => "Il file richiesto non � presente su database", 'file' => __FILE__, 'line' => __LINE__));
		
		//Controllo che non esista gi� un commento da parte di questo utente
		
		$id_file = $_GET['id_file'];
		$esiste_commento = $this->esisteCommento($id_file,$user->getIdUser());
		if($esiste_commento)
		{   
			$canali = $file->getIdCanali();
			$template->assign('FileStudentiComment_ris','Esiste gi� un tuo commento');
			$template->assign('common_canaleURI','index.php?do=FileShowInfo&id_file='.$id_file.'&id_canale='.$canali);
			return 'success';
		}
		
		$template->assign('common_canaleURI', array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '' );
		$template->assign('common_langCanaleNome', 'indietro');
		$id_file = $_GET['id_file'];

		// valori default form
		$f26_commento = '';
		$f26_voto = '';					
				
		$f26_accept = false;
		
		if (array_key_exists('f26_submit', $_POST)) 
		{
			$f26_accept = true;

			if ( !array_key_exists('f26_commento', $_POST) || 
			 !array_key_exists('f26_voto', $_POST)) 
			{
				//var_dump($_POST);die();
				Error :: throwError(_ERROR_DEFAULT, array ('id_utente' => $user->getIdUser(), 'msg' => 'Il form inviato non ? valido', 'file' => __FILE__, 'line' => __LINE__));
				$f26_accept = false;
			}
			
			
			//commento
			$f26_commento = $_POST['f26_commento'];
			
			//voto
			if (!ereg('^([0-5]{1})$', $_POST['f26_voto'])) {
				Error :: throwError(_ERROR_NOTICE, array ('id_utente' => $user->getIdUser(), 'msg' => 'Voto non valido', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f26_accept = false;
			} else
				$f26_voto = $_POST['f26_voto'];
			
			
			
			//esecuzione operazioni accettazione del form
			if ($f26_accept == true) 
			{
				
				CommentoItem::insertCommentoItem($id_file,$user->getIdUser(),$f26_commento,$f26_voto);
//				
//				if (array_key_exists('f26_canale', $_POST))
//					foreach ($_POST['f26_canale'] as $key => $value)
//					{
//						$newFile->addCanale($key);
//						$canale =& $elenco_canali_retrieve[$key];
//						$canale->setUltimaModifica(time(), true);
//						
//						
//						//notifiche
//						require_once('Notifica/NotificaItem'.PHP_EXTENSION);
//						$notifica_titolo = 'Nuovo file inserito in '.$canale->getNome();
//						$notifica_titolo = substr($notifica_titolo,0 , 199);
//						$notifica_dataIns = $f26_data_inserimento;
//						$notifica_urgente = false;
//						$notifica_eliminata = false;
//						$notifica_messaggio = 
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//Titolo File: '.$f26_titolo.'
//
//Descrizione: '.$f26_commento.'
//
//Dimensione: '.$dimensione_file.' kB
//
//Autore: '.$user->getUsername().'
//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//Informazioni per la cancellazione:
//
//Per rimuoverti, vai all\'indirizzo:
//'.$frontcontroller->getAppSetting('rootUrl').' 
//e modifica il tuo profilo personale nella dopo aver eseguito il login
//Per altri problemi contattare lo staff di UniversiBO
//'.$frontcontroller->getAppSetting('infoEmail');
//						
//						$ruoli_canale =& $canale->getRuoli();
//						foreach ($ruoli_canale as $ruolo_canale)
//						{
//									//define('NOTIFICA_NONE'   ,0);
//									//define('NOTIFICA_URGENT' ,1);
//									//define('NOTIFICA_ALL'    ,2);
//							if ($ruolo_canale->isMyUniversiBO() && ($ruolo_canale->getTipoNotifica()==NOTIFICA_URGENT || $ruolo_canale->getTipoNotifica()==NOTIFICA_ALL) )
//							{
//								$notifica_user = $ruolo_canale->getUser();
//								$notifica_destinatario = 'mail://'.$notifica_user->getEmail();
//								
//								$notifica = new NotificaItem(0, $notifica_titolo, $notifica_messaggio, $notifica_dataIns, $notifica_urgente, $notifica_eliminata, $notifica_destinatario );
//								$notifica->insertNotificaItem();
//							}
//						}
//						
//						//ultima notifica all'archivio
//						$notifica_destinatario = 'mail://'.$frontcontroller->getAppSetting('rootEmail');;
//						
//						$notifica = new NotificaItem(0, $notifica_titolo, $notifica_messaggio, $notifica_dataIns, $notifica_urgente, $notifica_eliminata, $notifica_destinatario );
//						$notifica->insertNotificaItem();
//						
//					}
				
				
				$canali = $file->getIdCanali();
				$template->assign('FileStudentiComment_ris','Il tuo commento � stato inserito con successo.');
				$template->assign('common_canaleURI','index.php?do=FileShowInfo&id_file='.$id_file.'&id_canale='.$canali);
				return 'success';
			}

		} 
		//end if (array_key_exists('f26_submit', $_POST))

		
		// resta da sistemare qui sotto, fare il form e fare debugging
		
		$template->assign('f26_commento', $f26_commento);
		$template->assign('f26_voto', $f26_voto);

		return 'default';

	}
	
	/**
	 * Questa funzione verifica se esiste gi� un commento inserito dall'utente
	 * 
	 * @param $id_file, $id_utente id del file e dell'utente
	 * @return un valore booleano
	 */
	
	function & esisteCommento($id_file,$id_utente)
	{
		$flag = false;
		
		$db = & FrontController :: getDbConnection('main');

		$query = 'SELECT count(*) FROM file_studente_commenti WHERE id_file_studente ='.$db->quote($id_file).' AND id_utente = '.$db->quote($id_utente).' GROUP BY id_file_studente,id_utente';
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throwError(_ERROR_DEFAULT, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));
		$res->fetchInto($ris);	
		if($ris[0]==1) $flag=true;
		
		return $flag;
	}

}

?>