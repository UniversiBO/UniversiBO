
-- modifiche phpbb 2.0.6
CREATE TABLE phpbb_confirm (
    confirm_id character(32) DEFAULT '' NOT NULL,
    session_id character(32) DEFAULT '' NOT NULL,
    code character(6) DEFAULT '' NOT NULL
);

ALTER TABLE ONLY phpbb_confirm
    ADD CONSTRAINT phpbb_confirm_pkey PRIMARY KEY (session_id, confirm_id);

INSERT INTO "phpbb_config" ("config_name", "config_value") VALUES ('enable_confirm', '0');
INSERT INTO "phpbb_config" ("config_name", "config_value") VALUES ('sendmail_fix', '0');
UPDATE "phpbb_config" SET config_value = '.0.6' WHERE config_name='version';
-- modifiche tabella utente livello -> groups
ALTER TABLE "utente" ADD "groups" int4 ;

UPDATE "utente" SET "groups" = 2 WHERE "livello" = 100;
UPDATE "utente" SET "groups" = 4 WHERE "livello" = 200;
UPDATE "utente" SET "groups" = 8 WHERE "livello" = 300;
UPDATE "utente" SET "groups" = 16 WHERE "livello" = 400;
UPDATE "utente" SET "groups" = 32 WHERE "livello" = 600;
UPDATE "utente" SET "groups" = 64 WHERE "livello" = 500;

ALTER TABLE "utente" DROP COLUMN "livello";
-- creazione tabella canale   (si poteva fare in modo molto più semplice... vedi utente_canale)
CREATE TABLE "canale" (
"id_canale" SERIAL, 
"tipo_canale" int4 NOT NULL, 
"nome_canale" varchar (60) , 
"immagine" varchar (50) , 
"visite" int4 NOT NULL, 
"ultima_modifica" int4 , 
"permessi_groups" int4 , 
"files_attivo" char (1) , 
"news_attivo" char (1), 
"forum_attivo" char (1), 
"id_forum" int4 , 
"group_id" int4 ,
PRIMARY KEY ("id_canale"), UNIQUE ("id_canale"));
CREATE INDEX "canale_id_canale_key" ON "canale"("id_canale"); 
-- importa dati argomento->canale
UPDATE argomento SET visite=0 WHERE visite IS NULL;
INSERT INTO "canale" ( "id_canale" ,"tipo_canale" , "nome_canale" , "immagine" , "visite" , "ultima_modifica" , "permessi_groups" , "files_attivo" , "news_attivo" , "forum_attivo" , "id_forum" , "group_id" ) 
    SELECT "id_argomento" ,0 , "nome_argomento" , "immagine" , "visite" , "ultima_modifica" , 0, "files_attivo" , "news_attivo" , "forum_attivo" , "id_forum" , "group_id" FROM argomento;

UPDATE canale SET permessi_groups = permessi_groups+1 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE  '1_______');
UPDATE canale SET permessi_groups = permessi_groups+2 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE  '__1_____');
UPDATE canale SET permessi_groups = permessi_groups+4 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE  '___1____');
UPDATE canale SET permessi_groups = permessi_groups+8 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE  '____1___');
UPDATE canale SET permessi_groups = permessi_groups+16 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE '_____1__');
UPDATE canale SET permessi_groups = permessi_groups+32 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE '_______1');
UPDATE canale SET permessi_groups = permessi_groups+64 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE diritti_visualizzazione LIKE '______1_');

UPDATE canale SET tipo_canale = 1 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE tipo_argomento='A' );
UPDATE canale SET tipo_canale = 2 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE tipo_argomento='H' );
UPDATE canale SET tipo_canale = 3 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE tipo_argomento='F' );
UPDATE canale SET tipo_canale = 4 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE tipo_argomento='C' );
UPDATE canale SET tipo_canale = 5 WHERE canale.id_canale IN ( SELECT id_argomento FROM argomento WHERE tipo_argomento='E' );
UPDATE canale SET tipo_canale = 6 WHERE canale.id_canale IN ( SELECT a.id_argomento FROM argomento a, esami_attivi b, classi_corso c WHERE a.id_argomento=b.id_argomento AND b.cod_corso=c.cod_corso AND c.cod_fac='0054' );
-- modifica utente_argomento
ALTER TABLE "utente_argomento" RENAME "id_argomento" TO "id_canale"; ALTER TABLE "utente_argomento" ALTER "id_canale" DROP DEFAULT ;
ALTER TABLE "utente_argomento" ADD "ruolo" int4 ;
ALTER TABLE "utente_argomento" ADD "my_universibo" char (1) ;
ALTER TABLE "utente_argomento" RENAME TO "utente_canale";

