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

class ShowInsegnamento extends CanaleCommand 
{

	/**
	 * Inizializza il comando ShowInsegnamento ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand(& $frontController) 
	{
		parent::initCommand($frontController);
		
		$canale = & $this->getRequestCanale();
		//var_dump($canale);
		
		if ($canale->getTipoCanale() != CANALE_INSEGNAMENTO)
			Error::throw(_ERROR_DEFAULT, array('msg' => 'Il tipo canale richiesto non corrisponde al comando selezionato', 'file' => __FILE__, 'line' => __LINE__));
	}



	function execute() 
	{
		$session_user =& $this->getSessionUser();
		$session_user_groups = $session_user->getGroups();
		$insegnamento =& $this -> getRequestCanale();
		
		$insegnamento->getTitolo();
		//var_dump($insegnamento);
		
		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
/*		//@todo fatto sopra
		
		require_once('PrgAttivitaDidattica'.PHP_EXTENSION);
		
		if ( !array_key_exists('anno_accademico', $_GET) )
			$anno_accademico = $this->frontController->getAppSetting('defaultAnnoAccademico');
		elseif( !ereg( '^([0-9]{4})$', $_GET['anno_accademico'] ) )
			Error::throw(_ERROR_DEFAULT, array('msg' => 'L\'anno accademico richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		else 
			$anno_accademico = $_GET['anno_accademico'];
		

		$elencoPrgAttDid =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoCdl($cdl -> getCodiceCdl(), $anno_accademico);
		
		$num_ins = count($elencoPrgAttDid);
		$insAnnoCorso  = NULL;   //ultimo anno dell'insegnamento precedente
		$insCiclo = NULL;   //ultimo ciclo dell'insegnamento precedente
		$cdl_listInsYears = array();    //elenco insegnamenti raggruppati per anni
		$cdl_listIns = array();
		
		//3 livelli di innestamento cdl/anno_corso/ciclo/insegnamento
		for ($i=0; $i < $num_ins; $i++)
		{
			$tempPrgAttDid =& $elencoPrgAttDid[$i];
			if ($tempPrgAttDid->isGroupAllowed( $session_user_groups ))
			{
				if ( $insAnnoCorso != $tempPrgAttDid->getAnnoCorsoUniversibo() )
				{
					$insAnnoCorso = $tempPrgAttDid->getAnnoCorsoUniversibo();
					$insCiclo = NULL; //$elencoPrgAttDid[$i]->getTipoCiclo();
					
					$cdl_listIns[$insAnnoCorso] = array('anno' => $insAnnoCorso, 'name' => 'anno '.$insAnnoCorso, 'list' => array() );
				}
				
				if ( $insCiclo != $tempPrgAttDid->getTipoCiclo() )
				{
					$insCiclo = $tempPrgAttDid->getTipoCiclo();
					
					$cdl_listIns[$insAnnoCorso]['list'][$insCiclo] = array('ciclo' => $insCiclo, 'name' => 'Ciclo '.$insCiclo, 'list' => array() );
				}
				
				$forum = new ForumApi;
				$cdl_listIns[$insAnnoCorso]['list'][$insCiclo]['list'][] = 
					array( 'name' => $tempPrgAttDid->getNome(),
						   'nomeDoc' => $tempPrgAttDid->getNomeDoc(), 
						   'uri' => 'index.php?do=ShowInsegnamento&id_canale='.$tempPrgAttDid->getIdCanale(),
						   'forumUri' => $forum->getForumUri($tempPrgAttDid->getForumForumId()) );
			}
		}
		//var_dump($fac_listCdlType);
		$template -> assign('cdl_list', $cdl_listIns);*/

		$template -> assign('cdl_langCdl', 'CORSO DI LAUREA');
/*		$template -> assign('cdl_cdlTitle', $cdl->getTitolo());
		$template -> assign('cdl_langTitleAlt', 'Corsi di Laurea');
		$template -> assign('cdl_cdlName', $cdl->getNome());
		$template -> assign('cdl_cdlCodice', $cdl->getCodiceCdl());

		$template -> assign('cdl_langYear', 'anno accademico' );
		$template -> assign('cdl_prevYear', ($anno_accademico-1).'/'.($anno_accademico) );
		$template -> assign('cdl_thisYear', ($anno_accademico).'/'.($anno_accademico+1) );
		$template -> assign('cdl_nextYear', ($anno_accademico+1).'/'.($anno_accademico+2) );
		$template -> assign('cdl_prevYearUri', 'index.php?do=ShowCdl&id_canale='.$cdl->getIdCanale().'&anno_accademico='.($anno_accademico-1) );
*/

		$template->assign("ins_nomeDoc","RCnome docenteEK");
		$template->assign("ins_annoAccademico","RC0000/6666EK");
		$template->assign("ins_lang","RCnome esameEK");
		$template->assign("ins_langForum","RCforum insegnamentoEK");
		$template->assign("ins_langForumLink","http://www.recek.it");
		$template->assign("ins_langAppelli","RCappelli esameEK");
		$template->assign("ins_langAppelliLink","http://www.recek.it");
		$template->assign("ins_langOrario","RCorario lezioniEK");
		$template->assign("ins_langOrarioLink","http://www.recek.it");
		
		$template->assign("ins_langObiettivi","RCobiettivi del corsoEK");
		$template->assign("ins_langObiettiviLink","http://www.recek.it");
		$template->assign("ins_langProgramma","RCProgramma del corsoEK");
		$template->assign("ins_langProgrammaLink","http://www.recek.it");
		$template->assign("ins_langMateriale","RCMateriale didattico e testi 
		consiglitEK");
		$template->assign("ins_langMaterialeLink","http://www.recek.it");
		$template->assign("ins_langModalita","RCModalit' del corsoEK'");
		$template->assign("ins_langModalitaLink","");


		$template -> assign('ins_title', $insegnamento->getTitolo() );
		

		$this->executePlugin('ShowNewsLatest', array( 'num' => 5  ));
		$this->executePlugin('ShowFileTitoli', array());
		return 'default';
	}

}

?>