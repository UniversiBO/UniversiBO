<?php

require_once('Canale'.PHP_EXTENSION);

/**
 * PrgAttivitaDidattica class.
 *
 * Modella una attività didattica e le informazioni associate.
 * Ad un insegnamento possono essere associate da 1 a n attività didattiche
 * ma sia l'insegnamento che l'attività didattiche associate corrispondono 
 * allo stesso canale, enteambe le classi estendono Canale.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, @link http://www.opensource.org/licenses/gpl-license.php
 * @copyright CopyLeft UniversiBO 2001-2003
 */


class PrgAttivitaDidattica extends Canale{
	
		/**
		 * @private
		 */
		 var $annoAccademico;
	
		/**
		 * @private
		 */
		 var $codiceCdl; //(cod_corso)
			
		/**
		 * @private
		 */
		 var $codInd;
			
		/**
		 * @private
		 */
		 var $codOri;
			
		/**
		 * @private
		 */
		 var $codMateria;
			
		/**
		 * @private
		 */
		 var $nomeMateria;
			
		/**
		 * @private
		 */
		 var $annoCorso;
			
		/**
		 * @private
		 */
		 var $codMateriaIns;
			
		/**
		 * @private
		 */
		 var $nomeMateriaIns;
			
		/**
		 * @private
		 */
		 var $annoCorsoIns;
			
		/**
		 * @private
		 */
		 var $codRil;
			
		/**
		 * @private
		 */
		 var $codModulo;
			
		/**
		 * @private
		 */
		 var $codDoc;
			
		/**
		 * @private
		 */
		 var $nomeDoc;
			
		/**
		 * @private
		 */
		 var $flagTitolareModulo;
			
		/**
		 * @private
		 */
		 var $tipoCiclo;
			
		/**
		 * @private
		 */
		 var $codAte;

		/**
		 * @private
		 */
		 var $annoCorsoUniversibo;

		/**
		 * @private
		 */
		 var $sdoppiato;
		 

