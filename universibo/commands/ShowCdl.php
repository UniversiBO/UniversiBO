<?php 

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowCdl: mostra un corso di laurea
 * Mostra i collegamenti a tutti gli insegnamenti attivi nel corso di laurea
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class ShowCdl extends CanaleCommand {

	/**
	 * Inizializza il comando ShowHome ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand(& $frontController) {
		
		parent :: initCommand($frontController);
		
		$canale = & $this->getRequestCanale();
		//var_dump($canale);
		
		if ($canale->getTipoCanale() != CANALE_CDL)
			Error :: throw(_ERROR_DEFAULT, array('msg' => 'Il tipo canale richiesto non corrisponde al comando selezionato', 'file' => __FILE__, 'line' => __LINE__));
		
	}

	function execute() {
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		//@todo fatto sopra
		$cdl = & $this -> getRequestCanale();
		
		require_once('PrgAttivitaDidattica'.PHP_EXTENSION);
		
		$default_anno_accademico = $this->frontController->getAppSetting('defaultAnnoAccademico');

		$elencoPrgAttDid =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoCdl($cdl -> getCodiceCdl(), $default_anno_accademico);
		
		$num_ins = count($elencoPrgAttDid);
		$insAnnoCorso  = NULL;   //ultimo anno dell'insegnamento precedente
		$insCiclo = NULL;   //ultimo ciclo dell'insegnamento precedente
		$cdl_listInsYears = array();    //elenco insegnamenti raggruppati per anni
		$session_user =& $this->getSessionUser();
		$session_user_groups = $session_user->getGroups();
		
		
		//3 livelli di innestamento cdl/anno_corso/ciclo/insegnamento
		for ($i=0; $i < $num_ins; $i++)
		{
			if ($elencoPrgAttDid[$i]->isGroupAllowed( $session_user_groups ))
			{
				if ( $insAnnoCorso != $elencoPrgAttDid[$i]->getAnnoCorsoUniversibo() )
				{
					$insAnnoCorso = $elencoPrgAttDid[$i]->getAnnoCorsoUniversibo();
					$insCiclo = NULL; //$elencoPrgAttDid[$i]->getTipoCiclo();
					
					$cdl_listIns[$insAnnoCorso] = array('anno' => $insAnnoCorso, 'name' => 'anno '.$insAnnoCorso, 'list' => array() );
				}
				
				if ( $insCiclo != $elencoPrgAttDid[$i]->getTipoCiclo() )
				{
					$insCiclo = $elencoPrgAttDid[$i]->getTipoCiclo();
					
					$cdl_listIns[$insAnnoCorso]['list'][$insCiclo] = array('ciclo' => $insCiclo, 'name' => 'Ciclo '.$insCiclo, 'list' => array() );
				}
				
				
				$cdl_listIns[$insAnnoCorso]['list'][$insCiclo]['list'][] = 
					array( 'name' => $elencoPrgAttDid[$i]->getNomeMateriaIns().' - '.$elencoPrgAttDid[$i]->getNomeDoc(), 
						   'link' => 'index.php?do=ShowInsegnamento&amp;id_canale='.$elencoPrgAttDid[$i]->getIdCanale() );
			}
		}
		//var_dump($fac_listCdlType);
		
/*		$fac_listCdl = array(); //cat := lista di cdl
		$fac_listCdl[] = array('cod' => '0048', 'name' => 'ELETTRONICA', 'link' => 'index.php?do=ShowCDL&amp;id_cdl=0048&amp;anno_accademico=2003');
		$fac_listCdl[] = array('cod' => '0049', 'name' => 'GESTIONALE', 'link' => 'index.php?do=ShowCDL&amp;id_cdl=0049&amp;anno_accademico=2003');
		$fac_listCdl[] = array('cod' => '0050', 'name' => 'DEI PROCESSI GESTIONALI', 'link' => 'index.php?do=ShowCDL&amp;id_cdl=0050&amp;anno_accademico=2003');
		$fac_listCdl[] = array('cod' => '0051', 'name' => 'INFORMATICA', 'link' => 'index.php?do=ShowCDL&amp;id_cdl=0051&amp;anno_accademico=2003');

		$fac_listCdlType = array(); //fac := lista categorie degli anni di cdl
		$fac_listCdlType[] = array('cod' => '1', 'name' => 'Lauree Triennali/Primo Livello', 'list' => $fac_listCdl);
		$fac_listCdlType[] = array('cod' => '2', 'name' => 'Lauree Specialistiche', 'list' => $fac_listCdl);
		$fac_listCdlType[] = array('cod' => '3', 'name' => 'Lauree Vecchio Ordinamento', 'list' => $fac_listCdl);
*/
		$template -> assign('cdl_list', $cdl_listIns);

		$template -> assign('cdl_langCdl', 'CORSO DI LAUREA');
		$template -> assign('cdl_cdlTitle', $cdl->getTitolo());
		$template -> assign('cdl_langTitleAlt', 'Corsi di Laurea');
		$template -> assign('cdl_cdlName', $cdl->getNome());
		$template -> assign('cdl_cdlCodice', $cdl->getCodiceCdl());
		//$template -> assign('cdl_facLink', 'pippo');  //@todo
		$template -> assign('cdl_langList', 'Elenco insegnamenti attivati su UniversiBO');

		$this->executePlugin('ShowNewsLatest', array( 'num' => 4  ));
		
		return 'default';
	}

}

?>