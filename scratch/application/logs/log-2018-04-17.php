<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-04-17 09:04:13 --> Severity: Notice --> Undefined variable: prev_id C:\xampp\htdocs\smis\application\modules\pages\views\reports\list_classes.php 71
ERROR - 2018-04-17 09:04:13 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\smis\application\modules\pages\views\reports\list_classes.php 71
ERROR - 2018-04-17 09:12:35 --> 404 Page Not Found: ../modules/pages/controllers/Ajax/update_course_pointera
ERROR - 2018-04-17 09:20:55 --> Severity: Notice --> Undefined property: CI::$general_helper C:\xampp\htdocs\smis\application\third_party\MX\Controller.php 59
ERROR - 2018-04-17 09:20:55 --> Severity: Error --> Call to a member function is_admin() on null C:\xampp\htdocs\smis\application\modules\pages\views\classes\activity_detail.php 9
ERROR - 2018-04-17 09:29:08 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp\htdocs\smis\application\modules\pages\views\classes\activity_detail.php 9
ERROR - 2018-04-17 09:29:08 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp\htdocs\smis\application\modules\pages\views\classes\activity_detail.php 9
ERROR - 2018-04-17 09:29:08 --> Severity: Notice --> Undefined property: stdClass::$id C:\xampp\htdocs\smis\application\modules\pages\views\classes\activity_detail.php 9
ERROR - 2018-04-17 09:29:56 --> 404 Page Not Found: ../modules/pages/controllers/classes/Lession_plan/delete_activity
ERROR - 2018-04-17 09:30:30 --> 404 Page Not Found: ../modules/pages/controllers/classes/Lession_plan/delete_activity
ERROR - 2018-04-17 09:49:14 --> Severity: Warning --> Missing argument 2 for Lession_plan::delete_activity() C:\xampp\htdocs\smis\application\modules\pages\controllers\classes\Lession_plan.php 655
ERROR - 2018-04-17 09:49:14 --> Severity: Notice --> Undefined variable: id C:\xampp\htdocs\smis\application\modules\pages\controllers\classes\Lession_plan.php 658
ERROR - 2018-04-17 09:50:53 --> Severity: Warning --> Missing argument 2 for Lession_plan::delete_activity() C:\xampp\htdocs\smis\application\modules\pages\controllers\classes\Lession_plan.php 655
ERROR - 2018-04-17 09:50:53 --> Severity: Notice --> Undefined variable: id C:\xampp\htdocs\smis\application\modules\pages\controllers\classes\Lession_plan.php 658
ERROR - 2018-04-17 09:50:53 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\classes\course_pointer.php 49
ERROR - 2018-04-17 10:01:20 --> Severity: Notice --> Undefined variable: prev_id C:\xampp\htdocs\smis\application\modules\pages\views\reports\list_classes.php 71
ERROR - 2018-04-17 10:01:20 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\smis\application\modules\pages\views\reports\list_classes.php 71
ERROR - 2018-04-17 10:03:00 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-17 10:08:01 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-17 10:18:13 --> Severity: Notice --> Undefined property: CI::$transportation_model C:\xampp\htdocs\smis\application\third_party\MX\Controller.php 59
ERROR - 2018-04-17 10:18:13 --> Severity: Error --> Call to a member function transportation_list() on null C:\xampp\htdocs\smis\application\modules\pages\controllers\reports\General_reports.php 727
ERROR - 2018-04-17 10:40:37 --> Query error: Unknown column 'transportation.bus_id' in 'on clause' - Invalid query: SELECT *
FROM `bus_stop` `bs`
JOIN `transport` `t` ON `transportation`.`bus_id` = `table`.`bus_id`
WHERE `bs`.`bus_id` = '13'
ERROR - 2018-04-17 10:40:39 --> Query error: Unknown column 'transportation.bus_id' in 'on clause' - Invalid query: SELECT *
FROM `bus_stop` `bs`
JOIN `transport` `t` ON `transportation`.`bus_id` = `table`.`bus_id`
WHERE `bs`.`bus_id` = '14'
ERROR - 2018-04-17 10:40:58 --> Query error: Unknown column 'table.bus_id' in 'on clause' - Invalid query: SELECT *
FROM `bus_stop` `bs`
JOIN `transport` `t` ON `t`.`bus_id` = `table`.`bus_id`
WHERE `bs`.`bus_id` = '13'
ERROR - 2018-04-17 11:19:21 --> Query error: Table 'smis.student_profile' doesn't exist - Invalid query: SELECT `b`.*, concat(e.first_name, " ", `e`.`middle_name`, " ", e.last_name) as emp_fullname, concat(sp.st_fname, " ", `sp`.`st_mname`, " ", sp.st_lname) as st_fullname
FROM `bug` `b`
LEFT JOIN `employee` `e` ON `e`.`employee_id` = `b`.`report_id`
LEFT JOIN `student_profile` `sp` ON `sp`.`st_id` = `b`.`report_id`
ORDER BY `id` DESC
ERROR - 2018-04-17 11:20:25 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_evaluation_overall.php 95
ERROR - 2018-04-17 11:22:57 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_evaluation_overall.php 95
ERROR - 2018-04-17 11:23:30 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_evaluation_overall.php 95
ERROR - 2018-04-17 11:23:48 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_evaluation_overall.php 95
ERROR - 2018-04-17 12:49:53 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 12:50:08 --> 404 Page Not Found: /index
ERROR - 2018-04-17 12:50:08 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:07:30 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 13:07:44 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:07:44 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:07:44 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:35:38 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:35:38 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:52:13 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 13:52:31 --> 404 Page Not Found: /index
ERROR - 2018-04-17 13:52:31 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:01:56 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:02:06 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:02:06 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:03:15 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:03:47 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:04:12 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:04:37 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:07:12 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:07:38 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:08:16 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:08:31 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:08:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:09:14 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:10:16 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:10:16 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:10:52 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:11:00 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:11:00 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:11:43 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:13:36 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:13:36 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:15 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:14:40 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:14:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:19 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:27 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:28 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:15:46 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:16:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:16:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:21:12 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:22:53 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:02 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:02 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:29 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:39 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:40 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:40 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:40 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:40 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:24:49 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:03 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:13 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:25:18 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:29 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:25:39 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\roll_no_reassign.php 90
ERROR - 2018-04-17 14:26:19 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:30 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:26:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:27:02 --> Severity: Notice --> Undefined property: stdClass::$guardian_relation C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_student.php 487
ERROR - 2018-04-17 14:27:56 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-17 14:27:57 --> Severity: Notice --> Undefined property: stdClass::$guardian_relation C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_student.php 487
ERROR - 2018-04-17 14:29:52 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-17 14:30:17 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-04-17 14:30:33 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\feedback_list.php 95
ERROR - 2018-04-17 14:34:52 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:35:20 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\st_bulk_edit.php 90
ERROR - 2018-04-17 14:35:44 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:35:58 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:36:36 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:36:43 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:36:43 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:37:29 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:38:21 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\feedback_list.php 71
ERROR - 2018-04-17 14:39:19 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\reassign_student.php 90
ERROR - 2018-04-17 14:39:22 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 14:39:53 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:50 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:50 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\feedback_list.php 71
ERROR - 2018-04-17 14:40:54 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:54 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:40:57 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:05 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\feedback_list.php 71
ERROR - 2018-04-17 14:41:34 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:34 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:42 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:45 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\feedback_list.php 63
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:47 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:51 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:41:52 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:42:01 --> 404 Page Not Found: /index
ERROR - 2018-04-17 14:46:58 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\reports\student_list.php 90
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 40
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 46
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 52
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 58
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 64
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 70
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 76
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 82
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 90
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 91
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 92
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 104
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 104
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 112
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 118
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 126
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 127
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 134
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 142
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 143
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 144
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 151
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 157
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 163
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 169
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 177
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 183
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 186
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 186
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 40
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 46
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 52
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 58
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 64
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 70
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 76
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 82
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 90
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 91
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 92
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 104
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 104
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 112
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 118
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 126
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 127
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 134
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 142
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 143
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 144
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 151
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 157
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 163
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 169
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 177
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 183
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 186
ERROR - 2018-04-17 14:50:16 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_employee.php 186
ERROR - 2018-04-17 15:42:00 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-04-17 15:42:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:09 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:10 --> 404 Page Not Found: /index
ERROR - 2018-04-17 15:42:16 --> Severity: Notice --> Undefined property: stdClass::$guardian_relation C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_student.php 487
