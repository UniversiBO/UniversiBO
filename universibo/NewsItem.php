<?php

/**
 *
 * NewsItem class
 *
 * Rappresenta una singola news.
 *
 * @package universibo
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 *
 *
 */
 
 
class NewsItem {
	
	
	/**
	 * @private
	 */
	var $titolo='';
	
	
	/**
	 * @private
	 */ 
	var $notizia='';
	 
	/**
	 * @private
	 */
	
	var $id_utente=0; 
	/**
	 * @private
	 */
	
	var $dataIns=0;
	
	/**
	 * @private
	 */
	
	var $oraIns=0;
	
	/**
	 * @private
	 */
	
	var $scadenza=false;
	
	/**
	 * @private
	 */
	
	var $dataScadenza=0;
	
	/**
	 * @private
	 */	 
	
	var $oraScadenza=0;
	
	/**
	 * @private
	 */
	 
	var $urgente=false; 
	
	/**
	 * @private
	 */
	
	var $id_notizia=0; 
	 
	/**
	 * @private
	 */
	
	var $eliminata=false; 
	
	/**
	 * @private
	 */
	
	var $elencoContatti=NULL; 
	
	/**
	 * Crea un oggetto NewsItem
	 * 
	 *
	 * @see 
	 * @param 
	 * @return 
	 */
	 
	 function NewsItem($id_notizia, $titolo, $notizia, $dataIns, $oraIns, $scadenza, $dataScadenza, $oraScadenza, $urgente, $eliminata, $id_utente){
	 	
	 	$this->id_notizia=$id_notizia;
	 	$this->titolo=$titolo;
	 	$this->notizia=$notizia;
	 	$this->dataIns=$dataIns;
	 	$this->oraIns=$oraIns;
	 	$this->scadenza=$scadenza;
	 	$this->dataScadenza=$dataScadenza;
	 	$this->oraScadenza=$oraScadenza;
	 	$this->urgente=$urgente;
	 	$this->eliminata=$eliminata;
	 	$this->id_utente=$id_utente;
	 	
	 
	 }
	 
	 /**
	 * 
	 * Recupera le informazioni della notizia
	 *
	 * @static
	 * @return NewsItem 
	 */
	 
	 function selectNewsItem (){
	 	
	 }
	 
	 /**
	 * 
	 * Recupera il titolo della notizia
	 *
	 * @return String 
	 */
	 
	 function getTitolo(){
	 	return $this->titolo;
	 }
	 
	 /**
	 * 
	 * Recupera il testo della notizia
	 *
	 * @return String 
	 */
	 
	 function getNotizia(){
	 	return $this->notizia;
	 }
	 
	 /**
	 * 
	 * Recupera l'id_utente dell'autore della notizia
	 *
	 * @return int 
	 */
	 
	 function getId_utente() {
	 	return $this->id_utente;
	 }
	 
	 /**
	 * 
	 * Recupera la data di inserimento della notizia
	 *
	 * @return int 
	 */
	 
	 function getDataIns() {
	 	return $this->dataIns;
	 }
	 
	 /**
	 * 
	 * Recupera l'ora di inserimento della notizia
	 *
	 * @return int 
	 */
	 
	 function getOraIns() {
	 	return $this->oraIns;
	 }
	 
	 /**
	 * 
	 * Recupera l'attivazione della scadenza della notizia
	 *
	 * @return boolean 
	 */
	 
	 function getScadenza(){
	 	return $this->scadenza;
	 }
	 
	 /**
	 * 
	 * Recupera l'ora di scadenza della notizia
	 *
	 * @return int
	 */
	 
	 function getOraScadenza() {
	 	return $this->oraScadenza;
	 }
	 
	 /**
	 * 
	 * Recupera la data di scadenza della notizia
	 *
	 * @return int
	 */
	 
	 function getDataScadenza() {
	 	return $this->dataScadenza;
	 }
	 
	 /**
	 * 
	 * Recupera l'urgenza della notizia
	 *
	 * @return boolean
	 */
	 
	 function getUrgente(){
	 	return $this->urgente;
	 }
	 
	 /**
	 * 
	 * Recupera l'id della notizia
	 *
	 * @return int
	 */
	 
	 function getId_notizia() {
	 	return $this->id_notizia;
	 }
	 
