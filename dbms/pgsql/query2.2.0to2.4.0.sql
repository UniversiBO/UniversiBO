--LastHope 27-08-2005

ALTER TABLE "info_didattica" ADD "orario_ics_link" character varying(256);
UPDATE "info_didattica" SET orario_ics_link = ' ';
ALTER TABLE "info_didattica" ALTER COLUMN "orario_ics_link" SET NOT NULL;


--evaimitico 22/09/2005
UPDATE canale SET links_attivo = 'S' WHERE id_canale = '25';

--03-02-2006 LastHope
--Questa query non esiste sul CVS, ma puo' essere che il vostro db sia gia' sistemato...vedete voi
--CREATE TABLE docente_contatti (
--    cod_doc character varying(6) NOT NULL,
--    stato integer DEFAULT 1 NOT NULL,
--    id_utente_assegnato integer,
--    ultima_modifica integer,
--    report text DEFAULT ''::text NOT NULL
--);
--ALTER TABLE ONLY docente_contatti
--    ADD CONSTRAINT docente_contatti_pkey PRIMARY KEY (cod_doc);
    
--07-02-2006 LastHope
--Altra query che non esiste sul CVS

--create table rb_docente(
--IDUtente int primary key,
--NomeOggetto char(9),
--GuidUser char(32),
--LogonName varchar(50),
--Nome varchar(30),
--Cognome varchar(40),
--PrefissoNome varchar(15),
--SuffissoNome varchar(10),
--Sesso smallint,
--Email varchar(50),
--cod_doc char(6),
--NomeOggettoStruttura char(9),
--DescrizioneStruttura varchar(100) 
--);

--create table rb_email(
--IDUtente int,
--SeqEmailUtente smallint,
--DescrizioneEMailUtente varchar(50),
--primary key(IDUtente,SeqEmailUtente)
--);

--create table rb_telefono(
--IDUtente int,
--SeqTelUtente smallint,
--DescrizioneTelUtente varchar(28),
--Voice smallint,
--Fax smallint,
--TipoTel varchar(15),
--primary key(IDUtente, SeqTelUtente)
--);

--------------------------------

--create table rub_docente(
--cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
--Nome varchar(30), --nome docente
--Cognome varchar(40),  --cognome docente
--PrefissoNome varchar(15),  --prefisso tipo "dott." "prof."
--Sesso smallint,  --sesso  1=maschile 2=femminile
--Email varchar(50),  --email 
--DescrizioneStruttura varchar(100), --descrizione del dipartimento o struttura al quale il docente afferisce
--flag_origine smallint ); --origine dei dati: 1=inseriti da DSA, 0=inseriti manualmente

--create table rub_email(
--cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
--SeqEmailUtente smallint,  --numero di sequenza dell'e-mail (nel caso il docente abbia più e-mail)
--DescrizioneEMailUtente varchar(50) --e-mail
--);

--create table rub_telefono(
--cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
--SeqTelUtente smallint,  --numero di sequnza del telefono (nel caso il docente abbià più numeri di telefono)
--DescrizioneTelUtente varchar(28), --telefono
--Voice smallint, --servizio voce 1=si 0=no
--Fax smallint  --servizio fax 1=si 0=no
--);

---------------------------------------
--insert into rub_docente (select cod_doc, Nome, Cognome, PrefissoNome, Sesso, Email, DescrizioneStruttura, 1
--                         from rb_docente);

--insert into rub_email (select d.cod_doc, e.SeqEmailUtente, e.DescrizioneEmailUtente
--                        from rb_docente d, rb_email e
--                        where d.IDUtente=e.IDUtente);

--insert into rub_telefono (select d.cod_doc, t.SeqTelUtente, t.DescrizioneTelUtente, t.Voice, t.Fax
--                          from rb_docente d, rb_telefono t
--                          where d.IDUtente=t.IDUtente);
                          
   
-- evaimitico  12/05/2006
CREATE TABLE "informativa" (
"id_informativa" integer DEFAULT nextval('"informativa_id_informativa_seq"'::text) NOT NULL,
"data_pubblicazione" integer NOT NULL,
"data_fine" integer,
"testo" text NOT NULL,
PRIMARY KEY ("id_informativa"));


CREATE SEQUENCE "informativa_id_informativa_seq" INCREMENT 1 MINVALUE 1 START 1 CACHE 1;