UPDATE utente_canale SET my_universibo='S' WHERE 1=1;
UPDATE utente_canale SET ruolo=1 WHERE diritti='M';
UPDATE utente_canale SET ruolo=2 WHERE diritti='R';

ALTER TABLE "utente_canale" DROP COLUMN "diritti";
-- nuovi campi in utente_argomento
ALTER TABLE "utente_canale" ADD "notifica" int4 ;
ALTER TABLE "utente_canale" ADD "nome" char (60) ;

-- nuovi campi in canale
ALTER TABLE "canale" ADD "links_attivo" char (1) ;     

SELECT setval('canale_id_canale_seq', nextval('argomento_id_argomento_seq'));
UPDATE canale SET nome_canale = 'Homepage', permessi_groups=127 WHERE id_canale=1;

ALTER TABLE "facolta" RENAME "id_argomento" TO "id_canale"; 

ALTER TABLE "classi_corso" RENAME "id_argomento" TO "id_canale"; 
ALTER TABLE "classi_corso" ADD "categoria" int4;

UPDATE classi_corso SET categoria=2 WHERE cod_corso='0067';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0023';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0044';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0045';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0049';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0050';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0051';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0052';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0053';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0055';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0057';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0221';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0231';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0232';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0234';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2141';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2142';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2143';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2145';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2146';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2147';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2148';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2149';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2150';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2163';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2151';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0054';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0022';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0218';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='2140';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='5402';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0048';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0047';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0046';
UPDATE classi_corso SET categoria=2 WHERE cod_corso='0233';
UPDATE classi_corso SET categoria=1 WHERE cod_corso='0025';
UPDATE classi_corso SET categoria=3 WHERE cod_corso='5407';

ALTER TABLE "classi_corso" DROP COLUMN "menu_corso";


ALTER TABLE "facolta" DROP COLUMN "menu_facolta";
ALTER TABLE "facolta" DROP COLUMN "abbr_facolta";
DROP TABLE "argomento";

UPDATE "canale" SET "permessi_groups"=127 WHERE tipo_canale=4 OR tipo_canale=5 OR tipo_canale=6;

--------16-10-2003
UPDATE canale SET permessi_groups=127 WHERE tipo_canale=3;

--------21-10-2003
ALTER TABLE "esami_attivi" DROP COLUMN "cod_attivita";

--------22-10-2003

ALTER TABLE "news" RENAME TO "news2";

ALTER TABLE news2
 DROP CONSTRAINT news_pkey;

CREATE TABLE "news" (
   "id_news" int4 DEFAULT nextval('"news_id_news_seq"'::text) NOT NULL,
   "titolo" varchar(150) NOT NULL,
   "data_inserimento" int4 NOT NULL,
   "data_scadenza" int4,
   "notizia" text,
   "id_utente" int4 NOT NULL,
   "eliminata" char(1) DEFAULT 'N' NOT NULL,
   "flag_urgente" char(1) DEFAULT 'N' NOT NULL,
   CONSTRAINT "news_pkey" PRIMARY KEY ("id_news")
);

INSERT INTO news ( "id_news" , "titolo" , "data_inserimento", "data_scadenza", "notizia" , "id_utente", "eliminata") 
SELECT "id_news" , "titolo" , "data_inserimento", "data_scadenza", "notizia" , "id_utente", "eliminata" FROM news2 ;

CREATE TABLE "news_canale" (
"id_news" int4 NOT NULL, 
"id_canale" int4 NOT NULL ,
PRIMARY KEY ("id_news", "id_canale"));
CREATE INDEX "news_canale_id_news_key" ON "news_canale"("id_news"); 
CREATE INDEX "news_canale_id_canale_key" ON "news_canale"("id_canale");

------30-10-2003

INSERT INTO news_canale ( "id_news" , "id_canale") 
SELECT "id_news" ,  "id_argomento" FROM news2 ;

---query per configurarvi il path del forum
--UPDATE phpbb_config SET config_value='localhost' WHERE config_name='server_name';
--UPDATE phpbb_config SET config_value='localhost' WHERE config_name='cookie_domain';
--UPDATE phpbb_config SET config_value='/universibo2/htmls/forum/' WHERE config_name='script_path';
--UPDATE phpbb_config SET config_value='0' WHERE config_name='cookie_secure';

-----03-11-2003
ALTER TABLE "utente" ADD "ban" char (1) ;
ALTER TABLE "utente" ALTER "ban" SET DEFAULT 'N';
UPDATE "utente" SET ban='N' WHERE 1=1;

-----06-11-2003
CREATE TABLE "collaboratore" (
 "id_utente" int4 PRIMARY KEY,
 "intro" text ,
 "ruolo" varchar(50) ,
 "recapito" varchar(255),
 "obiettivi" text 
);
 
 
 ----13-11-2003

