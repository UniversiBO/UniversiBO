--LastHope 27-08-2005

ALTER TABLE "info_didattica" ADD "orario_ics_link" character varying(256);
UPDATE "info_didattica" SET orario_ics_link = ' ';
ALTER TABLE "info_didattica" ALTER COLUMN "orario_ics_link" SET NOT NULL;


--evaimitico 22/09/2005
UPDATE canale SET links_attivo = 'S' WHERE id_canale = '25'

--03-02-2006 LastHope
--Questa query non esiste sul CVS, ma puo' essere che il vostro db sia gia' sistemato...vedete voi
CREATE TABLE docente_contatti (
    cod_doc character varying(6) NOT NULL,
    stato integer DEFAULT 1 NOT NULL,
    id_utente_assegnato integer,
    ultima_modifica integer,
    report text DEFAULT ''::text NOT NULL
);
ALTER TABLE ONLY docente_contatti
    ADD CONSTRAINT docente_contatti_pkey PRIMARY KEY (cod_doc);
    
--07-02-2006 LastHope
--Altra query che non esiste sul CVS

create table rb_docente(
IDUtente int primary key,
NomeOggetto char(9),
GuidUser char(32),
LogonName varchar(50),
Nome varchar(30),
Cognome varchar(40),
PrefissoNome varchar(15),
SuffissoNome varchar(10),
Sesso smallint,
Email varchar(50),
cod_doc char(6),
NomeOggettoStruttura char(9),
DescrizioneStruttura varchar(100) 
);

create table rb_email(
IDUtente int,
SeqEmailUtente smallint,
DescrizioneEMailUtente varchar(50),
primary key(IDUtente,SeqEmailUtente)
);

create table rb_telefono(
IDUtente int,
SeqTelUtente smallint,
DescrizioneTelUtente varchar(28),
Voice smallint,
Fax smallint,
TipoTel varchar(15),
primary key(IDUtente, SeqTelUtente)
);

--------------------------------

create table rub_docente(
cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
Nome varchar(30), --nome docente
Cognome varchar(40),  --cognome docente
PrefissoNome varchar(15),  --prefisso tipo "dott." "prof."
Sesso smallint,  --sesso  1=maschile 2=femminile
Email varchar(50),  --email 
DescrizioneStruttura varchar(100), --descrizione del dipartimento o struttura al quale il docente afferisce
flag_origine smallint ); --origine dei dati: 1=inseriti da DSA, 0=inseriti manualmente

create table rub_email(
cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
SeqEmailUtente smallint,  --numero di sequenza dell'e-mail (nel caso il docente abbia più e-mail)
DescrizioneEMailUtente varchar(50) --e-mail
);

create table rub_telefono(
cod_doc char(6),  --codice docente del cesia e della nostra tabella "docente"
SeqTelUtente smallint,  --numero di sequnza del telefono (nel caso il docente abbià più numeri di telefono)
DescrizioneTelUtente varchar(28), --telefono
Voice smallint, --servizio voce 1=si 0=no
Fax smallint  --servizio fax 1=si 0=no
);

---------------------------------------
insert into rub_docente (select cod_doc, Nome, Cognome, PrefissoNome, Sesso, Email, DescrizioneStruttura, 1
                         from rb_docente);

insert into rub_email (select d.cod_doc, e.SeqEmailUtente, e.DescrizioneEmailUtente
                        from rb_docente d, rb_email e
                        where d.IDUtente=e.IDUtente);

insert into rub_telefono (select d.cod_doc, t.SeqTelUtente, t.DescrizioneTelUtente, t.Voice, t.Fax
                          from rb_docente d, rb_telefono t
                          where d.IDUtente=t.IDUtente);