insert into "informativa" ("data_pubblicazione","testo")
VALUES (1147431647,'INFORMATIVA AI SENSI DELLA LEGGE 31 DICEMBRE 1996 N. 675/96
Ai sensi e per gli effetti dell\'art.13 L.675/96 informiamo di quanto segue:

1. In relazione al trattamento di dati personali l\'interessato ha diritto:   a) di conoscere, mediante accesso gratuito al registro di cui all\'articolo 31, comma 1, lettera a), l\'esistenza di trattamenti di dati che possono riguardarlo;
  b) di essere informato su quanto indicato all\'articolo 7, comma 4, lettere a), b) e h);
  c) di ottenere, a cura del titolare o del responsabile, senza ritardo:
    1) la conferma dell\'esistenza o meno di dati personali che lo riguardano, anche se non ancora registrati, e la comunicazione in forma intelligibile dei medesimi dati e della loro origine, nonchè della logica e delle finalità su cui si basa il trattamento; la richiesta può essere rinnovata, salva l\'esistenza di giustificati motivi, con intervallo non minore di novanta giorni;
    2) la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;
    3) l\'aggiornamento, la rettificazione ovvero, qualora vi abbia interesse, l\'integrazione dei dati;
    4) l\'attestazione che le operazioni di cui ai numeri 2) e 3) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si riveli impossibile o comporti un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato;
  d) di opporsi, in tutto o in parte, per motivi legittimi, al trattamento dei dati personali che lo riguardano, ancorchè pertinenti allo scopo della raccolta;
  e) di opporsi, in tutto o in parte, al trattamento di dati personali che lo riguardano, previsto a fini di informazione commerciale o di invio di materiale pubblicitario o di vendita diretta ovvero per il compimento di ricerche di mercato o di comunicazione commerciale interattiva e di essere informato dal titolare, non oltre il momento in cui i dati sono comunicati o diffusi, della possibilità di esercitare gratuitamente tale diritto.

2. Per ciascuna richiesta di cui al comma 1, lettera c), numero 1), può essere chiesto all\'interessato, ove non risulti confermata l?esistenza di dati che lo riguardano, un contributo spese, non superiore ai costi effettivamente sopportati, secondo le modalità ed entro i limiti stabiliti dal regolamento di cui all\'articolo 33, comma 3.

3. I diritti di cui al comma 1 riferiti ai dati personali concernenti persone decedute possono essere esercitati da chiunque vi abbia interesse.

4. Nell\'esercizio dei diritti di cui al comma 1 l\'interessato può conferire, per iscritto, delega o procura a persone fisiche o ad associazioni.

5. Restano ferme le norme sul segreto professionale degli esercenti la professione di giornalista, limitatamente alla fonte della notizia
');


--tabelle necessarie per capire lo stato delle interazione dell'utente con i vari InteractiveCommand

CREATE TABLE "step_log" (
"id_step" integer DEFAULT nextval('"step_id_step_seq"'::text) NOT NULL,
"id_utente" integer NOT NULL,
"data_ultima_interazione" integer NOT NULL,
"nome_classe" varchar(255) NOT NULL,
"esito_positivo" char(1),
PRIMARY KEY ("id_step"));

CREATE SEQUENCE "step_id_step_seq" INCREMENT 1 MINVALUE 1 START 1 CACHE 1;


CREATE TABLE "step_parametri" (
"id_step" integer NOT NULL,
"callback_name" varchar(255) NOT NULL,
"param_name" varchar(255) NOT NULL,
"param_value" varchar(255) NOT NULL     -- andrà bene come dimensione? forse è meglio un altro tipo
);


-- 24/05/06  evaimitico
ALTER TABLE utente ADD sospeso char(1);
UPDATE utente SET sospeso = 'N' WHERE 1=1;
ALTER TABLE utente ALTER COLUMN sospeso SET NOT NULL;
ALTER TABLE utente ALTER COLUMN sospeso SET DEFAULT 'N';

-- 6-9-07 evaimitico
CREATE SEQUENCE prg_sdop_id_sdop_seq;
ALTER TABLE prg_sdoppiamento ADD COLUMN id_sdop INTEGER;
UPDATE prg_sdoppiamento SET id_sdop = nextval('prg_sdop_id_sdop_seq');
ALTER TABLE prg_sdoppiamento ALTER COLUMN id_sdop SET DEFAULT nextval('prg_sdop_id_sdop_seq');
ALTER TABLE prg_sdoppiamento ALTER COLUMN id_sdop SET NOT NULL;

-- in didatticagestione si può riusare l'help che riguarda la ricerca di username
INSERT INTO help_riferimento (riferimento, id_help) VALUES ('didatticagestione', 2); 

INSERT INTO help_topic (riferimento, titolo, indice) VALUES ('didatticagestione','Modificare un insegnamento e cercare un codice docente (solo admin e collaboratori)',100);