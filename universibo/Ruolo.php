<?php

include_once('User'.PHP_EXTENSION);
include_once('Canale'.PHP_EXTENSION);

define('RUOLO_NONE'        ,0);
define('RUOLO_MODERATORE'  ,1);
define('RUOLO_REFERENTE'   ,2);

define('NOTIFICA_NONE'   ,0);
define('NOTIFICA_URGENT' ,1);
define('NOTIFICA_ALL'    ,2);


/**
 * Classe Ruolo, contiene informazioni relative alle proprietà che legano uno User ad un Canale
 *
 * Contiene le informazioni che legano un utente ad un canale, 
 * i diritti di accesso (moderatore, referente, ecc...)
 * l'istante dell'ultimo accesso, l'inserimento o meno tra i bookmark/preferiti/my_universibo
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @copyright CopyLeft UniversiBO 2001-2003
 */



class Ruolo {

	/**
	 * @access private
	 */
	var $id_utente = 0; 
	/**
	 * @access private
	 */
	var $id_canale = 0;
	/**
	 * @access private
	 */
	var $user = NULL; //riferimento all'oggetto canale
	/**
	 * @access private
	 */
	var $canale = NULL;  //riferimento all'oggetto user

	/**
	 * @access private
	 */
	var $nome = '';
	/**
	 * @access private
	 */
	var $ultimoAccesso = 0; 
	/**
	 * @access private
	 */
	var $tipoNotifica = '';

	/**
	 * @access private
	 */
	var $myUniversibo = true; 
	/**
	 * @access private
	 */
	var $moderatore = false; 
	/**
	 * @access private
	 */
	var $referente = false; 

	
	
	/**
	 * Crea un oggetto Ruolo
	 *
	 * @see selectRuolo
	 * @param int		$id_utente		numero identificativo utente
	 * @param int		$id_canale		numero identificativo canale
	 * @param string	$nome nome		identificativo del ruolo (stringa personalizzata dall'utente per identificare il canale)
	 * @param int		$ultimo_acceso	timestamp dell'ultimo accesso al canale da parete dell'utente
	 * @param boolean	$moderatore		true se l'utente possiede diritti di moderatore sul canale
	 * @param boolean	$referente		true se l'utente possiede diritti di referente sul canale
	 * @param boolean	$my_universibo	true se l'utente ha inserito il canale tra i suoi preferiti
	 * @param User 		$user			riferimento all'oggetto User
	 * @param Canale 	$canale			riferimento all'oggetto Canale
	 * @return Ruolo
	 */
	
	function Ruolo($id_utente, $id_canale, $nome, $ulitmo_accesso, $moderatore, $referente, $my_universibo, $notifica, $user=NULL, $canale=NULL)
	{
		$this->id_utente = $id_utente; 
		$this->id_canale = $id_canale;
		$this->user =& $user; //riferimento all'oggetto canale
		$this->canale =& $canale;  //riferimento all'oggetto user

		$this->ultimoAccesso = $ulitmo_accesso; 
		$this->tipoNotifica = $notifica;
		$this->nome = $nome;

		$this->myUniversibo = $my_universibo; 
		$this->moderatore = $moderatore; 
		$this->referente = $referente; 
		
	}
	
	
	
	/**
	 * Ritorna l'ID dello User nel database
	 *
	 * @return int
	 */
	function getIdUser()
	{
		return $this->id_utente;
	}



	/**
	 * Ritorna l'ID del canale nel database
	 *
	 * @return int
	 */
	function getIdCanale()
	{
		return $this->id_canale;
	}



