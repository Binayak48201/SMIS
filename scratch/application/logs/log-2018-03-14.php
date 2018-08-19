<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-03-14 14:03:27 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\st_attendance_report.php 95
ERROR - 2018-03-14 14:03:38 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-03-14 14:03:54 --> Severity: Notice --> Undefined variable: sections C:\xampp\htdocs\smis\application\modules\pages\views\profile\manage_student.php 88
ERROR - 2018-03-14 14:49:45 --> Query error: Unknown table 'smis.st' - Invalid query: SELECT `st`.*, `sh`.*, `d`.*, `h`.*, `t`.*, `sc`.*, `fo`.`occupation_name` as `father_occupation`, `mo`.`occupation_name` as `mother_occupation`, `gu`.`occupation_name` as `gaudian_occupation`, CONCAT(e.first_name, " ", `e`.`middle_name`, " ", e.last_name) as emp_fullname
FROM `student` `s`
LEFT JOIN `school` `sh` ON `sh`.`school_id` = `s`.`last_school_id`
LEFT JOIN `district` `d` ON `d`.`district_id` = `s`.`district_id`
LEFT JOIN `house` `h` ON `h`.`house_id` = `s`.`house_id`
LEFT JOIN `bus_stop` `bs` ON `bs`.`stop_id` = `s`.`stop_id`
LEFT JOIN `transport` `t` ON `t`.`bus_id` = `bs`.`bus_id`
LEFT JOIN `occupation` `fo` ON `fo`.`occupation_id` = `s`.`father_occupation_id`
LEFT JOIN `occupation` `mo` ON `mo`.`occupation_id` = `s`.`mother_occupation_id`
LEFT JOIN `occupation` `gu` ON `gu`.`occupation_id` = `s`.`guardian_occupation_id`
LEFT JOIN `section` `sc` ON `sc`.`section_id` = `s`.`class_id`
LEFT JOIN `employee` `e` ON `e`.`employee_id` = `s`.`class_teacher_id`
WHERE `s`.`student_id` = '1214'
ERROR - 2018-03-14 14:50:06 --> Query error: Unknown column 's.class_teacher_id' in 'on clause' - Invalid query: SELECT `s`.*, `sh`.*, `d`.*, `h`.*, `t`.*, `sc`.*, `fo`.`occupation_name` as `father_occupation`, `mo`.`occupation_name` as `mother_occupation`, `gu`.`occupation_name` as `gaudian_occupation`, CONCAT(e.first_name, " ", `e`.`middle_name`, " ", e.last_name) as emp_fullname
FROM `student` `s`
LEFT JOIN `school` `sh` ON `sh`.`school_id` = `s`.`last_school_id`
LEFT JOIN `district` `d` ON `d`.`district_id` = `s`.`district_id`
LEFT JOIN `house` `h` ON `h`.`house_id` = `s`.`house_id`
LEFT JOIN `bus_stop` `bs` ON `bs`.`stop_id` = `s`.`stop_id`
LEFT JOIN `transport` `t` ON `t`.`bus_id` = `bs`.`bus_id`
LEFT JOIN `occupation` `fo` ON `fo`.`occupation_id` = `s`.`father_occupation_id`
LEFT JOIN `occupation` `mo` ON `mo`.`occupation_id` = `s`.`mother_occupation_id`
LEFT JOIN `occupation` `gu` ON `gu`.`occupation_id` = `s`.`guardian_occupation_id`
LEFT JOIN `section` `sc` ON `sc`.`section_id` = `s`.`class_id`
LEFT JOIN `employee` `e` ON `e`.`employee_id` = `s`.`class_teacher_id`
WHERE `s`.`student_id` = '1214'
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:53:18 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 10
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 49
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 64
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 101
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 103
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 105
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 107
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Undefined variable: theme_option C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:54:15 --> Severity: Notice --> Trying to get property of non-object C:\xampp\htdocs\smis\application\views\common\header.php 109
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 49
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$pu_scholar C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 70
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 72
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 76
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 80
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 84
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 98
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 101
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 132
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 164
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 170
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 176
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 183
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 188
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 190
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 195
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 197
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 201
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 207
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 209
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 213
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 215
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 219
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 221
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 227
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 231
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 233
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 305
ERROR - 2018-03-14 14:54:38 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 305
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 419
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 535
ERROR - 2018-03-14 14:54:38 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 538
ERROR - 2018-03-14 15:01:56 --> Severity: Error --> Call to undefined function display_pic_path() C:\xampp\htdocs\smis\application\views\common\header.php 121
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$pu_scholar C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 60
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 64
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 68
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 72
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 86
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 89
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 120
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 152
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 154
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 158
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 162
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 164
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 171
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 176
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 178
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 183
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 185
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 189
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 195
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 197
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 201
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 207
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 209
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 215
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 219
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 221
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 227
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 293
ERROR - 2018-03-14 15:02:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 293
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 407
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 523
ERROR - 2018-03-14 15:02:42 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 526
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$pu_scholar C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 60
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 64
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 68
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 72
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 86
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 89
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 120
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 152
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 154
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 158
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 162
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 164
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 171
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 176
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 178
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 183
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 185
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 189
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 195
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 197
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 201
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 207
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 209
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 215
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 219
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 221
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 227
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 293
ERROR - 2018-03-14 15:03:20 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 293
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 407
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 523
ERROR - 2018-03-14 15:03:20 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 526
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 74
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 77
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 108
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 140
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 142
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 146
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 150
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 152
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 159
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 164
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 171
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 173
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 177
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 179
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 179
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 183
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 185
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 189
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 195
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 197
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 207
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 209
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 215
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 281
ERROR - 2018-03-14 15:04:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 281
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 395
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 511
ERROR - 2018-03-14 15:04:48 --> Severity: Notice --> Undefined property: stdClass::$st_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 514
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 108
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 140
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 142
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 146
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 150
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 152
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 159
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 164
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 171
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 173
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 177
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 179
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 179
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 183
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 185
ERROR - 2018-03-14 15:05:11 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 189
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 191
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 195
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 197
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 203
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 207
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 209
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 215
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 281
ERROR - 2018-03-14 15:05:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 281
ERROR - 2018-03-14 15:05:12 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 395
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 135
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 137
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 141
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 145
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 147
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 154
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 159
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 161
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 172
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 178
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 180
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 184
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 186
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 190
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 192
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 198
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 202
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 204
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$programlevel_id C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 210
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 276
ERROR - 2018-03-14 15:06:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 276
ERROR - 2018-03-14 15:06:07 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 390
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 135
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 137
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 141
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 145
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 147
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 154
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 159
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 161
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 172
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 178
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 180
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 184
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 186
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 190
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 192
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 198
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 202
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 204
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 268
ERROR - 2018-03-14 15:06:39 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 268
ERROR - 2018-03-14 15:06:39 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 382
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$exam_rollno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 135
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_exam_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 137
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_roll_no C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 141
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$program_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 145
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$pu_regno C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 147
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$alternate_email C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 154
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$email_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 159
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_sex C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 161
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$parent_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$occupation_remarks C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 172
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 174
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_address C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 178
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$st_hphone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 180
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$current_add C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 184
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$current_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 186
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$degree_name C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 190
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$parent_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 192
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_1 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 198
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$institute C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 202
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$prev_percent_2 C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 204
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 268
ERROR - 2018-03-14 15:07:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 268
ERROR - 2018-03-14 15:07:28 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 382
ERROR - 2018-03-14 15:14:16 --> Severity: Notice --> Undefined property: stdClass::$st_dob_np C:\xampp\htdocs\smis\application\modules\pages\views\profile\edit_student.php 264
ERROR - 2018-03-14 15:16:28 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:16:28 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:16:28 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:16:28 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:16:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:16:28 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:17:25 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:17:25 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:17:25 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:17:25 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:17:25 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:17:25 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:19:47 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:19:47 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:19:47 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:19:47 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:19:47 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:19:47 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:19:50 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:19:50 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:19:50 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:19:50 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:19:50 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:19:50 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:20:06 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:07 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:10 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:20:10 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:20:10 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:20:10 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:20:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:20:10 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:20:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:20:20 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:20:20 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:20:20 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:20:20 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:20:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:20:30 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:33 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:38 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:41 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:20:43 --> 404 Page Not Found: ../modules/pages/controllers//index
ERROR - 2018-03-14 15:21:31 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:21:31 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:21:31 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:21:31 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:21:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:21:31 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:21:44 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:21:44 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:21:44 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:21:44 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:21:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:21:44 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:22:49 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:22:49 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:22:49 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:22:49 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:22:49 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:22:49 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:22:51 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:22:51 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:22:51 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:22:51 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:22:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:22:51 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:23:35 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:23:35 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:23:35 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:23:35 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:23:35 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:23:35 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:24:31 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:24:31 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:31 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:31 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:31 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:24:32 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:24:32 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:32 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:32 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:32 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:24:34 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:24:34 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:34 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:24:34 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:24:34 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:25:08 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:25:08 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:08 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:08 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:08 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:25:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:25:20 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:20 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:20 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:20 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:20 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:25:56 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 61
ERROR - 2018-03-14 15:25:56 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:56 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 168
ERROR - 2018-03-14 15:25:56 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:56 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 240
ERROR - 2018-03-14 15:25:56 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 354
ERROR - 2018-03-14 15:27:32 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:27:32 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:27:32 --> Severity: Notice --> Undefined property: stdClass::$st_guardian_phone C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:27:32 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:27:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:27:32 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 353
ERROR - 2018-03-14 15:28:11 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:28:11 --> Severity: Notice --> Undefined property: stdClass::$guardian_occupation C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 166
ERROR - 2018-03-14 15:28:11 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:28:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:28:11 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 353
ERROR - 2018-03-14 15:28:45 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:28:45 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:28:45 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:28:45 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 353
ERROR - 2018-03-14 15:29:13 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:29:13 --> Severity: Notice --> Undefined variable: a_category C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:29:13 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 239
ERROR - 2018-03-14 15:30:24 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:32:10 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:34:54 --> Severity: Notice --> Undefined property: stdClass::$status C:\xampp\htdocs\smis\application\modules\pages\views\profile\student_detail.php 58
ERROR - 2018-03-14 15:42:53 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\exam_summary_report.php 95
ERROR - 2018-03-14 15:54:42 --> Severity: Notice --> Undefined variable: exams C:\xampp\htdocs\smis\application\modules\pages\views\reports\exam_summary_report.php 95
