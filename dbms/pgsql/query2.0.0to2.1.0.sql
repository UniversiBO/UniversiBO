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







-- LASCIATE QUESTI COMMENTO IN FONDO - 04/03/2005 - brain

-- SELECT id_utente, user_email, email FROM phpbb_users, utente WHERE id_utente = user_id AND user_email != email
-- bisogna correggere e far diventare tutte le mail del forum uguali a quelle del sito se sono diverse 
-- (manualmente?) oppure pensate ad una query che lo faccia: ci ho provato 5 min ma non mi veniva in mente come fare

-- SELECT id_utente, phone FROM utente WHERE phone != '' OR phone IS NULL
-- bisogna correggere tutti i numeri di telefono manualmente nel formato +xxyyyzzzzzzz