ALTER TABLE "collaboratore" ADD "foto" varchar (255) ;

ALTER TABLE "collaboratore" DROP COLUMN "ruolo";
ALTER TABLE "collaboratore" ADD "ruolo" varchar (255) ;
 

---eliminazione della tabella studente

DROP TABLE "studente";

---eliminazione degli attributi non utilizzati della tabella docente

ALTER TABLE "docente"   DROP COLUMN "email";
ALTER TABLE "docente"   DROP COLUMN "nome";
ALTER TABLE "docente"   DROP COLUMN "cognome";
ALTER TABLE "docente"   DROP COLUMN "qualifica";
ALTER TABLE "docente"   DROP COLUMN "sesso";
ALTER TABLE "docente"   DROP COLUMN "data_nascita";
ALTER TABLE "docente"   DROP COLUMN "telefono_1";
ALTER TABLE "docente"   DROP COLUMN "telefono_2";
ALTER TABLE "docente"   DROP COLUMN "ufficio";
ALTER TABLE "docente"   DROP COLUMN "icq";
ALTER TABLE "docente"   DROP COLUMN "homepage";

----04-12-2003

----eliminazione attributi non utilizzati in questionario

ALTER TABLE "questionario" DROP COLUMN "win";
ALTER TABLE "questionario" DROP COLUMN "linux";
ALTER TABLE "questionario" DROP COLUMN "html";
ALTER TABLE "questionario" DROP COLUMN "php";
ALTER TABLE "questionario" DROP COLUMN "javascript";
ALTER TABLE "questionario" DROP COLUMN "xml";
ALTER TABLE "questionario" DROP COLUMN "java";
ALTER TABLE "questionario" DROP COLUMN "photoshop";
ALTER TABLE "questionario" DROP COLUMN "gimp";
ALTER TABLE "questionario" DROP COLUMN "sql";


----09-12-2003
--aggiunta timestamp ultima modifica della notizia
ALTER TABLE "news" ADD "data_modifica" int4 ;
UPDATE news SET data_modifica = data_inserimento;
--correzione dati tabella
UPDATE utente_canale SET ruolo=0 WHERE ruolo is NULL;

----11-12-2003
--aggiunta possibilità di nascondere la visualizzazione di un ruolo/contatto
ALTER TABLE "utente_canale" ADD "nascosto" char (1) ;
ALTER TABLE "utente_canale" ALTER "nascosto" SET DEFAULT 'N';
UPDATE utente_canale SET nascosto = 'N';
--aggiunto preside alle tabelle
ALTER TABLE "facolta" ADD "cod_doc" char (6) ;   ---bisogna ancora inserire manualmente i dati dei presidi di facolta



-----29-01-04
CREATE TABLE help(
id_help int4 PRIMARY KEY,
titolo varchar(255) NOT NULL,
contenuto text NOT NULL,
ultima_modifica int4 NOT NULL,
indice int4 NOT NULL);

CREATE TABLE help_riferimento(
riferimento varchar(32) PRIMARY KEY,
id_help int4 NOT NULL
);


-----04-02-04

DROP TABLE help;

CREATE TABLE help(
id_help serial PRIMARY KEY,
titolo varchar(255) NOT NULL,
contenuto text NOT NULL,
ultima_modifica int4 NOT NULL,
indice int4 NOT NULL);

------14-02-04
DROP TABLE help_riferimento;

CREATE TABLE help_riferimento(
riferimento varchar(32) ,
id_help int4,
PRIMARY KEY(riferimento, id_help)
);

------01-03-04
CREATE TABLE "help_topic" (
"riferimento" varchar (32) NOT NULL, 
"titolo" varchar (256) NOT NULL ,
PRIMARY KEY ("riferimento"));

------15-03-04
ALTER TABLE "esami_attivi" RENAME TO "prg_insegnamento";
ALTER TABLE "sdoppiamenti_attivi" RENAME TO "prg_sdoppiamento";
ALTER TABLE "esami_attivi2" RENAME TO "prg_insegnamento2";
ALTER TABLE "sdoppiamenti_attivi2" RENAME TO "prg_sdoppiamento2";
ALTER TABLE "prg_insegnamento" RENAME "id_argomento" TO "id_canale"; 

ALTER TABLE "prg_insegnamento"   DROP COLUMN "prog_cronologico";

------23-03-04
UPDATE "canale" SET "tipo_canale"=5 WHERE tipo_canale=6;

------07-09-04

INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('727', 'studentessa di ingegneria delle telecomunicazioni', '3295432013', 'Mi sono unita per collaborare alla realizzazione di un servizio valido e utile come Universibo e per cercare di ampliare le mie scarse conoscenze informatiche', NULL, 'collaboro alle attivit\340 off-line,scrittura contenuti e moderazione');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('96', 'Bukowski non si sarebbe mai arreso alla settima ripresa. Tra il dire e il fare, chi visse sperando. Piove. ', '3496692919', 'Cerco di dare una mano, quando posso. Non \350 facile gestire la vita universitaria, gli esami, le donne e il vino, ma sono un gestionale, del resto. E'' uno sporco lavoro, ma qualcuno deve pur farlo, non credete ?', 'budwhite.jpg', 'moderatore - lesto tuttofare');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('110', 'Studentessa di Ingegneria Gestionale. Nel progetto si occupa insieme a Matteo della grafica del sito e della stesura di pagine HTML', NULL, 'Ho iniziato a collaborare con Andrea e Matteo alla moderazione della mailing list per i gestionali e quando \350 iniziato il progetto di UniversiBO \350 stato praticamente impossibile non farmi coinvolgere. Ho sempre avuto il pallino del computer ma non ho mai avuto modo di approfondire... ora non solo ho l''opportunit\340 di imparare tante cose ma quel che faccio mi piace e mi da soddisfazione. Ogni giorno ho modo di confrontarmi, di imparare e sperimentare cosa vuol dire lavorare in gruppo... se a tutto questo aggiungiamo che questo gruppo di matti \350 straordinario... il gioco \350 fatto!', NULL, 'admin - responsabile della grafica');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('105', 'Ciao, sono Francesco! Sono studente di Ingegneria dei Processi Gestionali, amo lo sport (praticato!) e il "far baracca"! Mi occupo principalmente dell''Analisi dei Servizi e della Logistica.', '3283030235', '\310 senz''altro una possibilit\340 pi\371 unica che rara per fare esperienza diretta in un team di progetto! [...]\r\n\r\nBla bla bla... Avevo scritto un profilo molto serio e barboso, e rileggendolo sembrava scritto da un ingegnere e ho preso paura... quindi tabula rasa e se volete sapere qualcosa in pi\371 su di me non avete che da chiamarmi. No, gli insulti non sono graditi...\r\nP.S.\r\nNon ho ancora ben capito che animale sia un Ingegnere dei Processi Gestionali, ma arriver\362 in fondo a questa storia! Ciau!', NULL, 'admin - gestione, analisi dei servizi, logistica');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('115', 'Responsabile informatico del Cieg, con la passione per il software Open Source.', '0512093946', 'I miei obiettivi sono "istituzionali" nel senso che fanno parte del mio ruolo lavorativo presso il Cieg e principalmente comprendono l''amministrazione dell''infrastruttura informatica di una parte della sede di via Saragozza n.8. Questo progetto si discosta leggermente rispetto alle situazioni standard incontrate fino ad ora e non so se inserirlo nella lista dei compiti "istituzionali", ma comunque ha ricevuto il mio appoggio fin dal principio. Lavorare con gli altri membri dello staff permette di creare un circolo virtuoso di scambio di idee e quindi ognuno di noi pu\362 imparare qualcosa dagli altri.', NULL, 'admin di sistema e addetto alla sicurezza');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('79', 'Studente di Ingegneria Gestionale super esperto in informatica. Nel progetto si occupa dell''amministrazione di sistema e del design grafico.', '3288311503', 'Le motivazioni che mi spingono a lavorare su questo progetto sono strutturate, nel senso che si sono ampliate e modificate col tempo. Alla radice c''\350 sicuramente il desiderio di creare qualcosa di utile, poi mi piace l''idea di applicare quello che studio a qualcosa di concreto. L''esperienza di gestione della mailing list ha contribuito ad accrescere la voglia di implementare un servizio creato dagli studenti e per gli studenti. Queste forse sono le motivazioni a pi\371 basso livello, quelle che c''erano fin dall''inizio e che si sono mantenute; a rinforzo di queste, con l''avanzare del progetto il gruppo che si \350 formato e le gratificazioni ricevute da professori e compagni mi hanno spinto e mi spingono ad andare avanti ben consapevole dell''importanza del servizio che andremo a offrire.', NULL, 'admin - sistemista e designer');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('517', 'Studentessa di ingegneria informatica al 2 anno. Sono di Ravenna e tra qua e l\340 mi piace lavorare al computer, imparare sempre cose nuove a riguardo; mi piace leggere, informarmi e... farmi i fatti degli altri... Nel progetto mi occupo di gestire i collaboratori, vecchi e nuovi, e vedere di farli rigare dritto :P . ', '3393626294 ', 'Mi piace poter essere utile agli altri, fare qualcosa che \350 contemporaneamente un aiuto e un incentivo per gli studenti, ed istruttivo per me (per le mie capacit\340 informatiche e non). Penso che sia un ottimo progetto e sono convinta della sua utilit\340 quindi, anche se inizialmente la mia partecipazione al progetto era solo marginale, ora sta prendendo sempre pi\371 piede nella mia vita e nel mio tempo libero. ', NULL, 'admin - gestione collaboratori');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('92', 'Studente di Ingegneria dei Processi Gestionali. Si occupa di tutto ci\362 che riguarda le attivit\340 non gestibili via computer: contatto con i docenti, studenti, presentazioni, volantinaggio, manifestazioni, corsi, etc....', '3392888793', 'Ho iniziato a collaborare a UniversiBO perch\351 mi dava la possibilit\340 di imparare cose che sui libri o in un aula universitaria non \350 possibile imparare. Con UniversiBO ho conosciuto molti amici, che mi hanno aiutato ad imparare e crescere le mie conoscenze tecniche e non. ', NULL, 'admin - attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('650', 'ing. mi piace per le persone, non certo per quello che si studia. chi pensa che analisi sia utile per creare un array alzi la mano. a parte questo, sono un fanatico dei computer, scout, e pazzo! (nonch\350 figlio di ferroviere, e quindi non pago lu treno!)', '3402246549', 'arrivare ad un numero di macchine amministrate talmente alto che scorder\362 gli ip di tutte, far capire agli utenti che la password "pippo" non \350 la pi\371 sicura, installare macchine da 200$ con linux e far capire a chi compra super-server-strafichi-con-windows-xp a 20000$ che le mie macchine vanno meglio e sono pi\371 sicure, essere lo zefram cochrane dei computer... ', NULL, 'sys-admin, sviluppatore sw, attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('88', 'Studente di Ingegneria Gestionale, proveniente da Macerata, tifoso del Milan', '3392517183', 'Aiutare il gruppo a realizzare un sito ben fatto e specialmente utile e di facile comprensione. E poi la gratificazione di un lavoro ben fatto \350 il massimo che si possa chiedere.. ', NULL, 'moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('491', 'studentessa di ingegneria delle telecomunicazioni', '3478005673', 'Mi sono unita al progetto con la speranza di incrementare le mie (ridotte) capacit\340 informatiche e contemporaneamente di poter collaborare alla progressiva realizzazione di un''idea senz''altro valida, quale UniversiBo mi era sembrata fin dall''inizio.', NULL, 'moderatore - collaboratrice progettazione grafica');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('520', 'Mi chiamo Daniele Tiles, studio Ingegneria Informatica e sono di Bologna...basta cos\354 O volete anche il numero di scarpe?', '3284139075', 'diventare un ingegnere, capire tutto il possibile su computer e affini...cosa volete di pi\371? UniversiBO m''interessa tantissimo...quando avr\362 le capacit\340 adatte, entrer\362 anch''io nel ramo della progettazione. Il mio obbiettivo principale in UniversiBO \350 aiutare al massimo gli studenti che arrivano...non \350 facile abituarsi a questo nuovo ambiente, ed UniversiBO secondo me \350 lo strumento ideale!', NULL, 'moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('342', 'studente di Ingegneria Gestionale ', '3289760725', NULL, NULL, 'collaboratore attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('167', 'studente di ing gestionale patito di informatica e tutto ci\362 che ruota intorno ad internet ', '3478005673', 'Aumentare la mia conoscenza dei vari software nella progettazione di carattere web, conoscere le basi di un server, dalla sua realizzazione al suo mantenimento! Ma soprattutto divertirmi con un gruppo di amici!!! ', NULL, 'collaboratore nelle sezioni Test, Progettazione, Benchmarking - moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('83', '23 anni, iscritta al IV anno di Ingegneria Gestionale, spero di uscire presto dall''Universit\340, ma nel frattempo vale la pena di dedicarsi un po'' al progetto UniversiBo ', '3382305493', 'Mi occupo quasi esclusivamente dell''attivit\340 OffLine, contatto con i docenti in aula e in dipartimento. Mi sono trovata bene con le persone che lavorano al progetto, ho stima dell''impegno che ci stanno mettendo e condivido le loro speranze su quello che ne verr\340 fuori!', NULL, 'moderatore - attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('577', 'sono uno studente di ingegneria delle telecomunicazioni con l''hobby per l''informatica (e sopratutto per gli anime)', '3331553398', 'ci\362 che mi ha spinto a collaborare \350 stato prima di tutto la curiosit\340 per qualcosa di nuovo, poi l''interesse di fare quasi da tramite tra professori e studenti, con la voglia di partecipare a qualcosa di utile', NULL, 'faccio da referente e moderatore per alcuni esami del mio cdl e provo a realizzare qualcosa per la grafica e la stesura contenuti');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('746', NULL, '3475214764', 'a dire il vero non so bene neanch''io perch\350 abbia deciso di collaborare a universibo, forse perch\350 sar\340 un buono stimolo per applicare ci\362 che studio a un progetto concreto. Visto poi l''entusiasmo che ci mettono tutti gli altri ragazzi....beh....mi sono lasciato coinvolgere e sono convinto che questo coinvolgimento aumenter\340 col tempo.', NULL, 'collaboratore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('99', 'Non trovo nulla di interessante da dire a mio proposito\r\n', '3282213798', 'Non riesco a trovare nulla che non sia terribilmente demagogico x riempire questo campo...', NULL, 'moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('113', NULL, NULL, 'Molti hanno gi\340 detto molto e forse anche troppo; cosa potrei mai aggiungere io di rilevante? Come gi\340 osservai con qualcuno, avrei dovuto elaborare questo scritto ai miei esordi nel progetto - evento che ormai si perde nel tempo e nella memoria - e non ora che ormai l''entusiasmo iniziale va scemando. Concludo quindi questa mia divagazione gi\340 fin troppo lunga, ricordando che le persone che pensano a farsi notare, in realt\340 non sono quelle che contano veramente: quindi basta chiacchiere! perch\350 appoggio incondizionatamente la filosofia di un mio conterraneo: fatti e non pugn...', NULL, 'diffusione del LaTeX quale strumento di condivisione tra gli studenti di appunti e materiale didattico in forma elettronica... pi\371 tutto il resto (ie. integrazione tra grafica e software: sviluppo del sistema dei template)');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('593', 'partito dalla solare citt\340 di Pescara, sto provando ad immedesimarmi nel ruolo di studente di Ingegneria Meccanica nella bella Bologna. Appena posso coltivo le mie passioni:calcio,computer e tutto ci\362 che \350 tecnologia', '3497630035', 'appena saputo di Universibo mi \350 subito piaciuto lo spirito del progetto: studenti che con passione cercano di mettere la tecnologia al servizio di altri studenti per far s\354 che si aiutino l''uno con l''altro! come non farne parte...e magari imparer\362 anche qualcosa!', NULL, 'collaboratore nella sezione grafica-moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('93', 'studente, cercatore d''oro...', '051392346', 'costruzione di un portale web, applicazione di tecnologie orientate al web, comunione dello scibile fra gli studenti... ', NULL, 'moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('150', NULL, NULL, 'dare il mio contributo ad un sito che io giudico all\222avanguardia nell\222ambito dello scambio di notizie e materiale didattico tra docenti e studenti, uno strumento indispensabile per una moderna universit\340 che proprio mancava.\r\n', 'gasp.jpg', 'moderatore-attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('157', NULL, NULL, 'trovo l''iniziativa estremamente utile.. sarebbe un peccato farla \r\nmorire ;-)  e poi contattare professori, parlare in aule rappresentano \r\nsicuramente un bel allenamento per il futuro.\r\n', 'jarod82.jpg', 'collaboratore attivit\340 off-line, moderatore corsi ');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('91', 'Studio ingegneria gestionale al 3 anno, sono studente fuori sede, proveniente da Fabriano. Tra un esame e l''altro i miei hobbyes sono l''informatica ed il netgaming mentre gli sports che seguo di pi\371 sono il Basket, lo Sci e la F1. Amo fare passeggiate in mountain bike quando tra le colline marchigianea e quass\371 a bologna mi orgnanizzo per le "partitelle con gli amici". In un certo senso apprezzo tutti i generi musicali senza distinzione, prediligo cmq pop e ska, ascolto molto la radio (105 4ever) e colleziono le musiche degli spots publicitari... \r\n', '3493940611', 'cercare di coltivare questa community perch\350, come si sa, l''unione fa la forza.... ', 'jolly82.jpg', 'moderatore - collaboratore nella sezione grafica');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('106', 'Studente di Ingegneria Gestionale con tante piccole passioni.All''interno di UniversiBo sono responsabile per alcuni esami e moderatore per altri. Mi occuper\362 inoltre della sezione Erasmus(col sogno di riuscire ad andarci anch''io un giorno ;-D). ', '3394489656', 'Sono tanti e sicuramente ne dimenticher\362 qualcuno. Tra di essi c''\350 sicuramente quello di capire ed usare (un passo per volta magari)i diversi linguaggi utilizzati nelle pagine del sito; la volont\340 di partecipare ad un progetto impossibile da realizzare alle superiori e che mi ha subito affascinato e trovato d''accordo; la voglia come sempre di contribuire a creare e fornire un aiuto per tutti i compagni di Universit\340 col pensiero che "insieme le difficolt\340 si superano meglio" e quindi con la speranza che tutti contribuiscano nel darsi una mano(anche se purtroppo ci sar\340 anche chi "sfrutter\340" solo il servizio vedendo nell''amico solo un "avversario"... mah...). ', 'dexter.jpg', 'moderatore');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('252', 'Antares \350 uno studente di Ingegneria Informatica', '3385403745 ', 'Il mio obiettivo \350 trovarmi una donna ad Ingegneria. Come un ago in un pagliaio.', NULL, 'Amministratore Attivit\340 Offline/Stesura Contenuti');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('81', 'brain \350 un caparbio studente di Ingegneria Informatica. Nel progetto si occupa del lavoro pi\371 importante: la progettazione del software e di buona parte della grafica.', '3381407176', 'Obiettivo iniziale del mio progetto era semplicemente mettere in pratica le prime conoscenze acquisite riguardo HTML, PHP e la realizzazione di applicazioni Web.\r\nAver portato avanti il mio primo progetto mi ha sicuramente fatto piacevolmente imparare molte cose e insieme al lato didattico sono arrivate enormi gratificazioni personali da altri amici, studenti e anche docenti, per aver creato nel mio piccolo qualcosa di grosso aiuto per gli altri... e queste gratificazioni mi hanno spinto ad impegnarmi ancora di pi\371 ad accrescere le mie conoscenze... un circolo virtuoso...\r\nAppena ho conosciuto altri due matti con un progetto simile al mio... beh, quale migliore occasione per aprire un manicomio... e subito altri matti hanno risposto all''appello \r\nOra c''\350 il piacere di poter imparare a lavorare in gruppo, dividere e condividere il lavoro pur mantenendo ognuno la libert\340 di fare quel che gli pare!!!\r\nNuove conoscenze... Progettazione e strutture grafiche web, Basi di Dati, Amministrazione e configurazione del web Server, Gestione di del Progetto in gruppo.... e ad approfondire quelle di prima (...\350 proprio vero che non si finisce mai di imparare!!!)', 'brain.jpg', 'admin - progettista software');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('307', NULL, '3470856915 ', 'so fare poco o nulla: io e i pc non siamo buoni amici, ma collaborare \r\nper universibo mi sembra una bella perdita di tempo : aiuto me, gli altri, \r\nimparo un sacco di cose, conosco ed imparo a lavorare con un sacco di gente simpatica... ', 'bulbis.jpg', 'attivit\340 offline');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('78', 'Studente di Ingegneria Gestionale da sempre fissato con l''informatica. Nel progetto si occupa in particolar modo della gestione e della documentazione.', '3394323246', 'Grazie all''iniziativa di matteo di fondare la mailing list dei gestionali, ho avuto l''opportunit\340 di gestire una comunit\340 di studenti. Gi\340 tale attivit\340 comporta una notevole spesa di tempo e sicuramente il carico del progetto sar\340 molto pi\371 pesante, ma so che quando il sito sar\340 realizzato la soddisfazione ripagher\340 tutte le fatiche. Il motivo forte che mi spinge ogni giorno a lavorare per il progetto \350 che ci\362 che faccio proprio mi piace: mi diverto a programmare, ma soprattutto mi piace dedicare tempo alla gestione del progetto e questo proprio perch\351 diventare direttore di progetti di innovazione(in particolar modo di software) \350 ci\362 che aspiro per il mio futuro. Quale miglior occasione per fare esperienza di questa?', 'eagleone.jpg', 'admin - gestione progetto e documentazione');
INSERT INTO "collaboratore" ("id_utente", "intro", "recapito", "obiettivi", "foto", "ruolo") VALUES ('87', 'Guapoz intorta le donnine ad Ingegneria.', NULL, 'L''obiettivo di Guapoz \350 inserirsi in quanti pi\371 pertugi possibili prima di diventare impotente, la notte del 25 dicembre del 2020.', 'guapoz.jpg', 'Fotti-zio.');






ALTER TABLE "file" RENAME TO "file2";

--ATTENZIONE qui bisogna fare a mano il drop della costrain sull'indice della tabella files2!!

CREATE TABLE "file" (
"id_file" int4 DEFAULT nextval('"file_id_file_seq"'::text) NOT NULL,
"permessi_download" int4 NOT NULL,
"permessi_visualizza" int4 NOT NULL,
"id_utente" int4 NOT NULL,
"titolo" varchar (150) NOT NULL,
"descrizione" text NULL,
"data_inserimento" int4 NOT NULL,
"data_modifica" int4 NOT NULL,
"dimensione" int4 NOT NULL,
"download" int4 NOT NULL,
"nome_file" varchar (256) NOT NULL,
"id_categoria" int4 NOT NULL,
"id_tipo_file" int4 NOT NULL,
"hash_file" varchar (40) NOT NULL,
"password" varchar (40) ,
"eliminato" char (1) NOT NULL ,
PRIMARY KEY ("id_file"));


CREATE TABLE "file_canale" (
"id_file" int4 NOT NULL, 
"id_canale" int4 NOT NULL ,
PRIMARY KEY ("id_file", "id_canale"));
CREATE INDEX "file_canale_id_file_key" ON "file_canale"("id_file"); 
CREATE INDEX "file_canale_id_canale_key" ON "file_canale"("id_canale");


CREATE TABLE "file_tipo" (
"id_file_tipo" SERIAL NOT NULL,
"descrizione" varchar (128) NOT NULL,
"pattern_riconoscimento" varchar (128) NOT NULL,
"icona" varchar (256) NOT NULL,
"info_aggiuntive" text,
PRIMARY KEY ("id_file_tipo"));


CREATE TABLE "file_categoria" (
"id_file_categoria" SERIAL NOT NULL,
"descrizione" varchar (128) NOT NULL,
PRIMARY KEY ("id_file_categoria"));

INSERT INTO file ( "id_file", "permessi_download", "permessi_visualizza", "id_utente",
"titolo", "descrizione", "data_inserimento", "data_modifica", "dimensione", "download",
"nome_file", "id_categoria", "id_tipo_file", "hash_file", "password", "eliminato" ) 
SELECT "id_file" , '127' , '127', "id_autore",
'' , "descrizione", data, data, dimensione, contatore,
nome_file, 0 , 0 , '', NULL, 'N' FROM file2;

--se in v1 un file era stato eliminato da tutti gli argomenti allora viene 
--impostato come eliminato
UPDATE file SET eliminato = 'S' WHERE id_file IN (
  SELECT id_file from file_riguarda_argomento WHERE eliminato = 'S' AND id_file NOT IN 
  (
    SELECT id_file from file_riguarda_argomento WHERE eliminato = 'N'
  )
  GROUP BY id_file 
);

UPDATE file SET titolo = substring(descrizione from 1 for 100);

-- eseguire lo script: index.php?do=ScriptUpdateFileHash



INSERT INTO file_categoria (id_file_categoria, descrizione) VALUES (
1, 'dispense');
INSERT INTO file_categoria (id_file_categoria, descrizione) VALUES (
2, 'esercitazioni');
INSERT INTO file_categoria (id_file_categoria, descrizione) VALUES (
3, 'lucidi');
INSERT INTO file_categoria (id_file_categoria, descrizione) VALUES (
4, 'appunti');
INSERT INTO file_categoria (id_file_categoria, descrizione) VALUES (
5, 'altro');

SELECT setval('file_categoria_id_file_categoria_seq', 5);
UPDATE file SET id_categoria = 5;


------08-09-04


INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
1, 'altro', '', 'formato_.gif', '');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
2, 'pdf', '\.pdf$', 'formato_pdf.gif', 'Adobe Portable Document Format');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
3, 'doc', '\.doc$', 'formato_doc.gif', 'Microsoft Word');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
4, 'gif', '\.gif$', 'formato_gif.gif', 'Graphic Interchange Format');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
5, 'html', '\.(html|htm)$', 'formato_html.gif', 'HyperText Mark-Up Language');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
6, 'jpeg', '\.(jpeg|jpg)$', 'formato_jpg.gif', 'Joint Photographic Experts Group');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
7, 'mp3', '\.mp3$', 'formato_mp3.gif', 'Mpeg1 Layer 3');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
8, 'sxw', '\.sxw$', 'formato_sxw.gif', 'Open Office Writer');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
9, 'sxc', '\.sxc$', 'formato_sxc.gif', 'Open Office Calc');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
10, 'sxi', '\.sxi$', 'formato_sxi.gif', 'Open Office Impress');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
11, 'ppt', '\.ppt$', 'formato_ppt.gif', 'Microsoft Power Point');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
12, 'rtf', '\.rtf$', 'formato_rtf.gif', 'Rich Text Format');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
13, 'tex', '\.tex$', 'formato_tex.gif', 'TeX Document');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
14, 'txt', '\.txt$', 'formato_txt.gif', 'File di testo');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
15, 'xls', '\.xls$', 'formato_xls.gif', 'Microsoft Excel');
INSERT INTO file_tipo (id_file_tipo, descrizione, pattern_riconoscimento, icona, info_aggiuntive) VALUES (
16, 'bmp', '\.bmp$', 'formato_bmp.gif', 'Bitmap');


