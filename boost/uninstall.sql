DROP TABLE IF EXISTS nomination_nominee;
DROP TABLE IF EXISTS nomination_nominator;
DROP TABLE IF EXISTS nomination_nomination;
DROP TABLE IF EXISTS nomination_reference;
DROP TABLE IF EXISTS nomination_permissions;
DROP TABLE IF EXISTS nomination_period;
DROP TABLE IF EXISTS nomination_doc;
DROP TABLE IF EXISTS nomination_email_log;
DROP TABLE IF EXISTS nomination_cancel_queue;

DROP TABLE IF EXISTS nomination_nominee_seq;
DROP TABLE IF EXISTS nomination_nominator_seq;
DROP TABLE IF EXISTS nomination_nomination_seq;
DROP TABLE IF EXISTS nomination_reference_seq;
DROP TABLE IF EXISTS nomination_period_seq;
DROP TABLE IF EXISTS nomination_doc_seq;
DROP TABLE IF EXISTS nomination_email_log_seq;
DROP TABLE IF EXISTS nomination_cancel_queue_seq;

DROP TABLE IF EXISTS nomination_document;
DROP TABLE IF EXISTS nomination_document_seq;
DROP TABLE IF EXISTS nomination_nomination;
DROP TABLE IF EXISTS nomination_period;
DROP TABLE IF EXISTS nomination_referencel;

DELETE FROM pulse_schedule where module = 'nomination';
DELETE FROM users_groups where name = 'nomination_committee';
DELETE FROM mod_settings where module = 'nomination';
