<?php

require_once ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowRules is an extension of UniversiboCommand class.
 *
 * It shows rules page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowRules extends UniversiboCommand {
	function execute(){

		$template =& $this->frontController->getTemplateEngine();

		$template->assign('rules_langIntro', 'UniversiBo si trova ancora nella fase iniziale di sviluppo. Vi preghiamo quindi innanzi tutto di essere pazienti se vi sono errori! :)');
		$template->assign('rules_langTitleAlt', 'Regolamento');
		$template->assign('rules_langTitle', 'REGOLAMENTO PER L\'UTILIZZO DEI SERVIZI DEL SITO UNIVERSIBO
		');
		//ATTENZIONE!! la seguente variabile dipendeva anche dalla facoltà dello studente!!
		$template->assign('rules_langFacSubtitle', 'Università di Bologna');
		$template->assign('rules_langPrivacy', '
		Informativa sul trattamento dei dati personali 
		
		
I dati personali immessi per l\'utilizzo dei servizi offerti sono trattati nel rispetto e secondo la disciplina della Legge 675/1996 sulla tutela della privacy.

 
Titolare del trattamento è l\'Università di Bologna. Responsabile del trattamento è la Facoltà di Ingegneria. L\'utente può in ogni tempo accedere ai dati che lo riguardano, aggiornarli, rettificarli, integrarli e più in generale esercitare i diritti previsti dall\'art. 13 della l. 675/1996, di seguito riportato, contattando [email]account@example.com[/email].

 
Il trattamento dei dati personali è finalizzato al pieno godimento dei servizi offerti e a realizzare l\'interazione tra gli utenti iscritti a "UniversiBo", in particolare mediante la partecipazione al forum. I dati raccolti sono trattati con mezzi informatizzati.

 
I dati raccolti vengono altresì utilizzati a fini statistici e di sicurezza.

 
I dati non saranno comunicati a terzi o diffusi.

		');
		$template->assign('rules_langServicesRules', 'Regolamento per l\'utilizzo dei servizi
 
1. Per poter utilizzare i servizi offerti mediante il sito UniversiBo è necessario iscriversi compilando l\'apposito form sottoposto al momento della registrazione.
 
2. Senza l\'iscrizione, l\'utente potrà accedere solo a dati di massima e non alle aree di interazione (forum, upload/download files, collaborazioni e inoltro di contenuti peculiari del portale).
 
3. l\'utente si impegna a fornire dati personali veritieri ed aggiornati, nonchè ad avvertire per un tempestivo aggiornamento degli stessi qualora fosse necessario.
 
4. E\' consentito l\'utilizzo di uno pseudonimo come identificativo nella fruizione dei servizi, a condizione che ad esso sia associabile l\'identità reale dell\'utente stesso (la quale per altro è rintracciabile attraverso l\'assegnazione della password) per motivi di sicurezza o qualora fosse richiesta dall\'autorità giudiziaria (nelle forme previste dalla legge in materia di reati commessi attraverso mezzi telematici).
 
5. l\'utente è responsabile della conservazione e della segretezza della propria password e si impegna a mantenere la Facoltà di Ingegneria indenne da qualunque pretesa o rivendicazione derivante da un uso non corretto dei servizi offerti.
 
6. l\'utente si impegna a non vendere o fare uso commerciale dei servizi forniti attraverso il sito UniversiBo e ad utilizzarli solo per scopi leciti. l\'utilizzo in genere di materiale coperto da diritti d\'autore messo a disposizione su UniversiBo è quindi consentito solo ed esclusivamente per scopi privati (cfr. L.633/41).
 
7. l\'utente garantisce che il materiale immesso nelle aree pubbliche non viola o trasgredisce alcun diritto di autore, marchio di fabbrica, brevetto o altro diritto. I docenti responsabili delle aree del sito UniversiBo corrispondenti a corsi di laurea e insegnamenti potranno decidere di controllare tutti i file inviati nelle rispettive sezioni prima che vengano pubblicati.
 
8. l\'utente accetta espressamente il controllo delle informazioni, dei materiali e dei contributi inoltrati nelle aree pubbliche del sito UniversiBo ad opera dello staff e dei moderatori. Tali controlli, effettuati anche a campione, aventi fini di tutela della privacy, del decoro e dell\'onore di terzi, e del corretto svolgersi delle attività didattiche, saranno effettuati il più possibile tempestivamente; tuttavia l\'utente è responsabile per eventuali dichiarazioni diffamatorie ed ingiuriose ai sensi degli artt. 594, 595, 596 bis c.p., o che violino la privacy altrui (cfr. L.675/96) e per qualunque altro illecito.
 
9. l\'utente si impegna a non inoltrare files affetti da virus con lo scopo di danneggiare il sistema informatico altrui ed accetta il controllo sugli stessi materiali ad opera dello staff di UniversiBo.
 
10. La Facoltà di Ingegneria si impegna a fornire in via continuativa i servizi offerti, ma non garantisce che questi possano subire sospensioni, modifiche o interruzioni (soprattutto dato il carattere sperimentale del progetto stesso).
 
11. La Facoltà di Ingegneria declina ogni responsabilità verso eventuali pretese dell\'utente relative all\'impossibilità dell\'utilizzazione dei servizi.
 
12. La Facoltà di Ingegneria si riserva di impedire l\'accesso a chi ha commesso atti illeciti.
		');
		$template->assign('rules_langForumRules', '
		Se avete domande da fare o, ancora meglio, se avete qualcosa 
      da comunicare non esitate ad usufruire del forum facendo attenzione a 
      rispettare le seguenti regole e consigli:
      
    [list]
      [*]se volete porre una domanda, controllate bene che l\'informazione cercata 
        non sia già presente all\'interno del sito o che non sia già 
        stata posta in un vecchio messaggio; 
      [*]i messaggi vengono raggruppati in discussioni(topic): per cui se rispondete 
        ad un messaggio, il vostro verrà visualizzato subito al di sotto 
        del precedente. Per facilitare a tutti la navigazione tra i diversi 
        topic ciò che più conta è che il primo a postare 
        un messaggio utilizzi un titolo opportuno e significativo. 
     [*]quando possibile cercate di rispondere all\'interno di un topic già 
        iniziato; 
     [*]evitate di scrivere messaggi troppo lunghi, altrimenti potreste rischiare 
        che nessuno li legga; 
      [*]se volete fare delle critiche non siate offensivi e fate in modo che 
        siano costruttive; 
        [*]non postate lo stesso messaggio più volte; 
        [*]se possibile non riportare il messaggio a cui rispondi, casomai, quando 
          servisse, riporta solo una frase; 
        [*]non usate esclusivamente lettere maiuscole(usare maiuscole significa 
          gridare). 
      [/list]
      
      Sul Forum è assolutamente vietato:
      
      [list]
        [*]postare messaggi offensivi; 
        [*]postare messaggi contenenti volgarità contrari alla morale 
          pubblica, messaggi politici/razziali, messaggi con contenuto osceno, 
          pornografico, ecc.; 
        [*]postare messaggi illeciti o link di siti illegali (pirateria, hacking, 
          pornografia); 
        [*]postare messaggi con qualsiasi forma di spam o pubblicità. 
      [/list]
      
      Il compito dei moderatori sarà quello di garantire il rispetto 
        assoluto delle regole e di consentire il corretto svolgimento delle discussioni. 
        Per cui potranno:
        
      [list]
        [*]controllare che discussioni troppo accese non degenerino oltre i limiti 
          di un civile e razionale dibattito.  
        [*]cancellare o modificare, senza alcun preavviso, un messaggio ritenuto 
          offensivo o comunque non consono allo spirito del forum. 
        [*]cancellare messaggi identici ripetuti più volte; 
         intervenire a loro insindacabile giudizio. 
      [/list]
      
      Contestazioni sull\'operato dei moderatori effettuate sul forum saranno 
        prontamente chiuse o eliminate. Spiegazioni e critiche (non in chiave 
        polemica) rivolte a moderatori e amministratori sono accette ma solo ed 
        esclusivamente in forma privata (via mail)<!-- o tramite il messenger 
        del forum-->.
        
      
       Siete invitati a segnalare ai moderatori eventuali irregolarità 
        di determinati messaggi.
        
      ');
		$template->assign('$rules_langTitleAlt', 'Regolamento');
				
		
		return 'default';						
	}
}

?>