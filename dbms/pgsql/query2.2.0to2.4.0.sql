--LastHope 27-08-2005

ALTER TABLE "info_didattica" ADD "orario_ics_link" character varying(256);
UPDATE "info_didattica" SET orario_ics_link = ' ';
ALTER TABLE "info_didattica" ALTER COLUMN "orario_ics_link" SET NOT NULL;


--evaimitico 22/09/2005
UPDATE canale SET links_attivo = 'S' WHERE id_canale = '25'

--03-02-2005 LastHope
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