<?php

require_once('Canale'.PHP_EXTENSION);
require_once('PrgAttivitaDidattica'.PHP_EXTENSION);

/**
 * Insegnamento class.
 *
 * Modella un insegnamento e le informazioni associate.
 * Ad un insegnamento possono essere associate da 1 a n attività didattiche (PrgAttivitaDidattica).
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */

class Insegnamento extends Canale
{
	
	/**
	 * @private
	 * per il caching del nome dell'insegnamento
	 */
	var $insegnamentoNome = NULL;
	
	/**
	 * @private
	 * per il caching del nome dell'insegnamento
	 */
	var $insegnamentoTitle = NULL;
	
	/**
	 * @private
	 * per il caching di tutte le attività collegate a questo insegnamento
	 */
	var $elencoAttivita = NULL;
	
	/**
	 * @private
	 * per il caching di tutte le attività collegate a questo insegnamento
	 */
	var $elencoAttivitaPadre = NULL;
	
	/**
	 * Crea un oggetto Insegnamento 
	 *
	 * @param int $id_canale 		identificativo del canale su database
	 * @param int $permessi 		privilegi di accesso gruppi {@see User}
	 * @param int $ultima_modifica 	timestamp 
	 * @param int $tipo_canale 	 	vedi definizione dei tipi sopra
	 * @param string  $immagine		uri dell'immagine relativo alla cartella del template
	 * @param string $nome			nome del canale
	 * @param int $visite			numero visite effettuate sul canale
	 * @param boolean $news_attivo	se true il servizio notizie è attivo
	 * @param boolean $files_attivo	se true il servizio false è attivo
	 * @param boolean $forum_attivo	se true il servizio forum è attivo
	 * @param int $forum_forum_id	se forum_attivo è true indica l'identificativo del forum su database
	 * @param int $forum_group_id	se forum_attivo è true indica l'identificativo del grupop moderatori del forum su database
	 * @param boolean $links_attivo se true il servizio links è attivo
	 * @param string $cod_facolta	codice identificativo d'ateneo della facoltà a 4 cifre 
	 * @param string $nome_facolta	descrizione del nome della facoltà
	 * @param string $uri_facolta	link al sito internet ufficiale della facoltà
	 * @return Insegnamento
	 */
	function Insegnamento($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo, $elenco_attivita)
	{
	
		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
		
		//inizializza l'elenco delle attività padre/non sdoppiate
		$this->elencoAttivita =& $elenco_attivita;
		$num = count($elenco_attivita);
		for ($i = 0; $i < $num; $i++)
		{
			if ($elenco_attivita[$i]->isSdoppiato() == false)
			{
				$this->elencoAttivitaPadre[] =& $elenco_attivita[$i];
			}
		}
		
		$num = count($this->elencoAttivitaPadre);
		//inizializza il nome dell'esame
		if ( $num == 1 )
		{
			$att = $this->elencoAttivitaPadre[0];
			$cod_ril = ($att->getTranslatedCodRil() == '') ? '' : ' '.$att->getTranslatedCodRil();
			$this->insegnamentoNome = $att->getNomeMateriaIns().$cod_ril.' - '.$att->getNomeDoc();
		}
		else
		{
			// CHE CASINOOOOO!!!!!
			
			$nomi    = array();
			$t_nomi  = array();
			$anni    = array();
			$docenti = array();
			$cod_ril = array();
			
			$app_elenco_attivita = array();
			$num_att = count($this->elencoAttivitaPadre);
			for ($i = 0; $i < $num_att; $i++)
			{
				$app_elenco_attivita[$i] =& $this->elencoAttivitaPadre;
				$nomi[$i]    = $app_elenco_attivita[$i]->getNomeMateriaIns();
				$t_nomi[$i]  = substr($nomi[$i], 0, -3);    //nome materia meno le ultime 3 lettere
				$anni[$i]    = $app_elenco_attivita[$i]->getAnnoAccademico();
				$docenti[$i] = $app_elenco_attivita[$i]->getNomeDoc();
				$cod_ril[$i] = $app_elenco_attivita[$i]->getCodRil();
			}
			
			
			
		}
		
		
		
	}
	
	
	
