<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);
require_once ('Cdl'.PHP_EXTENSION);
require_once ('Insegnamento'.PHP_EXTENSION);
require_once ('PrgAttivitaDidattica'.PHP_EXTENSION);
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
 
class ScriptOrdinaForum extends UniversiboCommand 
{
	var $anno_accademico = 2004;
	
	function execute()
	{
		
		$anno_accademico = $this->anno_accademico;
		
		
		$fc =& $this->getFrontController();
		$template =& $fc->getTemplateEngine();
		$db =& $fc->getDbConnection('main');
		
		$query = 'begin';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 
		

//--------------- VECCHIO SCRIPT v1 CHE NON USAVA IL FRAMEWORK
function errore($msg)
{
	global $pg_conn;
	$query2 = 'rollback';
	$dati = pg_exec($pg_conn,$query2) or die('query: '.__FILE__.__LINE__);
	echo "\nrollback";
	die ($msg);
}


$pg_dbhost = '127.0.0.1';
//$pg_dbhost = '137.204.132.151';
$pg_dbport = '5432';
$pg_dbuser = 'xxxxxxxxxx';
$pg_dbpassword = 'xxxxxxxxxxx';
$pg_dbname = 'xxxxxxxxxxxxx';
@$pg_conn = pg_pconnect('host='.$pg_dbhost.' port='.$pg_dbport.' user='.$pg_dbuser.' password='.$pg_dbpassword.' dbname='.$pg_dbname ) or die('Impossibile connettersi al database');


echo '<PRE>';

$query2 = 'begin';
$dati = pg_exec($pg_conn,$query2) or die('query: '.__FILE__.__LINE__);

echo $anno_accademico = 2003,"\n";


$query2 = 'SELECT MAX(forum_id) as forum_id FROM phpbb_forums';
$dati = pg_exec($pg_conn,$query2) or errore('query: '.__FILE__.__LINE__);
$row = pg_fetch_array($dati,0);
echo $max_forum_id = $row['forum_id']+1, "\n";



$query2 = 'SELECT * FROM (classi_corso a LEFT JOIN docente b ON a.cod_doc=b.cod_doc) AS c LEFT JOIN argomento d ON (c.id_argomento=d.id_argomento) WHERE cat_id IS NOT NULL OR id_forum IS NOT NULL ORDER BY cod_corso';


$dati = pg_exec($pg_conn,$query2) or errore('query: '.__FILE__.__LINE__);

$num_rows = pg_numrows($dati);
for ($i=0; $i<$num_rows; $i++)
{
	echo "\n\n---------------\n";
	$row = pg_fetch_array($dati,$i,PGSQL_ASSOC);
	//$cat_title = addslashes( $row['cod_corso'].' - '.ucwords(strtolower($row['desc_corso']) ) );
	echo $cod_corso = $row['cod_corso'],"\n";
	echo $cat_id	= $row['cat_id'];
	if ($cat_id == NULL)
	{
		echo 'categoria NULL',"\n";
		break;
	}
	//$id_utente = $row['id_utente'];

	$query3 = 'SELECT  * 
				FROM phpbb_forums 
				WHERE cat_id=\''.$cat_id.'\' 
				ORDER BY forum_name';

//				AND forum_name NOT LIKE \'%'.($anno_accademico+1).'%\'
//				AND forum_name LIKE \'%'.($anno_accademico+1).'%\'

	$dati3= pg_exec($pg_conn,$query3) or die('query: '.__FILE__.__LINE__);
	$num_rows3 = pg_numrows($dati3);
	for ($j=0; $j<$num_rows3; $j++)
	{
		$row3 = pg_fetch_array($dati3,$j,PGSQL_ASSOC);
		$order = $j+1;
		echo $queryA = 'UPDATE phpbb_forums SET forum_order = '.$order.' WHERE forum_id = '.$row3['forum_id'].';',"\n";
		$datiA = pg_exec($pg_conn,$queryA) or errore('query: '.__FILE__.__LINE__);
	}
	$maxj = $num_rows3+1;

}

$query2 = 'commit';
$dati = pg_exec($pg_conn,$query2) or die('query: '.__FILE__.__LINE__);




//--------------- COPIATO DA ScriptCreaForum.php

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
				$cat_id = $forum->addForumCategory($cdl->getCodiceCdl().' - '.ucwords( strtolower( $cdl->getNome())), $cdl->getCodiceCdl());
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
				$forum_id = $forum->addForum($cdl->getCodiceCdl().' - '.ucwords(strtolower($cdl->getNome())), 
							'Forum riservato alla discussione generale sul CdL '.$cdl->getCodiceCdl(), $cat_id);
				$cdl->setForumForumId($forum_id);
				$cdl->setServizioForum(true);
				
				echo ' > ','creato forum cdl : ',$forum_id,'-'.$cat_id,"\n";
				
				if ($id_utente != null)
				{
					$group_id = $forum->addGroup('Moderatori '.$cdl->getCodiceCdl(), 'Moderatori del cdl'.$cdl->getCodiceCdl().' - '.ucwords(strtolower($cdl->getNome())), $id_utente );
					echo ' > ','creato gruppo forum cdl : ',$group_id,"\n";
					
					$forum->addGroupForumPrivilegies($forum_id, $group_id);
					echo ' > ','aggiunti privilegi cdl : ',$group_id,' - '.$forum_id,"\n";
					
					$cdl->setForumGroupId($group_id);
				}
				else
					echo ' > ','presidente cdl non trovato: ',$forum_id,"\n";
					
				$cdl->updateCdl();
				echo ' > ','aggiornato il canale con il nuovo forum e categoria: ',$forum_id,"\n";
				
			}
			elseif ($cdl->isGroupAllowed(USER_OSPITE))
				echo ' > ','forum cdl gia\' presente: ',$cdl->getForumForumId(),' - '.$cdl->getForumGroupId()."\n";
			
			

