<?php

require_once ('CanaleCommand'.PHP_EXTENSION);

/**
 * ShowHome: mostra la homepage
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
		
		$template->assign('fac_langFac', 'Facoltà');
		$template->assign('fac_facName', 'Ingegneria');
		$template->assign('fac_facLink', 'http://www.ing.unibo.it');
		$template->assign('fac_langList', 'Elenco corsi di laurea attivi su UniversiBO');

		$fac_cat = array(); 	//cat := lista di cdl
		$fac_cat[] =  array('cod'=>'0048' , 'name'='ELETTRONICA', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0048&amp;anno_accademico=2003');
		$fac_cat[] =  array('cod'=>'0049' , 'name'='GESTIONALE', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0049&amp;anno_accademico=2003');
		$fac_cat[] =  array('cod'=>'0050' , 'name'='DEI PROCESSI GESTIONALI', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0050&amp;anno_accademico=2003');
		$fac_cat[] =  array('cod'=>'0051' , 'name'='INFORMATICA', 'link'=> 'index.php?do=showCdl&amp;id_cdl=0051&amp;anno_accademico=2003');
	
		$fac_list   =  array();   //fac := lista categorie degli anni di cdl
		$fac_list[] =  array('cod'=>'L' , 'name'='Lauree Triennali/Primo Livello', 'list'=> $fac_cat);
		$fac_list[] =  array('cod'=>'S' , 'name'='Lauree Specialistiche', 'list'=> $fac_cat); 
		$fac_list[] =  array('cod'=>'V' , 'name'='Lauree Vecchio Ordinamento', 'list'=> $fac_cat);

		$template->assign('fac_list', $cdl_list );


	}

}

?>