	/**
	 * Crea un oggetto Insegnamento dato il suo numero identificativo id_canale
	 * Ridefinisce il factory method della classe padre per restituire un oggetto
	 * del tipo Insegnamento
	 *
	 * @static
	 * @param int $id_canale numero identificativo del canale
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &factoryCanale($id_canale)
	{
		return Insegnamento::selectInsegnamentoCanale($id_canale);
	}
	
	
	/**
	 * Restituisce il nome dell'insegnamento:
	 * Se è impostato un nome del canale nella tabella canale lo restituisce
	 * Altrimenti se l'Insegnamento è composta da una sola PrgAttivitaDidattica padre ne restituisce il nome
	 * Altrimenti se è composto da più PrgAttivitaDidattica che differiscono per le ultime 3 lettere 
	 *   restituisce NOME_MATERIA PRI+SEC RIL AA
	 * Se è composto da più entità di cui al punto precedente di anni accademici differenti
	 *   restituisce {NOME} AA1/AA2
	 *
	 * @return string
	 */
	function getNome()
	{
		if ($this->isNomeSet()) return parent::getNome();
		return $this->insegnamentoNome;
	}
	
	
	
	/**
	 * Restituisce il titolo/nome completo dell'insegnamento
	 *
	 * @return string
	 */
	function getTitolo()
	{
		return "INSEGNAMENTO DI \n".$this->getNome();
	}
	
	
	/**
	 * Restituisce un array con chiavi numeriche 
	 * di oggetti PrgAttivitaDidattica corrispondenti a questo Insegnamento
	 *
	 * @return string
	 */
	function getElencoAttivita()
	{
		return $this->elencoAttivita;
	}


	/**
	 * Restituisce un array con chiavi numeriche 
	 * di oggetti PrgAttivitaDidattica NON SDOPPIATE / PADRE 
	 * corrispondenti a questo Insegnamento
	 *
	 * @return string
	 */
	function getElencoAttivitaPadre()
	{
		return $this->elencoAttivitaPadre;
	}


	/**
	 * Seleziona da database e restituisce l'oggetto Insegnamento
	 * corrispondente al codice id_canale 
	 * 
	 * @static
	 * @param int $id_canale identificativo su DB del canale corrispondente al corso di laurea
	 * @return mixed Insegnamento se eseguita con successo, false se il canale non esiste
	 */
	function &selectInsegnamentoCanale($id_canale)
	{
	
		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT tipo_canale, nome_canale, immagine, visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, id_forum, group_id, links_attivo, id_canale FROM canale WHERE id_canale = '.$db->quote($id_canale).';';
		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_CRITICAL,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();
		$res->fetchInto($row);
		$res->free();
		
		if( $rows > 1) Error::throw(_ERROR_CRITICAL,array('msg'=>'Errore generale database: canale insegnamento non unico','file'=>__FILE__,'line'=>__LINE__));
		if( $rows = 0) return false;
		
		$elenco_attivita =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaCanale($id_canale);
		
		$insegnamento =& new Insegnamento($row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
						 $row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S', $elenco_attivita);
		
		return $insegnamento;

	}
	
	
	
	/*
	 * Seleziona da database e restituisce l'oggetto Cdl 
	 * corrispondente al codice $cod_cdl 
	 * 
	 * @todo implementare se serve
	 * @static
	 * @param string $cod_cdl stringa a 4 cifre del codice d'ateneo del corso di laurea
	 * @return Facolta
	 *
	function &selectInsegnamentoCodice( ...tutta la chiave... )
	{

		$db =& FrontController::getDbConnection('main');
	
		$query = 'SELECT ... WHERE a.id_canale = b.id_canale AND b.cod_corso = '.$db->quote($cod_cdl);

		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
	
		$rows = $res->numRows();

		if( $rows == 0) return false;

		$res->fetchInto($row);
		$insegnamento =& new Insegnamento(  ... $row[16] ...  );
		
		return $insegnamento;

	}
	*/
	
}
?>