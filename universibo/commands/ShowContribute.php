<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowContributes is an extension of UniversiboCommand class.
 *
 * It shows Contribute page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowContribute extends UniversiboCommand {
	function execute(){

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template->assign('contribute_langTitleAlt','Collabora');
		$template->assign('contribute_langIntro',array('UniversiBo è un sito che nasce dalla collaborazione tra studenti, docenti e strutture universitarie. I docenti sono stati disponibili a dare il loro contributo e li ringraziamo per questo. Ma per permettere che questo portale continui la sua vita occorre che anche gli studenti collaborino.',
      'Noi non vogliamo obbligare nessuno, ma se veramente pensate che il servizio che offriamo sia utile e desiderate che continui a essere disponibile per tutti allora aiutateci a rendere questo portale ancora migliore.'));
		$template->assign('contribute_langTitle','-- Come fare per collaborare? --');
		$template->assign('contribute_langHowToContribute',array(
		'Non vi chiediamo di dedicare al progetto tutta la vostra vita universitaria! 
        Le modalità di collaborazione sono tante e ognuna richiede tempi 
        diversi. Eccovi un breve elenco di ciò che potreste fare per aiutarci:',
      '[list]
        [*]potreste occuparvi di aggiungere [b]contenuti[/b] al sito: 
          se avete molto tempo potreste scrivere alcune pagine altrimenti è 
          sufficiente che siate solidali con gli altri e rispondiate alle domande 
          che vengono poste nei forum.
        [*]attualmente solo docenti e moderatori possono pubblicare news. Ma 
          se ne conoscete alcune che pensate tutti debbano conoscere potete segnalarle 
          sul forum e invitare i moderatori a pubblicarla come news. 
        [*]potreste aiutarci con l\'attività di [b]moderazione[/b] e 
          proporre la vostra candidatura al titolo di moderatore;
        [*]segnalateci ogni errore o problema che riscontrate scrivendo a 
		[url=mailto:staff_universibo@calvin.ing.unibo.it]staff_universibo@calvin.ing.unibo.it[/url]
		oppure preferibilmente scrivendo sul forum dedicato.
        [*]oppure potreste aiutaci nella [b]progettazione[/b]: scrivendo 
          contenuti, scrivendo il codice che genera le pagine, aiutandoci nell\'amministrazione 
          del database, creando immagini grafiche...
        [*]e se non avete la possibilità di utilizzare il computer potreste 
          comunque aiutarci attraverso le [b]attività offline[/b]: 
          spargere la voce ai tuoi amici dell\'esistenza del sito(più persone 
          lo frequenteranno, più persone potranno contribuirne alla sua 
          crescita), occuparvi del contatto con le aule, con i docenti...
      [/list]',
	  'Se quindi vi abbiamo convinto con queste poche e semplici parole e volete 
        collaborare attivamente al progetto compilate questo questionario
		e vi contatteremo al più presto.'));
		
		//domande questionario 	
		$template->assign('question_PersonalInfo', 'Dati personali: '); 
		$template->assign('question_PersonalInfoData', array('Nome','Cognome','E-mail','Telefono')); 
		$template->assign('question_q1', 'Saresti disponibile a darci un piccolo contributo(di tempo) per il progetto?'); 
		$template->assign('question_q1Answers', array('una giornata alla settimana o più;','poche ore alla settimana;','pochi minuti alla settimana;')); 
		$template->assign('question_q2', 'Quanto tempo ti connetti a Internet?'); 
		$template->assign('question_q2Answers', array('quasi mai;','una volta alla settimana;','una volta al giorno;','vivo connesso;')); 
		$template->assign('question_q3', 'Quali di queste attività pensi di poter svolgere(anche più di una scelta)?'); 
		$template->assign('question_q3AnswersMulti', array('attività off-line(contatti con i docenti o studenti, reperimento materiale...);','moderatore  
		(controllare che la gente non scriva cose non permesse...);','scrittura contenuti riguardanti i corsi che frequento;','testare le nuove versioni dei sevizi  
		provandoli on-line;','elaborazione grafica di immagini (icone, scritte, ecc...);','aiutare nella progettazione e programmazione del sito;')); 
		$template->assign('question_PersonalNotes', 'Altre informazioni personali:'); 
		$template->assign('question_Privacy', 'Acconsento al trattamento dei miei dati personali ai sensi della legge sulla privacy 1996 N. 675/96;'); 
		$template->assign('question_Send', 'Invia'); 
		$template->assign('question_TitleAlt', 'Questionario'); 
				
		
		return 'default';						
	}
}

?>