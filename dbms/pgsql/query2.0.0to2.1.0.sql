--LastHope 15-10-2004

CREATE TABLE file_studente_canale (
    id_file integer NOT NULL,
    id_canale integer NOT NULL,
PRIMARY KEY ("id_file"), UNIQUE ("id_file"));
CREATE INDEX "file_studente_canale_id_file_key" ON
"file_studente_canale"("id_file");

CREATE TABLE file_studente_commenti (
    id_file integer NOT NULL,
    id_utente integer NOT NULL,
    commento text NOT NULL,
    voto integer NOT NULL
);

-- 22-10-2004 brain
UPDATE canale SET forum_attivo = 'N' WHERE forum_attivo = '';


-- 1-12-2004
CREATE TABLE link (
    id_link serial NOT NULL,
    id_canale integer NOT NULL,
    id_utente integer NOT NULL,
    uri varchar(255) NOT NULL,
    label varchar(128),
    description text,
    PRIMARY KEY ("id_link"), UNIQUE ("id_link")
);

-- 26-12-2004 brain
-- sposto la chiave primaria su cod_doc invece che id_utente
ALTER TABLE ONLY docente DROP CONSTRAINT docente_pkey;
ALTER TABLE "docente" ADD PRIMARY KEY ("cod_doc");

-- 12-1-2005 brain
ALTER TABLE "canale" ADD "files_studenti_attivo" character(1);
UPDATE "canale" SET "files_studenti_attivo" = 'N';
UPDATE "canale" SET "files_studenti_attivo" = 'S' WHERE tipo_canale = 5;