	 /**
	 * 
	 * Recupera lo stato della notizia
	 *
	 * @return boolean
	 */
	 
	 function getEliminata() {
	 	return $this->eliminata;
	 }
	 
	 /**
	 * 
	 * Recupera l'array dei canali della notizia
	 *
	 * @return array
	 */
	 
	 function getElencoContatti() {
	 	if ($this->elencoContatti == NULL) return $this->elencoContatti; 
	 }
	 
	 
		 
	 /**
	 * 
	 * Imposta il titolo della notizia
	 *
	 *  
	 */
	 
	 function setTitolo($titolo){
	 	$this->titolo=$titolo;
	 }
	 
	 /**
	 * 
	 * Imposta il testo della notizia
	 *
	 *  
	 */
	 
	 function setNotizia($notizia){
	 	$this->notizia=$notizia;
	 }
	 
	 /**
	 * 
	 * Imposta l'id_utente dell'autore della notizia
	 *
	 *  
	 */
	 
	 function setId_utente($id_utente) {
	 	$this->id_utente=$id_utente;
	 }
	 
	 /**
	 * 
	 * Imposta la data di inserimento della notizia
	 *
	 *  
	 */
	 
	 function setDataIns($dataIns) {
	 	$this->dataIns=$dataIns;
	 }
	 
	 /**
	 * 
	 * Imposta l'ora di inserimento della notizia
	 *
	 *  
	 */
	 
	 function setOraIns($oraIns) {
	 	$this->oraIns=$oraIns;
	 }
	 
	 /**
	 * 
	 * Imposta l'attivazione della scadenza della notizia
	 *
	 *  
	 */
	 
	 function setScadenza(scadenza){
	 	$this->scadenza=$scadenza;
	 }
	 
	 /**
	 * 
	 * Imposta l'ora di scadenza della notizia
	 *
	 *  
	 */
	 
	 function setOraScadenza($oraScadenza) {
	 	$this->oraScadenza=$oraScadenza;
	 }
	 
	 /**
	 * 
	 * Imposta la data di scadenza della notizia
	 *
	 *  
	 */
	 
	 function setDataScadenza(dataScadenza) {
	 	$this->dataScadenza=$dataScadenza;
	 }
	 
	 /**
	 * 
	 * Imposta l'urgenza della notizia
	 *
	 * 
	 */
	 
	 function setUrgente($urgente){
	 	$this->urgente=$urgente;
	 }
	 
	 /**
	 * 
	 * Imposta l'id della notizia
	 *
	 *  
	 */
	 
	 function setId_notizia($id_notizia) {
	 	$this->id_notizia=$id_notizia;
	 }
	 
	 /**
	 * 
	 * Imposta lo stato della notizia
	 *
	 * 
	 */
	 
	 function setEliminata($eliminata) {
	 	$this->eliminata=$eliminata;
	 }
	 
	 /**
	 * 
	 * Imposta l'array dei canali della notizia
	 *
	 *  
	 */
	 	 
	 function setElencoContatti($elencoContatti) {
	 	if ($this->elencoContatti == NULL) $this->elencoContatti=$elencoContatti; 
	 }
	 
	 /**
	 *
	 * Verifica se la notizia è scaduta
	 *
	 * @return boolean
	 */
	 
	 function isScaduta() {
	 	return $this->eliminata;
	 }
	 
	 /**
	 *
	 * Seleziona i canali per i quali la notizia è inerente 
	 *
	 * @param int		$id_canale		identificativo del canale
	 * @return array	elencoArray		elenco dei canali
	 */
	 
	 //non mi ricordo più che deve fare questa funz!!!
	 // cosa deve restituire? array o NewsItem?  
	 function &selectNotiziaCanale($id_canale) {
	 	
	 	$db =& FrontController::getDbConnection('main');
	
		$query = '' AND id_canale= '.$db->quote($id_canale);
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		if( $rows > 1) Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: ruolo non unico','file'=>__FILE__,'line'=>__LINE__));
		if( $rows = 0) return false;

		$res->fetchInto($row);
		$boooohhhh =& new boooohhh($id_utente, $id_canale, $row[4], $row[0], $row[1]==RUOLO_MODERATORE, $row[1]==RUOLO_REFERENTE, $row[2]=='S', $row[3]);
		return $;	 
	 }
	 
} 
 
?>