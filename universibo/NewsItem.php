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
	 	$this->elencoContatti=NULL;
	 
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
	 
} 
 
?>