<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-04-18 09:23:22 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-18 09:23:43 --> Severity: Notice --> Undefined property: CI::$employee_control_model C:\xampp\htdocs\smis\application\third_party\MX\Controller.php 59
ERROR - 2018-04-18 09:23:43 --> Severity: Error --> Call to a member function get_teachers() on null C:\xampp\htdocs\smis\application\modules\pages\controllers\reports\General_reports.php 808
ERROR - 2018-04-18 11:36:39 --> Severity: Notice --> Undefined variable: st_id C:\xampp\htdocs\smis\application\modules\pages\models\ajax_model.php 736
ERROR - 2018-04-18 12:35:32 --> Query error: Column 'user_id' in where clause is ambiguous - Invalid query: SELECT `stc`.*, CONCAT(s.st_fname, " ", `st_mname`, " ", st_lname) st_fullname
FROM `st_comment` `stc`
JOIN `student` `s` ON `s`.`student_id` = `stc`.`student_id`
WHERE date(comment_date) BETWEEN '2018-04-02' AND '2018-04-05'
AND `user_id` = '11'
ERROR - 2018-04-18 15:46:51 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-18 15:48:15 --> Severity: Notice --> Undefined variable: prev_id C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_overall.php 100
ERROR - 2018-04-18 15:48:28 --> Severity: Notice --> Undefined variable: prev_id C:\xampp\htdocs\smis\application\modules\pages\views\reports\current_student_overall.php 77
ERROR - 2018-04-18 15:49:01 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_list.php 90
