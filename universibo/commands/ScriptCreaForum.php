<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Cdl'.PHP_EXTENSION);
require_once ('ForumApi'.PHP_EXTENSION);


/**
 * ChangePassword is an extension of UniversiboCommand class.
 *
 * Si occupa della modifica della password di un utente
 * NON ASTRAE DAL LIVELLO DATABASE!!!
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ScriptCreaForum extends UniversiboCommand 
{
	function execute()
	{
		$fc =& $this->getFrontController();
		$template =& $fc->getTemplateEngine();
		$db =& $fc->getDbConnection('main');
		
		$query = 'begin';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 
		
		$forum = new ForumApi();
		$max_forum_id = $forum->getMaxForumId();
		
		echo 'max_forum_id: ', $max_forum_id, "\n";
		
		$cdlAll =& Cdl::selectCdlAll();
		//var_dump($cdlAll);
		
		foreach ($cdlAll as $cdl)
		{
			echo $cdl->getCodiceCdl(),' - ', $cdl->getTitolo(),"\n";
			
			// creo categoria
			if ($cdl->getForumCatId()=='')
			{
				$cat_id = $forum->addForumCategory($cdl->getCodiceCdl().' - '.ucwords($cdl->getTitolo()), $cdl->getCodiceCdl());
				echo ' > ','creata categoria: ',$cat_id,"\n";
				
				$cdl->setForumCatId($cat_id);
				$cdl->updateCdl();
				echo ' > ','aggiornato cdl con nuova categoria: ',$cat_id,"\n";
			}
			else
				$cat_id = $cdl->getForumCatId();
			
			// creo forum cdl se ? attivo su universibo
			$id_utente = $this->selectIdUtenteFromCodDoc($cdl->getCodDocente()); //presidente cdl pu? essere null
			
			if ($cdl->isGroupAllowed(USER_OSPITE) && $cdl->getServizioForum()==false)
			{
				$forum_id = $forum->addForum($cdl->getCodiceCdl().' - '.ucwords($cdl->getTitolo()), 
							'Forum riservato sulla discussione generale sul CdL '.$cdl->getCodiceCdl() , $cdl->getCodiceCdl(), $cat_id);
				$cdl->setForumForumId($forum_id);
				$cdl->setServizioForum(true);
				
				echo ' > ','creato forum : ',$forum_id,"\n";
				
				if ($id_utente != null)
				{
					$group_id = $forum->addGroup('Moderatori '.$cdl->getCodiceCdl(), 'Moderatori del cdl'.$cdl->getCodiceCdl().' - '.ucwords($cdl->getTitolo()), $id_utente );
					echo ' > ','creato gruppo forum : ',$group_id,"\n";
					
					$forum->addGroupForumPrivilegies($forum_id, $group_id);
					echo ' > ','aggiunti privilegi : ',$group_id,' - '.$forum_id,"\n";
					
					$cdl->setForumGroupId($forum_id);
				}
				else
					echo ' > ','presidente cdl non trovato: ',$forum_id,"\n";
					
				$cdl->updateCdl();
				echo ' > ','aggiornato il canale con il nuovo forum e categoria: ',$forum_id,"\n";
				
			}
//			elseif ($cdl->isGroupAllowed(USER_OSPITE))
//				echo ' > ','forum gia\' presente: ',$cdl->getForumForumId(),' - '.$cdl->getForumGroupId()."\n";
				 
				
		}
		
		
//		$query = 'rollback';
//		$res =& $db->query($query);
//		die();
		
		$query = 'commit';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 
		
		
	}
	
	
	/**
	 * @todo questa funzione qui fa schifo, bisogna creare una classe Docente che estente Utente (?)
	 *
	 * @return int id_utente, null se non esiste il cod_doc
	 */
	function selectIdUtenteFromCodDoc($cod_doc)
	{
		$db =& FrontController::getDbConnection('main');
		$query = 'SELECT id_utente FROM docente WHERE cod_doc = '.$db->quote($cod_doc);

		$res = $db->query($query);
		if (DB::isError($res)) 
			Error::throw(_ERROR_DEFAULT,array('msg'=>DB::errorMessage($res),'file'=>__FILE__,'line'=>__LINE__)); 
		
		if ($res->numRows() == 0 ) 
			return null;
		
		$res->fetchInto($row);
			
		return $row[0];
		
	}
	
}

?>
