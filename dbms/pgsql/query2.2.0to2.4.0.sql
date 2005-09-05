--LastHope 27-08-2005

ALTER TABLE "info_didattica" ADD "orario_ics_link" character varying(256);
UPDATE "info_didattica" SET orario_ics_link = ' ';
ALTER TABLE "info_didattica" ALTER COLUMN "orario_ics_link" SET NOT NULL;