	/**
	 * Crea un oggetto PrgAttivitaDidattica
	 *
	 * @param int     $id_canale 		identificativo del canale su database
	 * @param int     $permessi 		privilegi di accesso gruppi {@see User}
	 * @param int     $ultima_modifica 	timestamp 
	 * @param int     $tipo_canale 	 	vedi definizione dei tipi sopra
	 * @param string  $immagine			uri dell'immagine relativo alla cartella del template
	 * @param string  $nome				nome del canale
	 * @param int     $visite			numero visite effettuate sul canale
	 * @param boolean $news_attivo		se true il servizio notizie è attivo
	 * @param boolean $files_attivo		se true il servizio false è attivo
	 * @param boolean $forum_attivo		se true il servizio forum è attivo
	 * @param int     $forum_forum_id	se forum_attivo è true indica l'identificativo del forum su database
	 * @param int     $forum_group_id	se forum_attivo è true indica l'identificativo del grupop moderatori del forum su database
	 * @param boolean $links_attivo 	se true il servizio links è attivo
	 *
	 * @param int	  $annoAccademico
	 * @param string  $codiceCdl
	 * @param string  $codInd
	 * @param string  $codOri
	 * @param string  $codMateria
	 * @param string  $nomeMateria
	 * @param string  $annoCorso
	 * @param string  $codMateriaIns
	 * @param string  $nomeMateriaIns
	 * @param int     $annoCorsoIns
	 * @param string  $codRil
	 * @param string  $codModulo
	 * @param string  $codDoc
	 * @param string  $nomeDoc  //questo sarà da cambiare in futuro qualora si voglia riferire un oggetto docente
	 * @param string  $flagTitolareModulo
	 * @param string  $tipoCiclo
	 * @param string  $codAte
	 * @param int     $annoCorsoUniversibo
	 * @param boolean $sdoppiato
	 * @return Insegnamento
	 */
	function PrgAttivitaDidattica($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine,
				 $nome, $visite, $news_attivo, $files_attivo, $forum_attivo,
				 $forum_forum_id, $forum_group_id, $links_attivo, $annoAccademico, $codiceCdl,
				 $codInd, $codOri, $codMateria, $nomeMateria, $annoCorso,
				 $codMateriaIns, $nomeMateriaIns, $annoCorsoIns, $codRil, $codModulo,
				 $codDoc, $nomeDoc, $flagTitolareModulo, $tipoCiclo, $codAte,
				 $annoCorsoUniversibo, $sdoppiato)
	{

		$this->Canale($id_canale, $permessi, $ultima_modifica, $tipo_canale, $immagine, $nome, $visite,
				 $news_attivo, $files_attivo, $forum_attivo, $forum_forum_id, $forum_group_id, $links_attivo);
				 
	 	$this->annoAccademico	   = $annoAccademico;
	 	$this->codiceCdl		   = $codiceCdl;
	 	$this->codInd			   = $codInd;
	 	$this->codOri			   = $codOri;
	 	$this->codMateria		   = $codMateria;
	 	$this->nomeMateria		   = $nomeMateria;
	 	$this->annoCorso		   = $annoCorso;
	 	$this->codMateriaIns	   = $codMateriaIns;
	 	$this->nomeMateriaIns	   = $nomeMateriaIns;
	 	$this->annoCorsoIns		   = $annoCorsoIns;
	 	$this->codRil			   = $codRil;
	 	$this->codModulo		   = $codModulo;
	 	$this->codDoc			   = $codDoc;
	 	$this->nomeDoc			   = $nomeDoc;
	 	$this->flagTitolareModulo  = $flagTitolareModulo;
	 	$this->tipoCiclo		   = $tipoCiclo;
	 	$this->codAte			   = $codAte;
	 	$this->annoCorsoUniversibo = $annoCorsoUniversibo;
	 	$this->sdoppiato		   = $sdoppiato;
		
	}



	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getAnnoAccademico()
	{
		return  $this->annoAccademico;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodiceCdl()
	{
		return  $this->codiceCdl;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodInd()
	{
		return  $this->codInd;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodOri()
	{
		return  $this->codOri;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodMateria()
	{
		return  $this->codMateria;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getNomeMateria()
	{
		return  $this->nomeMateria;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getAnnoCorso()
	{
		return  $this->annoCorso;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodMateriaIns()
	{
		return  $this->codMateriaIns;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getNomeMateriaIns()
	{
		return  $this->nomeMateriaIns;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getAnnoCorsoIns()
	{
		return  $this->annoCorsoIns;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodRil()
	{
		return  $this->codRil;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodModulo()
	{
		return  $this->codModulo;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodDoc()
	{
		return  $this->codDoc;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getNomeDoc()
	{
		return  $this->nomeDoc;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return boolean
	 */
	function isTitolareModulo()
	{
		return  $this->flagTitolareModulo == 'S';
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getTipoCiclo()
	{
		return  $this->tipoCiclo;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getCodAte()
	{
		return  $this->codAte;
	}
	
	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getAnnoCorsoUniversibo()
	{
		return  $this->annoCorsoUniversibo;
	}
	

	/**
	 * Restituisce 
	 *
	 * @return boolean
	 */
	function isSdoppiato()
	{
		return  $this->sdoppiato;
	}


	/**
	 * Restituisce 
	 *
	 * @return string
	 */
	function getTranslatedCodRil($cod_ril = NULL)
	{
		if ($cod_ril == NULL) $cod_ril = $this->getCodRil();
		
		return  ($cod_ril == 'A-Z') ? '' : '('.$cod_ril.')';
	}
	

	






	/**
	 * Restituisce il nome dell'attività didattica
	 *
	 * @return string
	 */
	function getNome()
	{
		return $this;  //TODO
	}



	/**
	 * Restituisce il titolo/nome completo dell'attività didattica
	 *
	 * @return string
	 */
	function getTitolo()
	{
		return $this->getNome();
	}


	/**
	 * Restituisce il codice di ateneo a 4 cifre della facoltà
	 * es: ingegneria -> '0021'
	 *
	 * @return string
	 */
	function getCodiceFacolta()
	{
		return $this->facoltaCodice;
	}


	/**
	 * Crea un oggetto Cdl dato il suo numero identificativo id_canale
	 * Ridefinisce il factory method della classe padre per restituire un oggetto
	 * del tipo Cdl
	 *
	 * @static
	 * @param int $id_canale numero identificativo del canale
	 * @return mixed Facolta se eseguita con successo, false se il canale non esiste
	 */
	function &factoryCanale($id_canale)
	{
		return PrgAttivitaDidattica::selectPrgAttivitaDidatticaCanale($id_canale);
	}
	

	/**
	 * Seleziona da database e restituisce l'oggetto PrgAttivitaDidattica
	 * corrispondente al codice id_canale 
	 * 
	 * @static
	 * @param int $id_canale identificativo su DB del canale corrispondente al corso di laurea
	 * @return mixed PrgAttivitaDidattica se eseguita con successo, false se il canale non esiste
	 */
	function &selectPrgAttivitaDidatticaCanale($id_canale)
	{
/*
		$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT .... WHERE a.id_canale = b.id_canale AND a.id_canale = '.$db->quote($id_canale);
		
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows == 0) return false;
		
		$res->fetchInto($row);
		$prgAtt =& new PrgAttivitaDidattica(  ... $row[12], $row[5],  );
		
		return $prgAtt;
*/
	}
	
	

	/**
	 * Seleziona da database e restituisce l'oggetto Cdl 
	 * corrispondente al codice $cod_cdl 
	 * 
	 * @static
	 * @param string $cod_cdl stringa a 4 cifre del codice d'ateneo del corso di laurea
	 * @return Facolta
	 */
	function &selectPrgAttivitaDidatticaCodice(/* ...tutta la chiave... */)
	{
/*		
		$db =& FrontController::getDbConnection('main');
		
		$query = 'SELECT ... WHERE a.id_canale = b.id_canale AND b.cod_corso = '.$db->quote($cod_cdl);
		
		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows == 0) return false;
		
		$res->fetchInto($row);
		$prgAtt =& new PrgAttivitaDidattica(  ... $row[16] ...  );
		
		return $prgAtt;
*/		
	}
	
	
	/**
	 * Seleziona da database e restituisce un'array contenente l'elenco 
	 * in ordine anno/ciclo/alfabetico di tutti le distinte attività didattiche
	 * appartenenti al corso di laurea in un dato anno accademico.
	 * Ritorna solo una volta le attività mutuate/comuni appartenenti a due 
	 * indirizzi/orientamenti distinti, o moduli identici in tutto il resto della chiave
	 * 
	 * @static
	 * @param string $cod_cdl stringa a 4 cifre del codice del corso di laurea
	 * @param int $anno_accademico anno accademico
	 * @return array(Insegnamento)
	 */
	function &selectPrgAttivitaDidatticaElencoCdl($cod_cdl, $anno_accademico)
	{
		
		$db =& FrontController::getDbConnection('main');
		
		$cod_cdl         = $db->quote($cod_cdl);
		$anno_accademico = $db->quote($anno_accademico);
		
		$query = 'SELECT *
					FROM (
						SELECT DISTINCT ON (id_canale, anno_accademico, cod_corso, cod_materia, anno_corso, cod_materia_ins, anno_corso_ins, cod_ril, cod_doc, tipo_ciclo, cod_ate, anno_corso_universibo ) *
						FROM (
							SELECT c.tipo_canale, c.nome_canale, c.immagine, c.visite, c.ultima_modifica, c.permessi_groups, c.files_attivo, c.news_attivo, c.forum_attivo, c.id_forum, c.group_id, c.links_attivo, c.id_canale, i.anno_accademico, i.cod_corso, i.cod_ind, i.cod_ori, i.cod_materia, m1.desc_materia, i.anno_corso, i.cod_materia_ins, m2.desc_materia AS desc_materia_ins, i.anno_corso_ins, i.cod_ril, i.cod_modulo, i.cod_doc, d.nome_doc, i.flag_titolare_modulo, i.tipo_ciclo, i.cod_ate, i.anno_corso_universibo, '.$db->quote('N').' AS sdoppiato
							FROM canale c, prg_insegnamento i, classi_materie m1, classi_materie m2, docente d
							WHERE c.id_canale = i.id_canale
							AND cod_corso='.$cod_cdl.'
							AND i.cod_materia=m1.cod_materia
							AND i.cod_materia_ins=m2.cod_materia
							AND i.cod_doc=d.cod_doc
							AND i.anno_accademico='.$anno_accademico.'
						UNION
							SELECT c.tipo_canale, c.nome_canale, c.immagine, c.visite, c.ultima_modifica, c.permessi_groups, c.files_attivo, c.news_attivo, c.forum_attivo, c.id_forum, c.group_id, c.links_attivo, c.id_canale, s.anno_accademico, s.cod_corso, s.cod_ind, s.cod_ori, s.cod_materia, m1.desc_materia, i.anno_corso, s.cod_materia_ins, m2.desc_materia AS desc_materia_ins, s.anno_corso_ins, s.cod_ril, i.cod_modulo, i.cod_doc, d.nome_doc, i.flag_titolare_modulo, s.tipo_ciclo, s.cod_ate, s.anno_corso_universibo, '.$db->quote('S').' AS sdoppiato
							FROM canale c, prg_insegnamento i, prg_sdoppiamento s, classi_materie m1, classi_materie m2, docente d
							WHERE c.id_canale = i.id_canale
							AND i.anno_accademico=s.anno_accademico_fis
							AND i.cod_corso=s.cod_corso_fis
							AND i.cod_ind=s.cod_ind_fis
							AND i.cod_ori=s.cod_ori_fis
							AND i.cod_materia=s.cod_materia_fis
							AND s.cod_materia=m1.cod_materia
							AND s.cod_materia_ins=m2.cod_materia
							AND i.anno_corso=s.anno_corso_fis
							AND i.cod_materia_ins=s.cod_materia_ins_fis
							AND i.anno_corso_ins=s.anno_corso_ins_fis
							AND i.cod_ril=s.cod_ril_fis
							AND s.cod_corso='.$cod_cdl.'
							AND s.anno_accademico='.$anno_accademico.'
							AND i.cod_doc=d.cod_doc
						) AS cdl
					) AS cdl1
					ORDER BY 31, 29, 22';
		/**
		 * @todo ATTENZIONE! ...questa query non è portabile.
		 * bisogna cambiarla ed eventualmente gestire i duplicati via PHP
		 */ 

		$res = $db->query($query);
		if (DB::isError($res))
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		$rows = $res->numRows();
		
		if( $rows == 0) return array();
		$elenco = array();
		while (	$res->fetchInto($row) )
		{
			$prgAtt =& new PrgAttivitaDidattica( $row[12], $row[5], $row[4], $row[0], $row[2], $row[1], $row[3],
				$row[7]=='S', $row[6]=='S', $row[8]=='S', $row[9], $row[10], $row[11]=='S',
				$row[13], $row[14], $row[15], $row[16], $row[17], $row[18], $row[19], $row[20],
				$row[21], $row[22], $row[23], $row[24], $row[25], $row[26], $row[27], $row[28],
				$row[29], $row[30], $row[31]=='S' );
			
			$elenco[] =& $prgAtt;
		}
		
		return $elenco;
	}
	
}