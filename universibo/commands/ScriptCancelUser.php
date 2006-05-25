<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);


/**
 *
 * Si occupa della cancellazione di un utente in accordo alla informativa da lui approvata 
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptCancelUser extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $fc->getTemplateEngine();
		$db =& $fc->getDbConnection('main');
		$user =& $this->getSessionUser();

		// TODO verificare quale informativa ha approvato
		
		// TODO con il pattern strategy o template method, selezionare il giusto modo di cancellare l'utente
		// si potrebbe modificare il db associando il nome della strategia all'informativa corrispondente, così con una query sappiamo sia qual'è l'ultima informativa, sia quale classe richiamare 
		
		// TODO effettuare la cancellazione

		
//		//if(!$user->isAdmin())
//		//	Error::throwError(_ERROR_DEFAULT,array('msg'=>'La modifica della password non pu? essere eseguita da utenti con livello ospite.'."\n".'La sessione potrebbe essere scaduta, eseguire il login','file'=>__FILE__,'line'=>__LINE__));
//		
//		$res =& $db->query('SELECT id_file, nome_file FROM file ORDER BY 1');
//		
//		while ( $res->fetchInto($row) )
//		{
//			$nome_file = $filePath.$row[0].'_'.$row[1];
//			if (file_exists($nome_file)) 
//			{
//				$query = 'UPDATE file SET hash_file=\''.md5_file($nome_file).'\' WHERE id_file = '.$row[0];
//				$res1 =& $db->query($query);
//				if (DB::isError($res1)) 
//					Error::throwError(_ERROR_CRITICAL,array('id_utente' => $user->getIdUser(), 'msg'=>DB::errorMessage($res1),'file'=>__FILE__,'line'=>__LINE__)); 
//			}
//			else  
//			{
//				echo $row[0].'_'.$row[1]."\n";
//				$query = 'UPDATE file SET hash_file=\'\' WHERE id_file = '.$row[0];
//				$res1 =& $db->query($query);
//				if (DB::isError($res1)) 
//					Error::throwError(_ERROR_CRITICAL,array('id_utente' => $user->getIdUser(), 'msg'=>DB::errorMessage($res1),'file'=>__FILE__,'line'=>__LINE__)); 
//			}
//		}
//		
//		$res->free();
		
	}
}


class CancellazioneUtente
{
	// costruttore
	function CancellazioneUtenteAbstract() 
	{
		
	}
	
	// i figli devono fare l'override di questo metodo
	function cancellaUtente( $idUtente) 
	{ 
		// TODO da implementare nelle sottoclassi	
	}
	
	
	//factory method ?
	function getCancellazioneUtenteClass () 
	{
		// TODO restituire il giusto algoritmo di cancellazione 
	}
}


class Informativa1 extends CancellazioneUtenteAbstract
{
	// costruttore
	function Informativa1() 
	{
		
	}
	
	// i figli devono fare l'override di questo metodo
	function cancellaUtente( $idUtente) 
	{ 
		// TODO da implementare nelle sottoclassi	
	}
}

class Informativa2 extends CancellazioneUtenteAbstract
{
	// costruttore
	function Informativa2() 
	{
		
	}
	
	// i figli devono fare l'override di questo metodo
	function cancellaUtente( $idUtente) 
	{ 
		// TODO da implementare nelle sottoclassi	
	}
}
?>