	/**
	 * Restituisce l'oggetto User collegato al ruolo
	 *
	 * @return User
	 */
	function &getUser()
	{
		if ($this->user == NULL)
		{
			$this->user =& User::selectUser($this->getIdUser());
		}
		return $this->user;
	}


	
	/**
	 * Restituisce l'oggetto Canale collegato al ruolo
	 *
	 * @return Canale
	 */
	function &getCanale()
	{
		if ($this->user == NULL)
		{
			$this->user =& User::selectCanale($this->getIdCanale());
		}
		return $this->user;
	}


	
	/**
	 * Restituisce il nome del canale corrente specificato dal'utente
	 *
	 * @return int livello di notifica
	 */
	function getNome()
	{
		return $this->tipoNotifica;
	}


	
	/**
	 * Imposta il nome del canale corrente specificato dal'utente
	 *
	 * @param string $nome nome del canale corrente specificato dal'utente
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean true se avvenuta con successo
	 */
	function updateNome($nome, $updateDB = false)
	{
		$this->nome = $nome;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$query = 'UPDATE utente_canale SET nome = '.$db->quote($nome).' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}



	/**
	 * Ritorna l'ultimo accesso dell'utente al canale
	 *
	 * @return int timestamp dell'ultimo accesso 
	 */
	function getUltimoAccesso()
	{
		return $this->ultimoAccesso;
	}


	
	/**
	 * Imposta l'ultimo accesso dell'utente al canale
	 *
	 * @param int $ultimo_accesso timestamp dell'ultimo accesso 
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean true se avvenuta con successo
	 */
	function updateUltimoAccesso($ultimo_accesso, $updateDB = false)
	{
		$this->ultimoAccesso = $ultimo_accesso;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$query = 'UPDATE utente_canale SET ultimo_accesso = '.$db->quote($ultimo_accesso).' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}

		return true;
	}



	/**
	 * restituisce il livello di notifica dell'utente nel canale corrente
	 * define('NOTIFICA_NONE'   ,0);
	 * define('NOTIFICA_URGENT' ,1);
	 * define('NOTIFICA_ALL'    ,2);
	 *
	 * @return int livello di notifica
	 */
	function getTipoNotifica()
	{
		return $this->tipoNotifica;
	}


	
	/**
	 * Imposta il livello di notifica dell'utente nel canale corrente
	 * define('NOTIFICA_NONE'   ,0);
	 * define('NOTIFICA_URGENT' ,1);
	 * define('NOTIFICA_ALL'    ,2);
	 *
	 * @param int $tipo_notifica livello di notifica
	 * @param boolean $updateDB se true la modifica viene propagata al DB 
	 * @return boolean true se avvenuta con successo
	 */
	function updateTipoNotifica($tipo_notifica, $updateDB = false)
	{
		$this->tipoNotifica = $tipo_notifica;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$query = 'UPDATE utente_canale SET tipo_notifica = '.$db->quote($tipo_notifica).' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}


	
	/**
	 * Verifica se nel ruolo corrente l'utente è moderatore del cananle
	 *
	 * @return boolean	true se è moderatore, viceversa false
	 */
	function isModeratore()
	{
		return $this->moderatore;
	}


	
	/**
	 * Imposta i diritti di moderatore nel ruolo
	 *
	 * @param	boolean	$moderatore livello di notifica
	 * @param	boolean	$updateDB se true la modifica viene propagata al DB 
	 * @return	boolean	true se avvenuta con successo
	 */
	function updateSetModeratore($moderatore, $updateDB = false)
	{
		$this->moderatore = $moderatore;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$campo_ruolo = ($moderatore) ? RUOLO_MODERATORE : 0 + ($this->isReferente()) ? RUOLO_REFERENTE : 0; 
			$query = 'UPDATE utente_canale SET ruolo = '.$campo_ruolo.' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}


	
	/**
	 * Verifica se nel ruolo corrente l'utente è referente del canale
	 *
	 * @return boolean	true se è referente, viceversa false
	 */
	function isReferente()
	{
		return $this->referente;
	}


	
	/**
	 * Imposta i diritti di referente nel ruolo
	 *
	 * @param	boolean	$referente livello di notifica
	 * @param	boolean	$updateDB se true la modifica viene propagata al DB 
	 * @return	boolean	true se avvenuta con successo
	 */
	function updateSetReferente($referente, $updateDB = false)
	{
		$this->referente = $referente;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$campo_ruolo = ($this->isModeratore()) ? RUOLO_MODERATORE : 0 + ($referente) ? RUOLO_REFERENTE : 0; 
			$query = 'UPDATE utente_canale SET ruolo = '.$campo_ruolo.' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}


	
	/**
	 * Verifica se nel ruolo corrente l'utente è tra i canali scelti dall'utente
	 *
	 * @return boolean	true se è referente, viceversa false
	 */
	function isMyUniversibo()
	{
		return $this->myUniversibo;
	}


	
	/**
	 * Aggiunge il canale 
	 *
	 * @param	boolean	$referente livello di notifica
	 * @param	boolean	$updateDB se true la modifica viene propagata al DB 
	 * @return	boolean	true se avvenuta con successo
	 */
	function updateAddMyUniversibo($updateDB = false)
	{
		$this->_updateMyUniversibo(true, $updateDB);
	}


	
	/**
	 * Imposta la selezione preferiti MyUniversibo relativo all'utente (che spiegazione del cavolo)
	 *
	 * @param	boolean	$my_universibo livello di notifica
	 * @param	boolean	$updateDB se true la modifica viene propagata al DB 
	 * @return	boolean	true se avvenuta con successo
	 */
	function updateSetMyUniversibo($my_universibo, $updateDB = false)
	{
		$this->myUniversibo = $my_universibo;
		
		if ( $updateDB == true )
		{
			$db =& FrontController::getDbConnection('main');
		
			$my_universibo = ($my_universibo) ? 'S' : 'N';
			
			$query = 'UPDATE utente_canale SET my_universibo = '.$campo_ruolo.' WHERE id_utente = '.$db->quote($this->getIdUser()).' AND id_canale = '.$db->quote($this->getIdCanale());
			$res = $db->query($query);
			if (DB::isError($res)) 
				Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
			$rows = $res->affectedRows();
		
			if( $rows == 1) return true;
			elseif( $rows == 0) return false;
			else Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
			return false;
		}
		
		return true;
	}



	/**
	 * Verifica se un ruolo esiste nel database
	 *
	 * @static
	 * @param int		$id_utente		numero identificativo utente
	 * @param int		$id_canale		numero identificativo canale
	 * @return boolean	false se il ruolo non esiste
	 */
	function ruoloExists($id_utente, $id_canale)
	{
		$query = 'SELECT id_utente, id_canale FROM utente_argomento WHERE id_utente = '.$db->quote($id_utente).' AND id_canale= '.$db->quote($id_canale);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		$rows = $res->numRows();
		if( $rows >= 1)
		{
			return false;
		}
		return true;
	}
	


	/**
	 * Preleva un ruolo da database
	 *
	 * @static
	 * @param int		$id_utente		numero identificativo utente
	 * @param int		$id_canale		numero identificativo canale
	 * @return Ruolo 	false se il ruolo non esiste
	 */
	function &selectRuolo($id_utente, $id_canale)
	{
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ultimo_accesso, ruolo, my_universibo, notifica, nome FROM utente_argomento WHERE id_utente = '.$db->quote($id_utente).' AND id_canale= '.$db->quote($id_canale);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows > 1) Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
		if( $rows = 0) return false;

		$res->fetchInto($row);
		$ruolo =& new Ruolo($id_utente, $id_canale, $row[4], $row[0], $row[1]==RUOLO_MODERATORE, $row[1]==RUOLO_REFERENTE, $row[2]=='S', $row[3]);
		return $ruolo;
		
	}


	/**
	 * Preleva tutti i ruoli di un utente da database
	 *
	 * @static
	 * @param int		$id_utente		numero identificativo utente
	 * @return mixed    array di oggetti Ruolo, false se non esistono ruoli
	 */
	function &selectUserRuoli($id_utente)
	{
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ultimo_accesso, ruolo, my_universibo, notifica, nome FROM utente_argomento WHERE id_utente = '.$db->quote($id_utente);
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows = 0) return false;

		while (	$res->fetchInto($row) )
		{
			$ruoli[] =& new Ruolo($id_utente, $id_canale, $row[4], $row[0], $row[1]==RUOLO_MODERATORE, $row[1]==RUOLO_REFERENTE, $row[2]=='S', $row[3]);
		}
		return $ruoli;
		
	}


	function updateRuolo()
	{
		
	}



	/**
	 * Inserisce un ruolo nel database, se il ruolo esiste già ritorna false
	 *
	 * @return boolean true se avvenua con successo, altrimenti false e throws Error object
	 */
	function insertRuolo()
	{
		$db =& FrontController::getDbConnection('main');
		
		$campo_ruolo = ($this->isModeratore()) ? RUOLO_MODERATORE : 0 + ($this->isReferente()) ? RUOLO_REFERENTE : 0; 
		$my_universibo = ($this->myUniversibo()) ? 'S' : 'N'; 
		
		$query = 'INSERT INTO utente_canale(id_utente, id_canale, ultimo_accesso, ruolo, my_universibo, notifica, nome) VALUES '.
					'( '.$db->quote($this->id_utente).' , '.
					$db->quote($this->id_canale).' , '.
					$db->quote($this->ultimoAccesso).' , '.
					$db->quote($campo_ruolo).' , '.
					$db->quote($my_universibo).' , '.
					$db->quote($this->getTipoNotifica()).' , '.
					$db->quote($this->getNome()).' )';

		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		return true;
		
	}


	/**
	 * Inserisce un ruolo nel database, se il ruolo esiste già ritorna false
	 *
	 * @return boolean true se avvenua con successo, altrimenti false e throws Error object
	 */
	function insertfdesRuolo()
	{
		$db =& FrontController::getDbConnection('main');
		
		$campo_ruolo = ($this->isModeratore()) ? RUOLO_MODERATORE : 0 + ($this->isReferente()) ? RUOLO_REFERENTE : 0; 
		$my_universibo = ($this->myUniversibo()) ? 'S' : 'N'; 
		
		$query = 'INSERT INTO utente_canale(id_utente, id_canale, ultimo_accesso, ruolo, my_universibo, notifica, nome) VALUES '.
					'( '.$db->quote($this->getIdUtente).' , '.
					$db->quote($this->getIdCanale).' , '.
					$db->quote($this->getUltimoAccesso).' , '.
					$db->quote($campo_ruolo).' , '.
					$db->quote($my_universibo).' , '.
					$db->quote($this->getTipoNotifica()).' , '.
					$db->quote($this->getNome()).' )';

		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		return true;
		
	}

	function deleteRuolo()
	{
		$db =& FrontController::getDbConnection('main');
		
		$query = 'DELETE FROM utente_canale WHERE id_utente = '.$db->quote($this->getIdUtente()).' AND id_cananle = '.$db->quote($this->getIdCanale());
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		return true;
	}
    
}

?>