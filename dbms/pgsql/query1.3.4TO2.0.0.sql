#--rimozione triggers
DROP TRIGGER "RI_ConstraintTrigger_1295070" ON utente;
DROP TRIGGER "RI_ConstraintTrigger_1295048" ON orientamenti;
DROP TRIGGER "RI_ConstraintTrigger_1295049" ON orientamenti;
DROP TRIGGER "RI_ConstraintTrigger_1295050" ON orientamenti;
DROP TRIGGER "RI_ConstraintTrigger_1295051" ON orientamenti;
DROP TRIGGER "RI_ConstraintTrigger_1295052" ON facolta;
DROP TRIGGER "RI_ConstraintTrigger_1295054" ON facolta;
DROP TRIGGER "RI_ConstraintTrigger_1295055" ON classi_indirizzi;
DROP TRIGGER "RI_ConstraintTrigger_1295057" ON classi_orientamenti;
DROP TRIGGER "RI_ConstraintTrigger_1295059" ON news;
DROP TRIGGER "RI_ConstraintTrigger_1295060" ON news;
DROP TRIGGER "RI_ConstraintTrigger_1295061" ON file_riguarda_argomento;
DROP TRIGGER "RI_ConstraintTrigger_1295062" ON utente_argomento;
DROP TRIGGER "RI_ConstraintTrigger_1295063" ON utente_argomento;
DROP TRIGGER "RI_ConstraintTrigger_1295065" ON classi_corso;
DROP TRIGGER "RI_ConstraintTrigger_1295066" ON argomento;
DROP TRIGGER "RI_ConstraintTrigger_1295068" ON utente;

#-- modifiche phpbb 2.0.6
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
#-- modifiche tabella utente livello -> groups
ALTER TABLE "utente" ADD "groups" int4 ;

UPDATE "utente" SET "groups" = 2 WHERE "livello" = 100;
UPDATE "utente" SET "groups" = 4 WHERE "livello" = 200;
UPDATE "utente" SET "groups" = 8 WHERE "livello" = 300;
UPDATE "utente" SET "groups" = 16 WHERE "livello" = 400;
UPDATE "utente" SET "groups" = 32 WHERE "livello" = 600;
UPDATE "utente" SET "groups" = 64 WHERE "livello" = 500;

ALTER TABLE "utente" DROP COLUMN "livello";
#-- collegamento corso->facoltà
ALTER TABLE "classi_corso" ADD "cod_fac" varchar (4) ;

UPDATE classi_corso SET cod_fac = '0054' WHERE cod_corso IN ('0025', '0023', '0221', '0218', '0025', '5402', '0022', '5407');
UPDATE classi_corso SET cod_fac = '0021' WHERE cod_corso NOT IN ('0025', '0023', '0221', '0218', '0025', '5402', '0022');
#-- creazione tabella canale   (si poteva fare in modo molto più semplice... vedi utente_canale)
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
#-- importa dati argomento->canale
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
#-- modifica utente_argomento
ALTER TABLE "utente_argomento" RENAME "id_argomento" TO "id_canale"; ALTER TABLE "utente_argomento" ALTER "id_canale" DROP DEFAULT ;
ALTER TABLE "utente_argomento" ADD "ruolo" int4 ;
ALTER TABLE "utente_argomento" ADD "my_universibo" char (1) ;
ALTER TABLE "utente_argomento" RENAME TO "utente_canale";

UPDATE utente_canale SET my_universibo='S' WHERE 1=1;
UPDATE utente_canale SET ruolo=1 WHERE diritti='M';
UPDATE utente_canale SET ruolo=2 WHERE diritti='R';

ALTER TABLE "utente_canale" DROP COLUMN "diritti";
#-- nuovi campi in utente_argomento
ALTER TABLE "utente_canale" ADD "notifica" int4 ;
ALTER TABLE "utente_canale" ADD "nome" char (60) ;

#-- 15-9-2003
#-- nuovi campi in canale
ALTER TABLE "canale" ADD "links_attivo" char (1) ;     

#-- 16-9-2003
SELECT setval('canale_id_canale_seq', nextval('argomento_id_argomento_seq'));
UPDATE canale SET nome_canale = 'Homepage', permessi_groups=127 WHERE id_canale=1;

#-- 17-9-2003
ALTER TABLE "facolta" RENAME "id_argomento" TO "id_canale"; 

#-- ATTENZIONE non ho avuto la possibilità di testare le seguenti 4 query.
UPDATE facolta SET id_canale = 2, url_facolta='http://www.ing.unibo.it' WHERE cod_fac='0021';
UPDATE canale SET visite =0, ultima_modifica=0, permessi_groups=127, files_attivo='N', news_attivo='S', forum_attivo='N', links_attivo='N' WHERE id_canale = 2;
INSERT INTO canale (tipo_canale,visite, ultima_modifica, permessi_groups, files_attivo, news_attivo, forum_attivo, links_attivo ) VALUES (3, 0, 0, 127, 'N', 'S', 'N', 'N');
UPDATE facolta SET url_facolta='http://www.economia.unibo.it' WHERE cod_fac='0054';
#-- @todo IMPORTANTE!!!! manualmente aggiornare id_canale nella tabella facolta riguardo la tupla di economia ...lo si legge dopo la insert due query più su

#-- 18-9-2003
ALTER TABLE "classi_corso" RENAME "id_argomento" TO "id_canale"; 


