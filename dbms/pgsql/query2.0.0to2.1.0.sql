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
