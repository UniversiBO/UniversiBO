<?php

include ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowContributes is an extension of UniversiboCommand class.
 *
 * It shows Contribute page
 *
 * @package universibo
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@inwind.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowContribute extends UniversiboCommand {
	function execute(){

		$template =& $this->frontController->getTemplateEngine();
		
		$template->assign('contributes_langTitleAlt','Collabora');
		$template->assign('contributes_langIntro','<p>UniversiBo &egrave; un sito che nasce 
        dalla collaborazione tra studenti, docenti e strutture universitarie. 
        I docenti sono stati disponibili a dare il loro contributo e li ringraziamo 
        per questo. Ma per permettere che questo portale continui la sua vita 
        occorre che anche gli studenti collaborino.</p>
      <p> Noi non vogliamo obbligare nessuno, ma se veramente pensate che il servizio 
        che offriamo sia utile e desiderate che continui a essere disponibile 
        per tutti allora aiutateci a rendere questo portale ancora migliore.</p>');
		$template->assign('contributes_langTitle','-- Come fare per collaborare? --');
		$template->assign('contributes_langHowToContribute','<p>Non vi chiediamo di dedicare al progetto tutta la vostra vita universitaria! 
        Le modalit&agrave; di collaborazione sono tante e ognuna richiede tempi 
        diversi. Eccovi un breve elenco di ci&ograve; che potreste fare per aiutarci:</p>
      <ul>
        <li>potreste occuparvi di aggiungere <strong>contenuti</strong> al sito: 
          se avete molto tempo potreste scrivere alcune pagine altrimenti &egrave; 
          sufficiente che siate solidali con gli altri e rispondiate alle domande 
          che vengono poste nei forum.</li>
        <li>attualmente solo docenti e moderatori possono pubblicare news. Ma 
          se ne conoscete alcune che pensate tutti debbano conoscere potete segnalarle 
          sul forum e invitare i moderatori a pubblicarla come news. 
        </li>
        <li>potreste aiutarci con l\'attivit&agrave; di <strong>moderazione </strong>e 
          proporre la vostra candidatura al titolo di moderatore;</li>
        <li>segnalateci ogni errore o problema che riscontrate scrivendo a 
		<a href="mailto:staff_universibo@calvin.ing.unibo.it">staff_universibo@calvin.ing.unibo.it</a>
		oppure preferibilmente scrivendo sul forum dedicato.</li>
        <li>oppure potreste aiutaci nella <strong>progettazione</strong>: scrivendo 
          contenuti, scrivendo il codice che genera le pagine, aiutandoci nell\'amministrazione 
          del database, creando immagini grafiche...</li>
        <li>e se non avete la possibilit&agrave; di utilizzare il computer potreste 
          comunque aiutarci attraverso le <strong>attivit&agrave; offline</strong>: 
          spargere la voce ai tuoi amici dell\'esistenza del sito(pi&ugrave; persone 
          lo frequenteranno, pi&ugrave; persone potranno contribuirne alla sua 
          crescita), occuparvi del contatto con le aule, con i docenti...</li>
      </ul>
	  <p>Se quindi vi abbiamo convinto con queste poche e semplici parole e volete 
        collaborare attivamente al progetto compilate <b><a href="devoFarlo">questo questionario</a></b>
		e vi contatteremo al pi&ugrave; presto.</p>');
		
		
						
		}
}

?>