-- 07-02-2005 LastHope
DROP TABLE file_studente_commenti;
CREATE TABLE file_studente_commenti (
    id_commento serial NOT NULL,
    id_file integer NOT NULL,
    id_utente integer NOT NULL,
    commento text NOT NULL,
    voto integer NOT NULL,
    eliminato character(1) NOT NULL,
    PRIMARY KEY (id_commento),
    UNIQUE (id_file,id_utente,id_commento)
);
--query help--
SELECT setval('help_id_help_seq', (SELECT MAX(id_help) FROM help) +1);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Cos\'� il servizio files studenti?
','
E\' un servizio che d� la possibilit� di inserire dei files (appunti, lucidi, ecc...) relativi ad un insegnamento, a tutti gli studenti registrati. Non � da confondere con il servizio che permette al professore l\'inserimento di un file nel proprio insegnamento: i file inseriti dal professore appaiono sempre in basso alla pagina dell\'insegnamento, mentre i file inseriti dagli studenti sono visualizzati nel box �Contributi degli studenti� sulla colonna destra della pagina.',1117109715,310);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Come faccio ad inserire un file studenti?
','
Il procedimento per caricare un file sul sito � questo:
[list=1][*][url=index.php?do=ShowHelp#id10]Accedere al sito col proprio nome utente[/url] (username).
[*][url=index.php?do=ShowHelp#id3]Andare nella pagina[/url] in cui si desidera inserire il file.
[*]Cliccare la voce "Inserisci il tuo contributo" nel nel box "Contributi degli studenti", apparir� una nuova pagina "Aggiungi un nuovo file" nella quale dovrai completare i seguenti campi:
[list][*][b]File[/b]:  inserire il percorso interno al tuo computer del file che vuoi caricare, puoi aiutarti con il pulsante "Sfoglia" (o \'Browse\') e cercare la cartella del pc in cui � contenuto il file, selezionarlo e cliccare su \'Apri\' (o \'Open\', a seconda del sistema operativo utilizzato).  Per rendere pi� veloce il processo di upload (e conseguentemente di download da parte degli utenti che desidereranno scaricare il file sul loro computer) � consigliabile comprimere il file prima di inviarlo.
NB: si pu� caricare [b]un solo file alla volta[/b], quindi per mettere on line pi� files bisogna ripetere la procedura.
[*][b]Titolo:[/b] inserire un titolo significativo per il file, in modo che si intuisca facilmente il contenuto. Il titolo comparir� nella lista dei file inseriti dagli studenti
[*][b]Descrizione:[/b] scrivere una descrizione esauriente del contenuto del file.
[*][b]Parole chiave:[/b] scrivere al massimo 4 parole, separate da un Enter/Invio, per consentire una pi� facile individuazione del file da parte di altri utenti, mediante l\'uso di un motore di ricerca file.
[*][b]Categoria:[/b] scegliere la tipologia del file che stai inserendo tramite il men� a discesa. Se i file non appartiene a nessuna delle categorie presenti, lasciare "altro".
[*][b]Data e ora d\'inserimento.[/b] questi campi vengono completati automaticamente; se lo si desidera, li si pu� cambiare: pu� essere molto utile nel caso in cui si voglia che il file non sia visibile prima di una certa data e ora.
[*][b]Permessi download:[/b]  selezionando dal men� a discesa la voce "Solo iscritti", il file sar� scaricabile dai soli utenti registrati, mentre selezionando "Tutti", il file sar� scaricabile da chiunque fruisce del sito.
[*][b]Il file verr� inserito nella pagina :[/b] qui viene visualizzato il nome dell\'insegnamento/corso in cui il file verr� inserito, il contenuto non � modificabile e viene impostato in automatico
[/list]
[*]Cliccare su invia.
[/list]Se la procedura � stata completata con successo, verr� visualizzata una pagina di conferma del  corretto inserimento del file. Cliccando sul link "Torna a..." si ritorna alla pagina dove � stata inserito il file. Il titolo del nuovo file inserito comparir� nel Box \'Contributi degli studenti\'.
',1117109715,320);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Come faccio a modificare un file studenti?','
La modifica di un file studenti gi� presente pu� essere eseguita esclusivamente dall\'autore o dai referenti dell\'insegnamento.
Se si � in possesso dei diritti per effettuare questa operazione, bisogna cliccare sul nome del file che si vuole modificare all\'interno del Box \'Contributi degli studenti\'; si passer� a una pagina con le informazioni relative al file, per effettuare le modifiche  � sufficiente cliccare sul pulsante \'Modifica\' [img]https://www.universibo.unibo.it/tpl/unibo/file_edit_32.gif[/img]  
Verr� visualizzata la pagina di modifica analoga a quella di inserimento del file i cui campi contengono le informazioni del precedente inserimento. Effettuate le modifiche necessarie, � sufficiente cliccare sul pulsante \'Invia\' in basso alla pagina.
Se la procedura � stata completata con successo, verr� visualizzata una pagina di conferma della corretta modifica del file. Per tornare ai dettagli del file cliccare sul link \'torna ai dettagli del file\'
',1117109715,330);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Come faccio ad eliminare un file studenti?
','
Come per la modifica, l\'eliminazione di un file studenti pu� essere eseguita esclusivamente dall\'autore o dai referenti dell\'insegnamento.
Se si � in possesso dei diritti per effettuare questa operazione, bisogna cliccare sul nome del file che si vuole eliminare all\'interno del Box \'Contributi degli studenti\'; si passer� a una pagina con le informazioni relative al file, per effettuare l\'eliminazione cliccare sul pulsante \'Elimina\'[img]https://www.universibo.unibo.it/tpl/unibo/file_del_32.gif[/img]. Verr� presentata una pagina di conferma, se si � sicuri di volere cancellare il file cliccare ancora su \'Elimina\'.
',1117109715,340);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Cosa sono i commenti ai file studenti?
','
Per ogni file studente inserito � possibile scrivere un proprio commento. Ogni utente pu� aggiungere un solo commento per ogni file e deve esprimere un giudizio con un voto da zero a cinque.
',1117109715,350);

INSERT INTO help (titolo,contenuto,ultima_modifica,indice) VALUES ('Come posso aggiungere un commento ad un file studenti?
','
Il procedimento per inserire un commento � il seguente:
[list=1][*]Cliccate sul titolo del file nel box �contributi degli studenti�, si passer� ad un\'altra pagina con le informazioni relative al file, in basso a questa pagina nel box Commenti cliccate sulla voce �Aggiungi il tuo commento!�; verr� presentata una nuova pagina nella quale si dovranno completare i seguenti campi:
[list][*][b]Il tuo commento/descrizione sul file[/b]: scrivere una propria opinione sul file.
[*][b]Il tuo voto[/b]: utilizzando il men� a discesa, assegnate un voto al file da 0 a 5.
[*]infine cliccare su "INVIA".
[/list]
[/list]
',1117109715,360);







-- LASCIATE QUESTI COMMENTO IN FONDO - 04/03/2005 - brain

-- SELECT id_utente, user_email, email FROM phpbb_users, utente WHERE id_utente = user_id AND user_email != email
-- bisogna correggere e far diventare tutte le mail del forum uguali a quelle del sito se sono diverse 
-- (manualmente?) oppure pensate ad una query che lo faccia: ci ho provato 5 min ma non mi veniva in mente come fare

-- SELECT id_utente, phone FROM utente WHERE phone != '' OR phone IS NULL
-- bisogna correggere tutti i numeri di telefono manualmente nel formato +xxyyyzzzzzzz