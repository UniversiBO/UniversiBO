<?php  



define('NOTIFICA_ELIMINATA', 'S');
define('NOTIFICA_NOT_ELIMINATA', 'N');

define('NOTIFICA_URGENTE', 'S');
define('NOTIFICA_NOT_URGENTE', 'N');

/**
 *
 * NotificaItem class
 *
 * Rappresenta una singola Notifica.
 *
 * @package Notifica
 * @version 0.0.1
 * @author GNU/Mel <gnu.mel@gmail.com>
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class NotificaItem {

	/**
	 * @private
	 */
	var $titolo = '';

	/**
	 * @private
	 */
	var $messaggio = '';

	/**
	 * data e ora di inserimento
	 * @private
	 */
	var $timestamp = 0;

	/**
	 * @private
	 */
	var $urgente = false;

	/**
	 * @private
	 */
	var $id_notifica = 0;

	/**
	 * @private
	 */
	var $eliminata = false;

	/**
	 * @private
	 */
	var $destinatario = '';

	/**
	 * Crea un oggetto NotificaItem con i parametri passati
	 * 
	 *
	 * @param  int $id_notifica id della news
	 * @param  string $titolo titolo della news max 150 caratteri
	 * @param  string $messaggio corpo della news
	 * @param  int $timestamp timestamp dell'inserimento
	 * @param  boolean $urgente flag notizia urgente o meno
	 * @param  boolean $eliminata flag stato della news
	 * @return NewsItem
	 */

	function NotificaItem($id_notifica, $titolo, $messaggio, $dataIns, $urgente, $eliminata, $destinatario) {
		$this->id_notifica = $id_notifica;
		$this->titolo = $titolo;
		$this->messaggio = $messaggio;
		$this->timestamp = $dataIns;
		$this->urgente = $urgente;
		$this->eliminata = $eliminata;
		$this->destinatario = $destinatario;

	}

	/**
	 * 
	 * Recupera il titolo della notifica
	 *
	 * @return String 
	 */
	function getTitolo() {
		return $this->titolo;
	}

	/**
	 * Recupera il testo della notifica
	 *
	 * @return string 
	 */
	function getMessaggio() {
		return $this->messaggio;
	}

	function getProtollo 

	/**
	 * Recupera la data di inserimento della notifica
	 *
	 * @return int 
	 */
	function getDataIns() {
		return $this->timestamp;
	}

	/**
	 * Recupera l'urgenza della notifica
	 *
	 * @return boolean
	 */
	function isUrgente() {
		return $this->urgente;
	}


     /**
	 * Overwrite the Send function of the base class
	 * @abstract
	 * @return string template identifier if command uses template engine
	 */ 
	function Send()
	{
		Error::throw(_ERROR_CRITICAL,array('msg'=>'Il metodo execute del command deve essere ridefinito','file'=>__FILE__,'line'=>__LINE__) );
	}



	/**
		 * Recupera l'id della notifica
	 *
	 * @return int
	 */
	function getIdNotifica() {
		return $this->id_notifica;
	}

	/**
	 * Recupera il destinatario
	 *
	 * @return string
	 */
	function getDestinatario() {
		return $this->destinatario;
	}

	/**
	 * Recupera il protocollo
	 *
	 * @return string
	 */
	function getProtocollo() {
		return $this->destinatario;
	}

	/**
	 * Imposta il destinatario
	 *
	 * @param  string $destinatario destinatario della news max 150 caratteri
	 */
	function setDestinatario() {
		$this->destinatario = $destinatario;
	}

	/**
	 * Recupera lo stato della notifica
	 *
	 * @return boolean
	 */
	function isEliminata() {
		return $this->eliminata;
	}

	/**
	 * Imposta il titolo della notifica
	 *
	 * @param  string $titolo titolo della news max 150 caratteri
	 */
	function setTitolo($titolo) {
		$this->titolo = $titolo;
	}

	/**
	 * Imposta il testo della notifica
	 *
	 * @param  string $notifica corpo della news 
	 */
	function setMessaggio($notifica) {
		$this->messaggio = $messaggio;
	}

	/**
	 * Imposta la data di inserimento della notifica
	 *
	 * @param  int $dataIns timestamp del giorno di inserimento 
	 */
	function setDataIns($dataIns) {
		$this->timestamp = $timestamp;
	}

	/**
	 * Imposta l'urgenza della notifica
	 *
	 * @param  boolean $urgente flag notifica urgente o meno
	 */
	function setUrgente($urgente) {
		$this->urgente = $urgente;
	}

	/**
	* 
	* Imposta l'id della notifica
	*
	* @param  int $id_notifica id della news
	*/
	function setIdNotifica($id_notifica) {
		$this->id_notifica = $id_notifica;
	}

	/**
	 * 
	 * Imposta lo stato della notifica
	 *
	 * @param  boolean $eliminata flag stato della news
	 */
	function setEliminata($eliminata) {
		$this->eliminata = $eliminata;
	}

	/**
	 * Recupera una notifica dal database
	 *
	 * @static
	 * @param int $id_notifica  id della news
	 * @return NewsItem 
	 */
	function & selectNotifica($id_notifica) {
		$id_notizie = array ($id_notifica);
		$notifica = & NotificaItem :: selectNotifiche($id_notizie);
		if ($notifica === false)
			return false;
		return $notifica[0];
	}

	/**
	 * Recupera un elenco di notizie dal database
	 *
	 * @static
	 * @param array $id_notifiche array elenco di id della news
	 * @return array NotificaItems 
	 */
	function & selectNotifiche($id_notifiche) {
		//var_dump($id_notifiche);
		$db = & FrontController :: getDbConnection('main');

		if (count($id_notifiche) == 0)
			return array ();

		//esegue $db->quote() su ogni elemento dell'array
		//array_walk($id_notifiche, array($db, 'quote'));

		if (count($id_notifiche) == 1)
			$values = $id_notifiche[0];
		else
			$values = implode(',', $id_notifiche);
		//function NotificaItem($id_notifica, $titolo, $messaggio, $dataIns, $urgente, $eliminata, $destinatario)
		$query = 'SELECT id_notifica, titolo, messaggio, timestamp, urgente, eliminata, destinatario FROM notifica WHERE id_notifica in ('.$values.') AND eliminata!='.$db->quote(NOTIFICA_ELIMINATA);
		//var_dump($query);
		$res = & $db->query($query);

		if (DB :: isError($res))
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));

		$rows = $res->numRows();

		if ($rows == 0)
			return false;
		$notifiche_list = array ();

		while ($res->fetchInto($row)) {
			$notifiche_list[] = & new NotificaItem($row[0], $row[1], $row[2], $row[3], ($row[4] == NOTIFICA_URGENTE), ($row[5] == NOTIFICA_ELIMINATA), $row[6]);
		}

		$res->free();

		return $notifiche_list;
	}

	/**
	* Inserisce una notifica sul DB
	*
	* @param	 array 	$array_id_canali 	elenco dei canali in cui bisogna inserire la notifica. Se non si passa un canale si recupera quello corrente.
	* @return	 boolean true se avvenua con successo, altrimenti Error object
	*/

	function insertNotificaItem() {
		$db = & FrontController :: getDbConnection('main');

		ignore_user_abort(1);
		$db->autoCommit(false);
		$next_id = $db->nextID('notifica_id_notifica');
		$return = true;
		$eliminata = ($this->isEliminata()) ? NOTIFICA_ELIMINATA : NOTIFICA_NOT_ELIMINATA;
		$urgente = ($this->isUrgente()) ? NOTIFICA_URGENTE : NOTIFICA_NOT_URGENTE;
		//id_notifica urgente messaggio titolo timestamp destinatario eliminata

		$query = 'INSERT INTO news (id_notifica, urgente, messaggio, titolo, timestamp, destinatario, eliminata) VALUES '.'( '.$next_id.' , '.$db->quote($flag_urgente).' , '.$db->quote($this->getMessaggio()).' , '.$db->quote($this->getTitolo()).' , '.$db->quote($this->getDataIns()).' , '.$db->quote($this->getMessaggio()).' , '.$db->quote($eliminata).' ) ';
		$res = $db->query($query);
		//var_dump($query);
		if (DB :: isError($res)) {
			$db->rollback();
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));
		}

		$this->setIdNotizia($next_id);

		$db->commit();
		$db->autoCommit(true);
		ignore_user_abort(0);
	}

	/**
	 * Aggiorna le modifiche alla notifica nel DB
	 *
	 * @return boolean true se avviene con successo, altrimenti Error object
	 */
	function updateNotifica() {
		$db = & FrontController :: getDbConnection('main');

		ignore_user_abort(1);
		$db->autoCommit(false);
		$return = true;

		$urgente = ($this->isUrgente()) ? NOTIFICA_URGENTE : NOTIFICA_NOT_URGENTE;
		$eliminata = ($this->isEliminata()) ? NOTIFICA_ELIMINATA : NOTIFICA_NOT_ELIMINATA;
		$query = 'UPDATE notifica SET titolo = '.$db->quote($this->getTitolo()).' , timestamp = '.$db->quote($this->getDataIns()).' , messaggio = '.$db->quote($this->getMessaggio()).' , eliminata = '.$db->quote($eliminata).' , urgente = '.$db->quote($urgente).' , messaggio = '.$db->quote($this->getMessaggio()).' WHERE id_notifica = '.$db->quote($this->getIdNotizia());
		//echo $query;								 
		$res = $db->query($query);
		//var_dump($query);
		if (DB :: isError($res)) {
			$db->rollback();
			Error :: throw (_ERROR_CRITICAL, array ('msg' => DB :: errorMessage($res), 'file' => __FILE__, 'line' => __LINE__));
		}

		$db->commit();
		$db->autoCommit(true);
		ignore_user_abort(0);
	}

	/**
	 * La funzione deleteNotificaItem controlla se la notifica é stata eliminata da tutti i canali in cui era presente, e aggiorna il db
	 */
	function deleteNotifica() {
		$this->eliminata = true;
		$this->updateNotificaItem();
	}

	/**
	 * La funzione deleteNotificaItem controlla se la notifica é stata eliminata da tutti i canali in cui era presente, e aggiorna il db
	 *
	 * @return NotificaItem costruttore stile factory.
	 */
	function &factoryNotifica($id_notifica)	{
		return NotificaItem::selectNotifica($id_notifica);
	}
	
	/**
	 * La funzione retrieveNotifica recupera una notifica, e restituisce il giusto oggetto notifica creandolo dinamicamente.
	 *
	 * @return NotificaItem Oggetto sottoclasse di NotificaItem.
	 */
	function &retrieveNotifica($id,$fc) { 
		$not=selectNotifica($id);
		$strarr=explode('://',this->getDestinatario());
		
		$p = ucfirst(strtolower($strarr[0]));
		$not->setDestinatario($strarr[1]); //ocio che non sia un destinatario di piu' parole. Ha senso?
		
		$className = 'Notifica'.$p;
		
		require_once($className.PHP_EXTENSION);
		return call_user_func(array($class_name,'factoryNotifica'), $id, $fc);
		
	
	}

		
	
}

?>