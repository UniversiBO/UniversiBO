
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

