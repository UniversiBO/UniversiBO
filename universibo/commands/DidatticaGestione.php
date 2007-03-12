<?php    

require_once ('Facolta'.PHP_EXTENSION);
require_once ('Cdl'.PHP_EXTENSION);
require_once ('Insegnamento'.PHP_EXTENSION);
require_once ('Docente'.PHP_EXTENSION);


require_once ('PrgAttivitaDidattica'.PHP_EXTENSION);
require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * -DidatticaGestione: per le correzioni didattiche
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author evaimitico
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class DidatticaGestione extends UniversiboCommand{

	function execute() {
		
		$frontcontroller = & $this->getFrontController();
		$template = & $frontcontroller->getTemplateEngine();

		$krono = & $frontcontroller->getKrono();
		$user = & $this->getSessionUser();
		$user_ruoli = & $user->getRuoli();

		if (!$user->isAdmin())
		{
			Error :: throwError (_ERROR_DEFAULT, array ('msg' => "Non hai i diritti necessari per accedere a questa pagina\n la sessione potrebbe essere terminata", 'file' => __FILE__, 'line' => __LINE__));
		}		

		$template->assign('common_canaleURI', array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : '' );
		$template->assign('common_langCanaleNome', 'indietro');
		$template->assign('DidatticaGestione_baseUrl', 'index.php?do=DidatticaGestione');

		$id_canale = '';	
		$id_facolta = '';
		$id_cdl = '';
		
		$f41_cur_sel = ''; 
		$edit = 'false';
		// controllo facoltà scelta
		if (array_key_exists('id_fac', $_GET))
		{
			if (!ereg('^([0-9]{1,9})$', $_GET['id_fac']))
				Error :: throwError (_ERROR_DEFAULT, array ('msg' => 'L\'id della facoltà richiesta non è valido', 'file' => __FILE__, 'line' => __LINE__));

			
			if ( Canale::getTipoCanaleFromId($_GET['id_fac']) == CANALE_FACOLTA)
			{
				$fac = & Canale::retrieveCanale(intval($_GET['id_fac']));
				$id_facolta = $fac->getIdCanale();
				$f41_cur_sel['facoltà'] = $fac->getTitolo();		
				// 	controllo cdl scelto				
				if (array_key_exists('id_cdl', $_GET))
				{
					if (!ereg('^([0-9]{1,9})$', $_GET['id_cdl']))
						Error :: throwError (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
		
					
					if ( Canale::getTipoCanaleFromId($_GET['id_cdl']) == CANALE_CDL)
					{
						$cdl = & Canale::retrieveCanale(intval($_GET['id_cdl']));
						
						if ($cdl->getCodiceFacoltaPadre() == $fac->getCodiceFacolta())					
						{
							$id_cdl = $cdl->getIdCanale();
							$f41_cur_sel['cdl'] = $cdl->getTitolo();
													
							// controllo canale scelto
							if (array_key_exists('id_canale', $_GET))
							{
								if (!ereg('^([0-9]{1,9})$', $_GET['id_canale']))
									Error :: throwError (_ERROR_DEFAULT, array ('msg' => 'L\'id del canale richiesto non è valido', 'file' => __FILE__, 'line' => __LINE__));
					
								
								if ( Canale::getTipoCanaleFromId($_GET['id_canale']) == CANALE_INSEGNAMENTO)
								{
									$canale = & Canale::retrieveCanale(intval($_GET['id_canale']));
									if(in_array($cdl->getCodiceCdl(),$canale->getElencoCodiciCdl()))
									{
										$id_canale = $canale->getIdCanale();
										$f41_cur_sel['insegnamento'] = $canale->getTitolo();
										$prgs =  $canale->getElencoAttivitaPadre();
										$prg =  $prgs[0];
										$f41_cur_sel['ciclo'] = $prg->getTipoCiclo();
										$f41_cur_sel['docente'] = $prg->getNomeDoc();
										$f41_cur_sel['codice docente'] = $prg->getCodDoc();
										
										$f41_edit_sel['codice docente'] = $prg->getCodDoc();
										$f41_edit_sel['ciclo'] = $prg->getTipoCiclo();
										$f41_edit_sel['anno'] = $prg->getAnnoAccademico();
										$edit = 'true';
										/*foreach ($canale->getElencoAttivitaPadre() as $prg)
											if ($prg->getCodiceCdl() == $cdl->getCodiceCdl())
											{
												$f41_cur_sel['ciclo'] = $prg->getTipoCiclo();
												$f41_cur_sel['docente'] = $prg->getNomeDoc();
												$f41_cur_sel['codice docente'] = $prg->getCodDoc();
												$edit = 'true';
											}
											*/
									}
									/*$template->assign('common_canaleURI', $canale->showMe());
									$template->assign('common_langCanaleNome', 'a '.$canale->getTitolo());*/
								}
							}
						}
					}
				}
			}
		}

		
		$f41_canale = array();
		$f41_cdl = array();
		$f41_fac = array();
	
		$elenco_canali = array();
		$listaFacolta = array();
		$listaCDL = array();
		$listaCanali = array();
		
		$annoDefault = $frontcontroller->getAppSetting("defaultAnnoAccademico");
			
		//recupero elenco facoltà, cdl, e gli insegnamenti degli ultimi due anni
		$listaFacolta =& Facolta::selectFacoltaElenco();
		
		if ($id_facolta != '')
		{
			$tmpFac = & Canale::retrieveCanale(intval($id_facolta));
//			var_dump($tmpFac); die;
			$firstFaculty = $tmpFac->getCodiceFacolta(); 
		}
		else 
		{
			$firstFaculty =  $listaFacolta[0]->getCodiceFacolta();
			$id_facolta = $listaFacolta[0]->getIdCanale();
		}
		
		$listaCDL =& Cdl::selectCdlElencoFacolta($firstFaculty);
		
		if ($id_cdl != '')
		{
			$tmpCdl = & Canale::retrieveCanale(intval($id_cdl));
			$firstCDL = $tmpCdl->getCodiceCdl(); 
		}
		else 
		{
			$firstCDL =  $listaCDL[0]->getCodiceCdl();
			$id_cdl = $listaCDL[0]->getIdCanale();
		}
		
		$listaCanali[$annoDefault] =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoCdl($firstCDL,$annoDefault);
		$anno = $annoDefault -1;
		$listaCanali[$anno] =& PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoCdl($firstCDL,$anno);
		
		
		foreach ($listaCanali as $year => $lista)
		{
//			var_dump($listaCanali);
			foreach ( $lista as $didatticaCanale)
			{
//				var_dump($didatticaCanale);
				$id_current_canale = $didatticaCanale->getIdCanale();			
				$year = $didatticaCanale->getAnnoAccademico();
				$nome_current_canale = $didatticaCanale->getTitolo();
				$f41_canale[$year][$id_current_canale] = array('nome' => $nome_current_canale, 'spunta' => ($id_current_canale == $id_canale)? 'true' : 'false');
			}
		}
		
		foreach ( $listaCDL as $didatticaCanale)
		{
			$id_current_canale = $didatticaCanale->getIdCanale();
			$nome_current_canale = $didatticaCanale->getTitolo();
			$f41_cdl[$id_current_canale] = array('nome' => $nome_current_canale, 'spunta' => ($id_cdl == $id_current_canale)? 'true' : 'false');
		}
		
		foreach ( $listaFacolta as $didatticaCanale)
		{
			$id_current_canale = $didatticaCanale->getIdCanale();
			$nome_current_canale = $didatticaCanale->getTitolo();
			$f41_fac[$id_current_canale] = array('nome' => $nome_current_canale, 'spunta' => ($id_facolta == $id_current_canale)? 'true' : 'false');
		}
		
//		var_dump($f41_fac); echo "fac finished";
//		var_dump($f41_cdl); echo "cdl finished";
//		var_dump($f41_canale); die;
		krsort($f41_canale);
		$tot = count($f41_canale);
		$list_keys = array_keys($f41_canale);
		for($i=0; $i<$tot; $i++) 
//			var_dump($f41_canale[$i]);
			uasort($f41_canale[$list_keys[$i]], array('DidatticaGestione','_compareCanale'));
		
//		var_dump($f41_files); die;
		$f41_accept = false;
		
		
		// TODO sistemare da qui in poi
		
		if (array_key_exists('f41_submit', $_POST) && $id_canale != '' && $id_cdl != '' && $id_facolta != '') 
		{
			$f41_accept = true;
//			var_dump($_POST);
			if (!array_key_exists('f41_edit_sel', $_POST) || !is_array($_POST['f41_edit_sel']) ||count($_POST['f41_edit_sel']) == 0)
			{
				Error :: throwError (_ERROR_NOTICE, array ('msg' => 'Nessun parametro specificato, nessuna modifica effettuata', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
				$f41_accept = false;
			}
			else 
			{
				$tmpEdit = $_POST['f41_edit_sel'];
				if (array_key_exists('codice docente', $tmpEdit))
				{
					if (!ereg('^([0-9]{1,9})$', $tmpEdit['codice docente']) || Docente::selectDocenteFromCod(intval($tmpEdit['codice docente'])))
					Error :: throwError (_ERROR_NOTICE, array ('msg' => 'Codice docente invalido, nessuna modifica effettuata', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f41_accept = false;
				}			
				if (array_key_exists('ciclo', $tmpEdit))
				{
					if (!ereg('^([1-3]{1})$', $tmpEdit['ciclo']))
					Error :: throwError (_ERROR_NOTICE, array ('msg' => 'Ciclo invalido, nessuna modifica effettuata', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f41_accept = false;
				}
				if (array_key_exists('anno', $tmpEdit))
				{
					if (!ereg('^([0-9]{4})$', $tmpEdit['anno']) || Docente::selectDocenteFromCod($tmpEdit['anno']))
					Error :: throwError (_ERROR_NOTICE, array ('msg' => 'Anno accademico invalido, nessuna modifica effettuata', 'file' => __FILE__, 'line' => __LINE__, 'log' => false, 'template_engine' => & $template));
					$f41_accept = false;
				}
				
			}
			

			//esecuzione operazioni accettazione del form
			if ($f41_accept == true) 
			{
				
				$db = FrontController::getDbConnection('main');
				ignore_user_abort(1);
        		$db->autoCommit(false);
								
				
				// TODO sistemare il codice di successo
				
        		$db->autoCommit(true);
				ignore_user_abort(0);
	
				return 'success';
			}

		} 
		//end if (array_key_exists('f41_submit', $_POST))

		
		$template->assign('f41_canale', $f41_canale);
		$template->assign('f41_cdl', $f41_cdl);
		$template->assign('f41_fac', $f41_fac);
		$template->assign('f41_cur_sel', $f41_cur_sel);
		$template->assign('f41_edit_sel', $f41_edit_sel);
		$template->assign('DidatticaGestione_edit', $edit);
		
		// TODO aggiungere l'help
		// $this->executePlugin('ShowTopic', array('reference' => 'filescollabs'));
		 
		return 'default';

	}
	
	
	/**
	 * Ordina la struttura dei canali
	 * 
	 * @static
	 * @private
	 */
	function _compareCanale($a, $b)
	{
		$nomea = strtolower($a['nome']);
		$nomeb = strtolower($b['nome']);
		return strnatcasecmp($nomea, $nomeb);
	}
	
}

?>