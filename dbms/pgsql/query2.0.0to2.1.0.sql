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
UPDATE canale SET forum_attivo = 'N' WHERE forum_attivo = ''