			$elenco_prgAttivitaDidattica = PrgAttivitaDidattica::selectPrgAttivitaDidatticaElencoCdl($cdl->getCodiceCdl(), $anno_accademico);
			
			foreach($elenco_prgAttivitaDidattica as $prg_att)
			{
				//AAHHH qui la cache di Canale potrebbe restituire dei casini, non la posso usare,
				// PrgAttivit? ed Insegnamento hanno gli stessi id_canali
				if (!$prg_att->isSdoppiato() && $prg_att->isGroupAllowed(USER_OSPITE)  && $prg_att->getServizioForum()==false)
				{
					$insegnamento = Insegnamento::selectInsegnamentoCanale($prg_att->getIdCanale());
					echo '   - ',$insegnamento->getIdCanale(),' - '.str_replace("\n",' ',$insegnamento->getNome()),"\n";
					$simile = $this->selectInsegnamentoConForumSimile($insegnamento);
					
					if ($simile == null)
					{
						//creo nuovo forum
						$id_docente = $this->selectIdUtenteFromCodDoc($prg_att->getCodDoc()); 
						
						if ($insegnamento->isGroupAllowed(USER_OSPITE) && $insegnamento->getServizioForum()==false)
						{
							$ins_forum_id = $forum->addForum($insegnamento->getNome(),'', $cat_id);
							$insegnamento->setForumForumId($ins_forum_id);
							$insegnamento->setServizioForum(true);
							
							echo '   - ','creato forum insegnamento : ',$ins_forum_id,'-'.$cat_id,"\n";
							
							if ($id_docente != null)
							{
								$ins_group_id = $forum->addGroup('Moderatori '.$insegnamento->getIdCanale(), 'Moderatori dell\'insegnamento con id_canale'.$insegnamento->getIdCanale().' - '.$insegnamento->getNome(), $id_docente );
								echo '   - ','creato gruppo forum insegnamento : ',$ins_group_id,"\n";
								
								$forum->addGroupForumPrivilegies($ins_forum_id, $ins_group_id);
								echo '   - ','aggiunti privilegi insegnamento : ',$ins_group_id,' - '.$ins_forum_id,"\n";
								
								$insegnamento->setForumGroupId($ins_group_id);
							}
							else
								echo '   ### docente insegnamento non trovato: ',$ins_forum_id,"\n";
								
							$insegnamento->updateCanale();
							echo '   - aggiornato il canale con il nuovo forum e categoria: ',$ins_forum_id,"\n";
							
						}
						
					}
					else
					{
						$ins_simile = Insegnamento::selectInsegnamentoCanale($simile);
						echo '   - forum simile a: '.$ins_simile->getIdCanale(),' - '.str_replace("\n",' ',$ins_simile->getNome()),"\n";
						
						$forum->addForumInsegnamentoNewYear($ins_simile->getForumForumId(), $anno_accademico);
						echo '   - aggiornato il nome del forum con il nuovo anno accademico ',$ins_simile->getForumForumId(),"\n";
						
						$insegnamento->setForumGroupId($ins_simile->getForumGroupId());
						$insegnamento->setForumForumId($ins_simile->getForumForumId());
						$insegnamento->setServizioForum(true);
						
						$insegnamento->updateCanale();
						echo '   - aggiornato il canale con il nuovo forum e categoria: ',$ins_forum_id,"\n";
						
					}
					
					
				}
				if($prg_att->getServizioForum()==true) 
					echo '   -- forum gia\' attivo ',$prg_att->getIdCanale(),"\n";
				
				
			}
			
				
		}

//----------------------------- FINE
		
		$query = 'commit';
		$res =& $db->query($query);
		if (DB::isError($res)) die($query); 
		
		
	}
	
}

?>
