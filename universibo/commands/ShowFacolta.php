<?php

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowFacolta: mostra una facoltà
 * Mostra i collegamenti a tutti i corsi di laurea attivi nella facoltà
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */


class ShowFacolta extends CanaleCommand 
{

	/** 
	 * Inizializza il comando ShowHome ridefinisce l'initCommand() di CanaleCommand
	 */
	function initCommand( &$frontController )
	{

		parent::initCommand( $frontController );

		$canale =& $this->getRequestCanale();
		//var_dump($canale);
		
		if ( $canale->getTipoCanale() != CANALE_FACOLTA )
			Error::throw(_ERROR_DEFAULT,array('msg'=>'Il tipo canale richiesto non corrisponde al comando selezionato','file'=>__FILE__,'line'=>__LINE__));
				
	}


	function execute()
	{
		$template =& $this->frontController->getTemplateEngine();
		
		$facolta =& $this->getRequestCanale();
		
		$template->assign('fac_langFac', 'FACOLTA\'');
		$template->assign('fac_facTitle', $facolta->getTitoloFacolta());
		$template->assign('fac_facName', $facolta->getNome());
		$template->assign('fac_facLink', $facolta->getUri());
		$template->assign('fac_langList', 'Elenco corsi di laurea attivati su UniversiBO');

		$fac_listCdl = array(); 	//cat := lista di cdl
		$fac_listCdl[] =  array('cod'=>'0048' , 'name'=>'ELETTRONICA', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0048&amp;anno_accademico=2003');
		$fac_listCdl[] =  array('cod'=>'0049' , 'name'=>'GESTIONALE', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0049&amp;anno_accademico=2003');
		$fac_listCdl[] =  array('cod'=>'0050' , 'name'=>'DEI PROCESSI GESTIONALI', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0050&amp;anno_accademico=2003');
		$fac_listCdl[] =  array('cod'=>'0051' , 'name'=>'INFORMATICA', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0051&amp;anno_accademico=2003');
	
		$fac_listCdlType   =  array();   //fac := lista categorie degli anni di cdl
		$fac_listCdlType[] =  array('cod'=>'L' , 'name'=>'Lauree Triennali/Primo Livello', 'list'=> $fac_listCdl);
		$fac_listCdlType[] =  array('cod'=>'S' , 'name'=>'Lauree Specialistiche', 'list'=> $fac_listCdl); 
		$fac_listCdlType[] =  array('cod'=>'V' , 'name'=>'Lauree Vecchio Ordinamento', 'list'=> $fac_listCdl);

		$template->assign('fac_list', $fac_listCdl );


	}

}

?>