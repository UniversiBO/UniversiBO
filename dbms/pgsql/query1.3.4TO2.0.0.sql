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

#-- query statistiche universibo 1.3.4
SELECT DISTINCT anno_corso_universibo, q1.id_argomento, 
	anno_accademico, q1.cod_corso,
	q1.tipo_ciclo, q1.desc_materia, q1.cod_ril, q1.nome_doc, username, livello,
	ultimo_login, ultimo_accesso, "Num stud", "Num files online", "Num news online", visite, forum_posts,
    programma_esame, programma_esame_link ,testi_consigliati ,modalita_esame ,faq_link ,obiettivi_esame ,obiettivi_esame_link 

,modalita_esame_link ,testi_consigliati_link ,homepage_esame_link ,appelli_esame ,appelli_esame_link  
FROM ((
	SELECT h.anno_corso_universibo, h.anno_corso_ins, h.id_argomento, 
	h.anno_accademico, h.cod_corso,h.cod_ind, h.cod_ori, h.cod_materia, h.anno_corso,
	h.cod_materia_ins, h.cod_ril, h.tipo_ciclo, g.desc_materia, i.nome_doc 
		FROM esami_attivi h, classi_materie g, docente i
		WHERE h.cod_materia_ins=g.cod_materia 
		AND h.cod_doc=i.cod_doc 
		AND h.cod_corso='0049'
		AND h.anno_accademico='2002')
	UNION 
	(SELECT s.anno_corso_universibo, s.anno_corso_ins,
	 e.id_argomento, s.anno_accademico, s.cod_corso,
	 s.cod_ind, s.cod_ori, s.cod_materia, s.anno_corso,
	 s.cod_materia_ins, s.cod_ril, e.tipo_ciclo,
	 f.desc_materia, d.nome_doc 
		FROM esami_attivi e, sdoppiamenti_attivi s, classi_materie f, docente d 
		WHERE e.anno_accademico=s.anno_accademico_fis 
		AND e.cod_corso=s.cod_corso_fis 
		AND e.cod_ind=s.cod_ind_fis 
		AND e.cod_ori=s.cod_ori_fis 
		AND e.cod_materia=s.cod_materia_fis 
		AND s.cod_materia_ins=f.cod_materia 
		AND e.anno_corso=s.anno_corso_fis 
		AND e.cod_materia_ins=s.cod_materia_ins_fis 
		AND e.anno_corso_ins=s.anno_corso_ins_fis 
		AND e.cod_ril=s.cod_ril_fis
		AND e.cod_doc=d.cod_doc  AND s.cod_corso='0049'
		AND s.anno_accademico='2002' ORDER BY 1, 4, 6)
     ) AS q1 

     LEFT JOIN 
      (SELECT id_argomento, count(diritti) AS "Num stud"
FROM utente_argomento WHERE diritti='F' GROUP BY id_argomento) AS q4 USING (id_argomento) 
	
    LEFT JOIN (SELECT id_argomento, count(id_file) AS "Num files online" 
    	FROM file_riguarda_argomento WHERE
		eliminato='N' GROUP BY id_argomento
    ) AS q5 USING(id_argomento) 
    LEFT JOIN 
    (SELECT id_argomento, count(id_news) AS "Num news online" 
    	FROM news WHERE eliminata='N' GROUP BY id_argomento
    ) AS q6 USING (id_argomento) 
    LEFT JOIN 
    (SELECT id_argomento, visite, forum_posts 
    	FROM argomento LEFT JOIN phpbb_forums ON forum_id=id_forum
    ) AS q7 USING (id_argomento)
	LEFT JOIN esami_info 
     USING (id_argomento)

     LEFT JOIN (
     	SELECT id_argomento, username, livello, ultimo_login, ultimo_accesso
        	FROM utente_argomento LEFT JOIN utente
			USING (id_utente) 
            WHERE diritti!='F'
     )AS q3 USING (id_argomento) ORDER BY anno_corso_universibo ASC, id_argomento ASC, desc_materia, livello DESC
     