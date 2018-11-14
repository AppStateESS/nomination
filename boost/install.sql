BEGIN;

CREATE TABLE nomination_nomination (
       id               INT NOT NULL DEFAULT 1,
       banner_id        INT,
       first_name       VARCHAR(64) NOT NULL,
       middle_name      VARCHAR(64),
       last_name        VARCHAR(64) NOT NULL,
       email            VARCHAR(255) NOT NULL,
       asubox           VARCHAR(10),
       position         VARCHAR(255),
       department_major VARCHAR(64), 
       years_at_asu     SMALLINT,
       phone            VARCHAR(16),
       gpa              VARCHAR(8),
       class            VARCHAR(255),
       responsibility   SMALLINT,
       category         INT,
       nominator_first_name     VARCHAR(255),
       nominator_middle_name    VARCHAR(255),
       nominator_last_name      VARCHAR(255),
       nominator_email          VARCHAR(255),
       nominator_phone          VARCHAR(32),
       nominator_address        VARCHAR(255),
       nominator_unique_id      VARCHAR(32),
       nominator_doc_id         INT NULL REFERENCES nomination_doc(id),
       nominator_relation       VARCHAR(255),
       complete                 SMALLINT DEFAULT 0,
       period                   SMALLINT NOT NULL,
       added_on                 INT NOT NULL,
       updated_on               INT NOT NULL,
       alternate_award          VARCHAR(200) DEFAULT NULL,
       winner                   SMALLINT DEFAULT NULL,
       PRIMARY KEY (id)
);

CREATE TABLE nomination_reference (
       id               INT NOT NULL DEFAULT 1,
       nomination_id    INT NOT NULL REFERENCES nomination_nomination(id),
       first_name       VARCHAR(64) NOT NULL,
       last_name        VARCHAR(64) NOT NULL,
       email            VARCHAR(255),
       phone            VARCHAR(32),
       department       VARCHAR(64),
       relationship     VARCHAR(255),
       unique_id        VARCHAR(32),
       doc_id           INT NULL REFERENCES nomination_doc(id),
       PRIMARY KEY (id)
);
 
CREATE TABLE nomination_period (
       id         INT NOT NULL DEFAULT 1,
       year       SMALLINT NOT NULL, 
       start_date INT,
       end_date   INT,
       PRIMARY KEY (id)
);

CREATE TABLE nomination_document (
       id               INT NOT NULL,
       nomination_id    INT NOT NULL REFERENCES nomination_nomination(id),
       uploaded_by      VARCHAR(255),
       description      VARCHAR(255),
       file_path        VARCHAR(1024),
       file_name        VARCHAR(1024),
       orig_file_name   VARCHAR(1024),
       mime_type        VARCHAR(1024),
       PRIMARY KEY(id)
);

CREATE TABLE nomination_email_log (
       id            INT NOT NULL DEFAULT 1,
       nominee_id    INT NOT NULL,
       message       TEXT,
       message_type  CHAR(6) NOT NULL,
       subject       TEXT,
       receiver_id   INT NOT NULL,
       receiver_type CHAR(3) NOT NULL,
       sent_on       INT NOT NULL,
       PRIMARY KEY(id)
);

CREATE TABLE nomination_cancel_queue (
       nomination INTEGER NOT NULL REFERENCES nomination_nomination(id),
       PRIMARY KEY(nomination)
);
COMMIT;
