<?php

require_once(PHPWS_SOURCE_DIR . 'inc/nomination_defines.php');

  /*************************
   * Nomination categories *
   *************************/
// Plemmons Categories
define('NOMINATION_STUDENT_LEADER',       0);
define('NOMINATION_STUDENT_EDUCATOR', 1);
define('NOMINATION_FACULTY_MEMBER',       2);
define('NOMINATION_EMPLOYEE',             3);

define('NOMINATION_STUDENT_LEADER_TEXT', 'Student Leader');
define('NOMINATION_STUDENT_EDUCATOR_TEXT', 'Student Development Educator');
define('NOMINATION_FACULTY_MEMBER_TEXT', 'Faculty Member');
define('NOMINATION_EMPLOYEE_TEXT', 'Employee of ASU');

// Student conduct categories...
// TODO: This is a hack. We should make these categories more configurable.
define('APP_STUDENT_CONDUCT_BOARD', 0);
define('APP_ACADEMIC_INTEGRITY_BOARD', 1);
define('APP_BOTH', 2);

define('CONDUCT_TEXT', 'Student Conduct Board');
define('INTEGRITY_TEXT', 'Academic Integrity Board');
define('BOTH_TEXT', 'Both Student Conduct &amp; Academic Integrity Boards');


define('NOMINATION_EMAIL_DOMAIN', 'appstate.edu');
define('EMAIL_TEST_FLAG', FALSE);

define('NOMINATOR', 'NTR');
define('REFERENCE', 'REF');
define('NOMINEE', 'NEE');
