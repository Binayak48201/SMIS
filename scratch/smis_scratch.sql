-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2018 at 10:50 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smis_scratch`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`%` PROCEDURE `internalAddClassesForNewBatch` (IN `batchID` INT)  BEGIN	   
	   -- Declare local variables
	   DECLARE done BOOLEAN DEFAULT 0;
	   DECLARE gradeID INT;
	   -- Declare the cursor
	   DECLARE gradeIDs CURSOR
	   FOR
	   SELECT grade_id FROM grade;
	   -- Declare continue handler
	   DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=1;
	   -- Open the cursor
	   OPEN gradeIDs;
	   -- Loop through all rows
	   REPEAT
	      -- Get order number
	      FETCH gradeIDs INTO gradeID;
		IF NOT done THEN
		insert into class (grade_id, batch_id) values (gradeID, batchID);
		END IF;
	   -- End of loop
	   UNTIL done END REPEAT;
	   -- Close the cursor
	   CLOSE gradeIDs;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `internalCopyPreviousClasses` (IN `newBatchID` INT)  BEGIN
	DECLARE done BOOLEAN DEFAULT 0;
	declare gradeID, classTeacherID int;
	declare sectionName varchar(20);
	-- Declare the cursor
	DECLARE previousClasses CURSOR
	FOR
	SELECT grade_id, section, class_teacher_id  FROM class where is_deleted = 0 and batch_id = 
	(select max(batch_id) from batch where batch_id < newBatchID);
	-- Declare continue handler
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=1;
	-- Open the cursor
	OPEN previousClasses;
	-- Loop through all rows
	REPEAT
	  -- Get order number
	FETCH previousClasses INTO gradeID, sectionName, classTeacherID;
	IF NOT done THEN
	insert into class (grade_id, section, class_teacher_id, batch_id) 
	values (gradeID, sectionName, classTeacherID, newBatchID);
	END IF;
	  -- End of loop
	UNTIL done END REPEAT;
	  -- Close the cursor
	CLOSE previousClasses;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `internalGetGradeMapping` (OUT `gradeLetter` VARCHAR(20), IN `marks` DOUBLE)  BEGIN
	select grade_letter into gradeLetter from grade_map where min_marks <= marks order by min_marks desc limit 0,1;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `invGetClientInvoices` (IN `clientID` BIGINT)  BEGIN
	select invoice.invoice_id, invoice.invoice_title, invoice.invoice_amount, invoice.payable_amount, invoice.amount_words,
                invoice.invoiced_on, student.st_fname, student.st_mname, student.st_lname,
                student.student_id, sum(invoice_payment.amount) as paid_amount
                from invoice left join student
                on invoice.client_id = student.student_id
	left join invoice_payment using (invoice_id)
                where invoice.client_id = clientID
	group by invoice.invoice_id
		order by invoiced_on desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `invGetCollectionSummary` ()  BEGIN
	declare batchID int;
	select batch_id into batchID from batch order by batch_name desc limit 0,1;
	
	select student_id, concat_ws(' ', st_fname, st_lname) as student_name, gender,
	student.current_roll, student.class_id, concat_ws(' ', grade_name, section) as class_name,
	(select GetTotalPayable(student.student_id, batchID)) as total_payable,
	(select GetTotalCollected(student.student_id, batchID)) as total_collected
	from student left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where (is_deleted = 0 or is_deleted is null)
	and student.deleted = 0
	and batch_id = batchID
	order by grade_order, section, student_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `invGetInvoices` (IN `fromDate` DATE, IN `toDate` DATE)  BEGIN
	select invoice.invoice_id, invoice.invoice_title, invoice.invoice_amount, invoice.payable_amount, invoice.amount_words,
                invoice.invoiced_on, student.st_fname, student.st_mname, student.st_lname,
                student.student_id, sum(invoice_payment.amount) as paid_amount
                from invoice left join student
                on invoice.client_id = student.student_id
	left join invoice_payment using (invoice_id)
                where invoice.invoiced_on between fromDate and toDate
	group by invoice.invoice_id
		order by invoiced_on desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ncpGetClassListByBatch` (IN `batchID` INT)  BEGIN
select class.class_id, concat_ws(' ', grade.grade_name, class.section) as class_name
	from class left join grade using (grade_id)
	where class.batch_id = batchID
	and class.is_deleted = 0
	order by grade.grade_order, class.section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ncpGetSubjectListByClass` (IN `classID` INT)  BEGIN
	declare gradeID int;
	select grade_id into gradeID from class where class_id = classID;
	select * from subject LEFT JOIN ncpcoursepointerstatus on subject.subject_id=ncpcoursepointerstatus.course_id where grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ncpGetTermSummary` (IN `classID` INT)  BEGIN
	declare courseID int;
	select course_id into courseID from ncptermsummary where class_id=classID; 
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddClassTeacherRemarksOnParent` (IN `studentID` INT, IN `textRemark` TEXT, IN `evaluationDate` DATE, IN `userID` VARCHAR(36))  BEGIN
	declare previousID int;
	select ct_parent_remarks_id into previousID from ct_parent_remarks where student_id = studentID
	and Year(evaluation_date) = Year(evaluationDate)
	and Month(evaluation_date) = Month(evaluationDate);
	
	if previousID is null then
		insert into ct_parent_remarks (student_id, remarks, evaluation_date, user_id) 
		values (studentID, textRemark, evaluationDate, userID);
	else
		update ct_parent_remarks set student_id = studentID, 
		remarks = textRemark, evaluation_date = evaluationDate, user_id = userID
		where ct_parent_remarks_id = previousID;
	end if; 
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddClub` (OUT `clubID` INT, IN `clubName` VARCHAR(255), IN `clubType` VARCHAR(30))  BEGIN
	select club_id into clubID from clubs where club_name = clubName and club_type = clubType;
	
	if clubID is null then
	insert into clubs (club_name, club_type) values (clubName, clubType);
	select Last_Insert_ID() into clubID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddEvaluationOption` (IN `evaluationTypeID` INT, IN `evaluationOptionName` VARCHAR(100))  BEGIN
	select evaluation_option_id into @ID from ct_evaluation_option where evaluation_option_name = evaluationOptionName
	and evaluation_type_id = evaluationTypeID;
	
	if @ID is null then
		insert into ct_evaluation_option (evaluation_option_name, evaluation_type_id) 
		values (evaluationOptionName, evaluationTypeID);
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddEvaluationType` (OUT `evaluationTypeID` INT, IN `evaluationType` VARCHAR(255))  BEGIN
	select evaluation_type_id into evaluationTypeID from ct_evaluation_type where evaluation_type_name = evaluationType;
	
	if evaluationTypeID is null then
		insert into ct_evaluation_type (evaluation_type_name) values (evaluationType);
		select Last_Insert_ID() into evaluationTypeID;
	end if;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddParentEvaluationOption` (IN `evaluationTypeID` INT, IN `evaluationOptionName` VARCHAR(100))  BEGIN
	select evaluation_option_id into @ID from ct_parent_evaluation_option where evaluation_option_name = evaluationOptionName
	and evaluation_type_id = evaluationTypeID;
	
	if @ID is null then
		insert into ct_parent_evaluation_option (evaluation_option_name, evaluation_type_id) 
		values (evaluationOptionName, evaluationTypeID);
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddParentEvaluationType` (OUT `evaluationTypeID` INT, IN `evaluationType` VARCHAR(255))  BEGIN
	select evaluation_type_id into evaluationTypeID from ct_parent_evaluation_type where evaluation_type_name = evaluationType;
	
	if evaluationTypeID is null then
		insert into ct_parent_evaluation_type (evaluation_type_name) values (evaluationType);
		select Last_Insert_ID() into evaluationTypeID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSibling` (OUT `siblingID` BIGINT, IN `studentID` BIGINT, IN `siblingName` VARCHAR(100), IN `siblingRelation` VARCHAR(100), IN `siblingDOB` VARCHAR(30), IN `siblingQualification` VARCHAR(255), IN `siblingInstitution` VARCHAR(255))  BEGIN
	insert into sibling
	(
		student_id,
		sibling_name,
		relation,
		sibling_dob,
		sibling_qualification,
		sibling_institution
	)
	values
	(
		studentID,
		siblingName,
		siblingRelation,
		siblingDOB,
		siblingQualification,
		siblingInstitution
	);
	select Last_Insert_ID() into siblingID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentAchievement` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `achievementName` VARCHAR(100), IN `otherRemarks` TEXT)  BEGIN
	select st_achievement_id into ID from student_achievement where student_id = studentID and achievement = achievementName;
	
	if ID is null then
		insert into student_achievement (student_id, achievement, remarks) 
		values (studentID, achievementName, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_achievement set
		remarks = otherRemarks
		where st_achievement_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentAllergy` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `allergyName` VARCHAR(255), IN `startDate` DATE, IN `endDate` DATE, IN `currentStatus` VARCHAR(255), IN `otherRemarks` TEXT)  BEGIN
	select st_allergy_id into ID from student_allergy where student_id = studentID and allergy = allergyName;
	
	if ID is null then
		insert into student_allergy (student_id, allergy, start_date, end_date, current_status, remarks) 
		values (studentID, allergyName, startDate, endDate, currentStatus, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_allergy set
		start_date = startDate,
		end_date = endDate,
		current_status = currentStatus,
		remarks = otherRemarks
		where st_allergy_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentComment` (OUT `commentID` BIGINT, IN `studentID` BIGINT, IN `commentDesc` LONGTEXT, IN `userID` VARCHAR(255), IN `commentType` VARCHAR(32), IN `parentContactRequired` BOOL, IN `parentContacted` BOOL, IN `isPublic` BOOL)  BEGIN
	declare classID int;
	select class_id into classID from student where student_id = studentID;
	insert into st_comment
	(
		student_id,
		comments,
		comment_date,
		user_id,
		comment_type,
		parent_contact_required,
		parent_contacted,
		is_public,
		class_id
	)
	values
	(
		studentID,
		commentDesc,
		curdate(),
		userID,
		commentType,
		parentContactRequired,
		parentContacted,
		isPublic,
		classID
	);
	select Last_Insert_ID() into commentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentCondition` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `conditionName` VARCHAR(255), IN `startDate` DATE, IN `endDate` DATE, IN `currentStatus` VARCHAR(255), IN `otherRemarks` TEXT)  BEGIN
	select st_condition_id into ID from student_condition where student_id = studentID and condition_name = conditionName;
	
	if ID is null then
		insert into student_condition (student_id, condition_name, start_date, end_date, current_status, remarks) 
		values (studentID, conditionName, startDate, endDate, currentStatus, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_condition set
		start_date = startDate,
		end_date = endDate,
		current_status = currentStatus,
		remarks = otherRemarks
		where st_condition_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentDesignation` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `designationName` VARCHAR(100), IN `otherRemarks` TEXT)  BEGIN
	select st_designation_id into ID from student_designation where student_id = studentID and designation = designationName;
	
	if ID is null then
		insert into student_designation (student_id, designation, remarks) 
		values (studentID, designationName, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_designation set
		remarks = otherRemarks
		where st_designation_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentDoctor` (OUT `ID` INT, IN `studentID` BIGINT, IN `doctorName` VARCHAR(100), IN `docHospital` VARCHAR(255), IN `docPhone` VARCHAR(100))  BEGIN
	insert into doctor (student_id, doctor_name, hospital, phone)
	values (studentID, doctorName, docHospital, docPhone);
	select Last_Insert_ID() into ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentGame` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `gameName` VARCHAR(100), IN `otherRemarks` TEXT)  BEGIN
	select st_game_id into ID from student_game where student_id = studentID and game = gameName;
	
	if ID is null then
		insert into student_game (student_id, game, remarks) 
		values (studentID, gameName, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_game set
		remarks = otherRemarks
		where st_game_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentHobby` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `hobbyName` VARCHAR(255), IN `otherRemarks` TEXT)  BEGIN
	select st_hobby_id into ID from student_hobby where student_id = studentID and hobby = hobbyName;
	
	if ID is null then
		insert into student_hobby (student_id, hobby, remarks) 
		values (studentID, hobbyName, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_hobby set
		remarks = otherRemarks
		where st_hobby_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentMedication` (OUT `ID` BIGINT, IN `studentID` BIGINT, IN `medicationName` VARCHAR(255), IN `otherRemarks` TEXT)  BEGIN
	select st_medication_id into ID from student_medication where student_id = studentID and medication = medicationName;
	
	if ID is null then
		insert into student_medication (student_id, medication, remarks) 
		values (studentID, medicationName, otherRemarks);
		select Last_Insert_ID() into ID;
	else
		update student_medication set
		remarks = otherRemarks
		where st_medication_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentOptional` (IN `studentID` BIGINT, IN `gradeID` INT, IN `subjectID` INT)  BEGIN
	select st_opt_id into @ID from student_optional where student_id = studentID and subject_id = subjectID;
	if @ID is null then
		insert into student_optional (student_id, grade_id, subject_id) values (studentID, gradeID, subjectID);
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddStudentToClub` (IN `studentID` BIGINT, IN `clubID` INT, IN `clubRole` VARCHAR(100))  BEGIN
	declare previousID int;
	select st_club_id into previousID from student_club where student_id = studentID
	and club_id = clubID;
	
	if previousID is null then
		insert into student_club (student_id, club_id, designation) 
		values (studentID, clubID, clubRole);
	else
		update student_club set active = 1, designation = clubRole
		where st_club_id = previousID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSubjectCommentOnStudent` (OUT `commentID` BIGINT, IN `commentDesc` LONGTEXT, IN `studentID` BIGINT, IN `subjectID` INT, IN `userID` VARCHAR(255), IN `isPublic` BOOL)  BEGIN
	insert into subject_comment
	(
		comments,
		date,
		student_id,
		subject_id,
		user_id,
		is_public
	)
	values
	(
		commentDesc,
		curdate(),
		studentID,
		subjectID,
		userID,
		isPublic
	);
	select Last_Insert_ID() into commentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSubjectEvaluationOption` (IN `evaluationTypeID` INT, IN `evaluationOptionName` VARCHAR(100))  BEGIN
	select evaluation_option_id into @ID from subject_evaluation_option where evaluation_option_name = evaluationOptionName
	and evaluation_type_id = evaluationTypeID;
	
	if @ID is null then
		insert into subject_evaluation_option (evaluation_option_name, evaluation_type_id) 
		values (evaluationOptionName, evaluationTypeID);
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSubjectEvaluationType` (OUT `evaluationTypeID` INT, IN `evaluationType` VARCHAR(255))  BEGIN
	select evaluation_type_id into evaluationTypeID from subject_evaluation_type where evaluation_type_name = evaluationType;
	
	if evaluationTypeID is null then
		insert into subject_evaluation_type (evaluation_type_name) values (evaluationType);
		select Last_Insert_ID() into evaluationTypeID;
	end if;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSubjectGeneralRemarks` (IN `studentID` INT, IN `textRemark` TEXT, IN `evaluationDate` DATE, IN `userID` VARCHAR(36), IN `subjectID` INT)  BEGIN
	declare previousID int;
	select subject_remarks_id into previousID from subject_remarks where student_id = studentID
	and Year(evaluation_date) = Year(evaluationDate)
	and Month(evaluation_date) = Month(evaluationDate) and subject_id = subjectID;
	
	if previousID is null then
		insert into subject_remarks (student_id, remarks, evaluation_date, user_id, subject_id) 
		values (studentID, textRemark, evaluationDate, userID, subjectID);
	else
		update subject_remarks set student_id = studentID, 
		remarks = textRemark, evaluation_date = evaluationDate, user_id = userID, subject_id = subjectID
		where subject_remarks_id = previousID;
	end if; 
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddSubjectGradeMap` (IN `subjectID` INT, IN `batchID` INT, IN `minMarks` DOUBLE, IN `gradeName` VARCHAR(30))  BEGIN
	declare ID int;
	select subject_grading_id into ID from subject_grading where subject_id = subjectID and batch_id = batchID
	and min_marks = minMarks;
	if ID is null then
		insert into subject_grading (subject_id, batch_id, min_marks, grade_name)
		values (subjectID, batchID, minMarks, gradeName);
	else
		update subject_grading set grade_name = gradeName where subject_grading_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAddTopic` (OUT `topicID` INT, IN `topicName` VARCHAR(100), IN `subjectID` INT, IN `parentID` INT)  BEGIN
	select topic_id into topicID from topic where topic_name = topicName and subjectID = subjectID
	and parent_id = parentID;
	
	if topicID is null then
		insert into topic (topic_name, subject_id, parent_id) 
		values (topicName, subjectID, parentID);
		select Last_Insert_ID() into topicID;
	else
		update topic set
		topic_name = topicName,
		subject_id = subjectID,
		parent_id = parentID
		where topic_id = topicID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spAssignClass` (IN `studentID` BIGINT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	declare classID int;
	select class_id into classID from class where grade_id = gradeID and section = sectionName and
	batch_id = (select max(batch_id) from batch);
	update student set class_id = classID where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChangeGradeOrder` (IN `gradeID` INT, IN `direction` VARCHAR(20))  BEGIN
	declare swapOrder int;
	declare currentOrder int;
	select grade_order into currentOrder from grade where grade_id = gradeID;
	if direction = 'ABOVE' then
		select max(grade_order) into swapOrder from grade where grade_order < currentOrder;		
	end if;
	if direction = 'BELOW' then
		select min(grade_order) into swapOrder from grade where grade_order > currentOrder;
	end if;
	if swapOrder is not null then /*Neither two of the above condition met or the top or bottom grade tried to be moved further*/
		update grade set grade_order = currentOrder where grade_order = swapOrder;
		update grade set grade_order = swapOrder where grade_id = gradeID;
	end if;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartEmployeeNumberByType` ()  BEGIN
	select count(*) as number, employee_type from employee
	group by employee_type;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartPreviousSchool` ()  BEGIN
	select count(*) as number, school_name, school_id
	from student
	left join school on student.last_school_id = school.school_id
	where school_id > 0
	group by last_school_id order by number desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartStudentAdmittedByYear` ()  BEGIN
	/*select count(*) as number, Year(joined_date) as joined_year from student
	where student.deleted = 0
	group by Year(joined_date) 
	order by Year(joined_date);*/
	select count(*) as number, joined_batch as joined_year from student
	where student.deleted = 0
	group by joined_batch 
	order by joined_batch;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartStudentAttendanceByClass` (IN `studentID` BIGINT, IN `classID` INT)  BEGIN
	select 	student_id, terminal_id, terminal_name, present_days, absent_days, leave_days, total_days 
	from student_attendance
	left join terminal using (terminal_id)
	where class_id = classID
	and student_id = studentID
	group by terminal_id
	order by terminal_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartStudentNumber` ()  BEGIN
	select count(*) as number, student.class_id, grade.grade_id, grade.grade_name from student
	left join (class) using (class_id)
	left join grade on class.grade_id = grade.grade_id 
	where passed_out = 0 and dropped_out = 0 and student.deleted = 0
	group by class_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spChartStudentTotalAttendance` (IN `studentID` BIGINT, IN `classID` INT)  BEGIN
	select 	student_id, sum(present_days) as present_days, sum(absent_days) as absent_days, 
	sum(leave_days) as leave_days, sum(total_days) as total_days 
	from student_attendance
	where class_id = classID
	and student_id = studentID
	group by student_id, class_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteClass` (IN `classID` INT)  BEGIN
	delete from class where class_id = classID;
	update student set class_id = null where class_id = classID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteClub` (IN `clubID` INT)  BEGIN
	delete from clubs where club_id = clubID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteDistrict` (IN `districtID` INT)  BEGIN
	delete from district where district_id = districtID;
	update student set district_id = null where district_id = districtID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteEvaluationOption` (IN `id` INT)  BEGIN
	delete from ct_evaluation_option where evaluation_option_id = id;
	delete from student_evaluation where evaluation_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteEvaluationType` (IN `id` INT)  BEGIN
	delete from ct_evaluation_type where evaluation_type_id = id;
	delete from ct_evaluation_option where evaluation_type_id = id;
	delete from student_evaluation where evaluation_type_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteGrade` (IN `gradeID` INT)  BEGIN
	declare gradeOrder int;
	select grade_order into gradeOrder from grade where grade_id = gradeID;
	delete from grade where grade_id = gradeID;
	update grade set grade_order = grade_order - 1 where grade_order > gradeOrder;
	update student set joined_grade_id = null where joined_grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteHouse` (IN `houseID` INT)  BEGIN
	delete from house where house_id = houseID;
	update student set house_id = null where house_id = houseID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteOccupation` (IN `occupationID` INT)  BEGIN
	delete from occupation where occupation_id = occupationID;
	update student set father_occupation_id = null where father_occupation_id = occupationID;
	update student set mother_occupation_id = null where mother_occupation_id = occupationID;
	update student set guardian_occupation_id = null where guardian_occupation_id = occupationID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteParentEvaluationOption` (IN `id` INT)  BEGIN
	delete from ct_parent_evaluation_option where evaluation_option_id = id;
	delete from parent_evaluation where evaluation_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteParentEvaluationType` (IN `id` INT)  BEGIN
	delete from ct_parent_evaluation_type where evaluation_type_id = id;
	delete from ct_parent_evaluation_option where evaluation_type_id = id;
	delete from parent_evaluation where evaluation_type_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteSchool` (IN `schoolID` INT)  BEGIN
	delete from school where school_id = schoolID;
	update student set last_school_id = null where last_school_id = schoolID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteSibling` (IN `siblingID` BIGINT)  BEGIN
	declare studentID bigint;
	declare siblingStudentID bigint;
	
	select student_id, sibling_st_id into studentID, siblingStudentID from sibling
	where sibling_id = siblingID;
	delete from sibling where sibling_id = siblingID;
	
	if siblingStudentID is not null then
		delete from sibling where student_id = siblingStudentID and sibling_st_id = studentID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentAchievement` (IN `ID` BIGINT)  BEGIN
	delete from student_achievement where st_achievement_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentAllergy` (IN `ID` BIGINT)  BEGIN
	delete from student_allergy where st_allergy_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentCondition` (IN `ID` BIGINT)  BEGIN
	delete from student_condition where st_condition_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentDesignation` (IN `ID` BIGINT)  BEGIN
	delete from student_designation where st_designation_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentDoctor` (IN `ID` INT)  BEGIN
	delete from doctor where doctor_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentGame` (IN `ID` BIGINT)  BEGIN
	delete from student_game where st_game_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentHobby` (IN `ID` BIGINT)  BEGIN
	delete from student_hobby where st_hobby_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteStudentMedication` (IN `ID` BIGINT)  BEGIN
	delete from student_medication where st_medication_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteSubject` (IN `subjectID` INT)  BEGIN
	select count(*) into @cnt from st_marks where subject_id = subjectID;
	if @cnt > 0 then
		call spSetSubjectDeleted(subjectID);
	else
		delete from subject where subject_id = subjectID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteSubjectEvaluationOption` (IN `id` INT)  BEGIN
	delete from subject_evaluation_option where evaluation_option_id = id;
	delete from subject_evaluation where evaluation_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteSubjectEvaluationType` (IN `id` INT)  BEGIN
	delete from subject_evaluation_type where evaluation_type_id = id;
	delete from subject_evaluation_option where evaluation_type_id = id;
	delete from subject_evaluation where evaluation_type_id = id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteTerminal` (IN `terminalID` INT)  BEGIN
	update terminal set is_deleted = 1 where terminal_id = terminalID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spDeleteTopic` (IN `topicID` INT)  BEGIN
	delete from topic where topic_id = topicID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spFindResult` (OUT `outcome` VARCHAR(50), OUT `outcomeTotal` VARCHAR(50), IN `marks` DOUBLE, IN `totalMarks` DOUBLE, IN `subjectID` INT)  BEGIN
	declare passMarks int;
	select pass_marks into passMarks from subject
	where subject_id = subjectID;
	
	if passMarks is not null then
		/*** For terminal exam marks ***/
		if marks < passMarks then
			set outcome = 'FAIL';
		else
			set outcome = 'PASS';
		end if;
		/*** For terminal exam marks combined with class test marks ***/
		if totalMarks < passMarks then
			set outcomeTotal = 'FAIL';
		else
			set outcomeTotal = 'PASS';
		end if;
	else
		set outcome = 'UNKNOWN';
		set outcomeTotal = 'UNKNOWN';
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spFindTerminalResult` (OUT `outcome` VARCHAR(50), IN `studentID` BIGINT, IN `gradeID` INT, IN `terminalID` INT)  BEGIN
	/*** Find all subjects for the student for current grade ***/
	select count(*) into @subjectCount from subject where grade_id =gradeID and is_deleted = 0 and 
	(subject_type = 'COMPULSORY' or subject_id in (select subject_id from student_optional where student_id = studentID));
	/*** Find number of subjects failed ***/
	select count(*) into @failCount from st_marks where student_id = studentID and terminal_id = terminalID
	and (subject_id in (select subject_id from subject where grade_id =gradeID and subject_type = 'COMPULSORY')
	or subject_id in (select subject_id from student_optional where student_id = studentID)) and result_total = 'FAIL'
	and subject_id in (select subject_id from subject where is_deleted = 0);
	if @failCount > 0 then
		set outcome = 'FAIL';
	else
		/*** Find total marks entries for the student for this grade ***/
		select count(*) into @totalEntries from st_marks where student_id = studentID and terminal_id = terminalID
		and (subject_id in (select subject_id from subject where grade_id =gradeID and subject_type = 'COMPULSORY')
		or subject_id in (select subject_id from student_optional where student_id = studentID))
		and subject_id in (select subject_id from subject where is_deleted = 0);
	
		if @totalEntries < @subjectCount then
			set outcome = 'PENDING';/*** Not all required marks entries are completed ***/
		else
			set outcome = 'PASS';
		end if;
	end if;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAggregateClassResult` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select aggregate_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from class_result
		left join student on class_result.student_id = student.student_id 
		where class_result.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		order by aggregate_marks desc;
	else
		select aggregate_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from class_result
		left join student on class_result.student_id = student.student_id 
		where class_result.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		and student.deleted = 0
		order by aggregate_marks desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAggregateExamSummary` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select sum(wt_total_marks) as total, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from student
		left join st_marks on student.student_id = st_marks.student_id 
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		where student.deleted = 0
		group by student_id 
		order by sum(wt_total_marks) desc;
	else
		select sum(wt_total_marks) as total, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from student
		left join st_marks on student.student_id = st_marks.student_id 
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID 
		and section = sectionName)
		where student.deleted = 0
		group by student_id 
		order by sum(wt_total_marks) desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAggregateSummaryReport` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select st_marks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from st_marks 
		left join student using (student_id)
		left join student_status on st_marks.student_id = student_status.student_id
		and st_marks.class_id = student_status.class_id
		and student_status.terminal_id = 0
		where st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		group by st_marks.student_id
		order by total desc;
	else
		select st_marks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from st_marks 
		left join student using (student_id)
		left join student_status on st_marks.student_id = student_status.student_id
		and st_marks.class_id = student_status.class_id
		and student_status.terminal_id = 0
		where st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName) 
		and student.deleted = 0
		group by st_marks.student_id
		order by total desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAllClassesForStudent` (IN `studentID` BIGINT)  BEGIN
	select distinct class.* from student_attendance 
	left join class using (class_id)
	where student_id = studentID and class.is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAllergiesForStudent` (IN `studentID` BIGINT)  BEGIN
	select * from student_allergy where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAllSubjectMarksForStudentOnTerminal` (IN `studentID` BIGINT, IN `terminalID` INT, IN `gradeID` INT)  BEGIN
	select subject.subject_id, subject.subject_name,
	st_marks.total_marks
	from subject left join st_marks on subject.subject_id = st_marks.subject_id
	and st_marks.student_id = studentID and st_marks.terminal_id = terminalID
	where subject.grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAllTimeStudentList` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		student.gender, student.passed_out, student.dropped_out,
		student_attendance.student_roll
		from student_attendance
		left join student on student_attendance.student_id = student.student_id
		where student_attendance.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID) 
		and student.deleted = 0;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		student.gender, student.passed_out, student.dropped_out,
		student_attendance.student_roll
		from student_attendance
		left join student on student_attendance.student_id = student.student_id
		where student_attendance.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID 
		and section = sectionName) 
		and student.deleted = 0;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAppraisal` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT, IN `terminalID` INT)  BEGIN
	select appraisal_heads.head_id, appraisal_heads.head_name, appraisal_fields.field_name,
	appraisal.*
	from appraisal_heads
	left join appraisal_fields using (head_id)
	left join appraisal on appraisal_fields.field_id = appraisal.field_id
	and (student_id = studentID or student_id is null)
	And grade_id = gradeID and batch_id = batchID
	and terminal_id = terminalID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAppraisalByHead` (IN `studentID` BIGINT, IN `headID` INT, IN `gradeID` INT, IN `batchID` INT, IN `terminalID` INT)  BEGIN
	select appraisal_heads.head_id, appraisal_heads.head_name, appraisal_fields.field_name,
	appraisal.*
	from appraisal_heads
	left join appraisal_fields using (head_id)
	left join appraisal on appraisal_fields.field_id = appraisal.field_id
	and (student_id = studentID or student_id is null)
	And grade_id = gradeID and batch_id = batchID
	Where appraisal_heads.head_id = headID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAttendance` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT, IN `terminalID` INT)  BEGIN
	select sum(total_days) as TotalDays, sum(present_days) as PresentDays,
	sum(absent_days) as AbsentDays, sum(leave_days) as LeaveDays
	from student_attendance where student_id = studentID
	and terminal_id = terminalID
	and class_id in (select class_id from class where grade_id = gradeID and batch_id = batchID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetAttendanceTotal` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT)  BEGIN
	select sum(total_days) as TotalDays, sum(present_days) as PresentDays,
	sum(absent_days) as AbsentDays, sum(leave_days) as LeaveDays
	from student_attendance where student_id = studentID
	and class_id in (select class_id from class where grade_id = gradeID and batch_id = batchID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetBatchList` ()  BEGIN
	select * from batch order by batch_name desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetBirthdayStudents` ()  BEGIN
	select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	st_dob, student.class_id, student.gender, student.current_roll, picture_path,
	class.section, grade.grade_name, grade.grade_order, 
	concat_ws(' ', grade.grade_name, class.section) as class_name
	from student left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where month(st_dob) = month(curdate()) and day(st_dob) = day(curdate())
	and student.deleted = 0 and class.is_deleted = 0 and class.passed_out = 0
	order by grade_order;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCategories` ()  BEGIN
	select * from student_category;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassesAttendedByStudent` (IN `studentID` BIGINT)  BEGIN
	select distinct class.class_id, concat_ws(' ', grade_name, section) as class_name, grade.grade_id, batch.batch_id
	from st_marks
	left join class on st_marks.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	left join batch on class.batch_id = batch.batch_id
	where class.is_deleted = 0
	and st_marks.student_id = studentID
	order by class.grade_id, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassesForClassTeacher` (IN `userID` VARCHAR(36))  BEGIN
	declare currentYearID int;
	select batch_id into currentYearID from batch where batch_name = (select max(batch_name) from batch);
	select class_id, class.grade_id, grade_name, section from 
	class left join grade on class.grade_id = grade.grade_id
	where class_teacher_id = (select employee_id from employee where user_id = userID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassesForTeacher` (IN `employeeID` BIGINT)  BEGIN
	select subject_teacher.*, subject_name, concat_ws(' ', grade_name, section) as class_name,
	class.batch_id
	from subject_teacher
	left join subject using (subject_id)
	left join class on subject_teacher.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where employee_id = employeeID
	and class.passed_out = 0
	order by grade.grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassesInCurrentYear` ()  BEGIN
	declare currentBatchID int;
	select batch_id into currentBatchID from batch where batch_name = (select max(batch_name) from batch);
	select class.*, grade_name, concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as class_teacher,
	employee.employee_id
	from class
	left join grade on class.grade_id = grade.grade_id
	left join employee on class.class_teacher_id = employee.employee_id
	where class.batch_id = currentBatchID
	and class.is_deleted = 0
	order by grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassesInYear` (IN `batchID` INT)  BEGIN
	select class.*, grade_name, section,
	concat_ws(' ', employee.first_name, employee.last_name) as class_teacher
	from class
	left join grade on class.grade_id = grade.grade_id
	left join employee on class.class_teacher_id = employee.employee_id
	where class.batch_id = batchID
	and class.is_deleted = 0
	order by grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassList` ()  BEGIN
	select class_id, concat_ws(' ', grade_name, section) as class_combo
	from class
	left join grade on class.grade_id = grade.grade_id
	left join batch on class.batch_id = batch.batch_id
	where class.passed_out = 0
	and class.is_deleted = 0
	order by class.grade_id, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassName` (IN `classID` INT)  BEGIN
	select concat_ws(' ', grade.grade_name, class.section)
	from class left join grade on class.grade_id = grade.grade_id
	where class.class_id = classID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTeacher` (IN `classID` INT)  BEGIN
	select concat_ws(' ', first_name, middle_name, last_name) as class_teacher
	from class left join employee on class.class_teacher_id = employee.employee_id
	where class.class_id = classID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTeacherEvaluationOptions` (IN `evaluationTypeID` INT)  BEGIN
	select * from ct_evaluation_option where evaluation_type_id = evaluationTypeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTeacherEvaluationOptionsForParent` (IN `evaluationTypeID` INT)  BEGIN
	select * from ct_parent_evaluation_option where evaluation_type_id = evaluationTypeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTeacherEvaluationTypes` ()  BEGIN
	select * from ct_evaluation_type;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTeacherEvaluationTypesForParent` ()  BEGIN
	select * from ct_parent_evaluation_type;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClassTestMarks` (IN `testID` INT)  BEGIN
	declare classID int;
	declare passedOut bool;
	select class_id into classID from class_test where test_id = testID;
	select passed_out into passedOut from class where class_id = classID;
	if passedOut then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, registration_number,
		class_test_marks_id, class_test_marks.obtained_marks
		from class_test_marks left join student using (student_id)
		where class_test_marks.class_test_id = testID;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, registration_number,
		class_test_marks_id, class_test_marks.obtained_marks
		from student left join class_test_marks using (student_id)
		where student.class_id = classID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClubList` ()  BEGIN
	select * from clubs;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClubListByType` (IN `clubType` VARCHAR(30))  BEGIN
	select * from clubs where club_type = clubType order by club_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetClubsForStudent` (IN `studentID` BIGINT)  BEGIN
	select student_club.*, club_name, club_type
	from student_club left join clubs
	on student_club.club_id = clubs.club_id
	where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCollectionReport` (IN `batchID` INT, IN `gradeID` INT)  BEGIN
	/*First we get the payable amounts by student*/
	create temporary table payableTable as
	select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	class.batch_id, class.grade_id, class.section, sum(payment_headings.item_amount) as payableAmount
	from student
	left join class using (class_id)
	left join payment_scheme on class.batch_id = payment_scheme.batch_id and class.grade_id = payment_scheme.grade_id
	and payment_scheme.due_date <= curdate()
	left join payment_headings on payment_scheme.scheme_id = payment_headings.payment_scheme_id
	left join bill_item on payment_headings.item_id = bill_item.item_id
	where class.batch_id = batchID and class.grade_id = gradeID
	and student.deleted = 0
	and (bill_item.type_id is null or bill_item.type_id in (
			select type_id from payment_student_type 
			left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
			left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
			where student_id = student.student_id
			and fromscheme.due_date <= (SELECT Max(due_date) from payment_scheme where batch_id = batchID and grade_id = gradeID and due_date >=curdate()) 
			and (uptoscheme.due_date is null or uptoscheme.due_date >= curdate())
		)
	)
	group by student.student_id;
	/*Then, we get the paid amounts by student*/
	create temporary table paidTable as
	select student.student_id, sum(payment_student.payment_amount) as paidAmount, sum(fine_amount) as paidFine
	from student
	left join class using (class_id)
	left join payment_scheme on class.batch_id = payment_scheme.batch_id and class.grade_id = payment_scheme.grade_id
	left join payment_student on payment_scheme.scheme_id = payment_student.payment_scheme_id and student.student_id = payment_student.student_id
	where class.batch_id = batchID and class.grade_id = gradeID
	group by student.student_id;
	/*Then, we get the waivers amounts for students*/
	create temporary table waiverTable as
	select student.student_id, sum(payment_waiver.waiver_amount) as waiverAmount
	from student
	left join class using (class_id)
	left join payment_scheme on class.batch_id = payment_scheme.batch_id and class.grade_id = payment_scheme.grade_id
	left join payment_waiver on payment_scheme.scheme_id = payment_waiver.scheme_id and student.student_id = payment_waiver.student_id
	where class.batch_id = batchID and class.grade_id = gradeID
	group by student.student_id;
	
	select payableTable.*, paidTable.paidAmount, paidTable.paidFine, waiverTable.waiverAmount from payableTable
	left join paidTable using (student_id)
	left join waiverTable using (student_id)
	order by section, student_name;
	drop table if exists payableTable;
	drop table if exists paidTable;
	drop table if exists waiverTable;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCommentsForStudent` (IN `studentID` BIGINT)  BEGIN
	select 
	comment_id,
	comments,
	Date_Format(comment_date, '%e %b %Y') as date,
	concat(employee.first_name, " ", employee.last_name) as comment_by,
	parent_contact_required,
	parent_contacted
	from st_comment
	left join employee on st_comment.user_id = employee.user_id
	where st_comment.student_id = studentID;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetConditions` (IN `prefixText` VARCHAR(128))  BEGIN
	declare searchText varchar(128);
	set searchText = concat(prefixText, '%');
	select distinct condition_name from student_condition where condition_name like searchText;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetConditionsForStudent` (IN `studentID` BIGINT)  BEGIN
	select * from student_condition where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCTEvaluationForParent` (IN `studentID` BIGINT, IN `evaluationDate` DATE)  BEGIN
	select parent_evaluation.*, ct_parent_evaluation_option.*, ct_parent_evaluation_type.*,
	concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name
	from parent_evaluation
	left join (ct_parent_evaluation_option) using (evaluation_type_id)
	left join (ct_parent_evaluation_type) using (evaluation_type_id)
	left join (employee) using (user_id)
	where student_id = studentID
	and evaluation_date = evaluationDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCTEvaluationForStudent` (IN `studentID` BIGINT, IN `evaluationDate` DATE)  BEGIN
	select student_evaluation.*, ct_evaluation_option.*, ct_evaluation_type.*,
	concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name 
	from student_evaluation
	left join (ct_evaluation_option) using (evaluation_type_id)/*** No confusion, great combination. Twinggg!!! ***/
	left join (ct_evaluation_type) using (evaluation_type_id)
	left join (employee) using (user_id)
	where student_id = studentID
	and evaluation_date = evaluationDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCTGeneralRemarkForParent` (IN `studentID` BIGINT, IN `evaluationDate` DATE)  BEGIN
	select ct_parent_remarks.*, 
	concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name
	from ct_parent_remarks left join (employee) using (user_id)
	where student_id = studentID
	and evaluation_date = evaluationDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCTWeight` (OUT `ctWeight` INT, IN `terminalID` INT, IN `gradeID` INT)  BEGIN	
	select ct_weight into ctWeight from terminal_weight
	where terminal_id = terminalID and grade_id = gradeID;
	if ctWeight is null then
		select ct_weight into ctWeight from terminal_weight
		where terminal_id = terminalID and grade_id = 0;
	end if;
	if ctWeight is null then
		set ctWeight = 0;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCurrentBatch` ()  BEGIN
	select max(batch_name) from batch;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCurrentClassList` ()  BEGIN
	select class.class_id, concat_ws(' ', grade.grade_name, class.section) as class_name
	from class left join grade using (grade_id)
	where class.batch_id = (select max(batch_id) from batch)
	and class.is_deleted = 0
	order by grade.grade_order, class.section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCurrentPaymentSchemes` (IN `studentID` BIGINT, IN `batchID` INT, IN `gradeID` INT)  BEGIN
	create temporary table currentPayable as
	select payment_scheme.scheme_id, payment_scheme.due_date,
	payment_name.payment_name,
	sum(payment_headings.item_amount) as totalAmount 
	from payment_scheme
	left join payment_name using (payment_name_id)
	left join payment_headings on payment_scheme.scheme_id = payment_headings.payment_scheme_id
	left join bill_item on payment_headings.item_id = bill_item.item_id
	where batch_id = batchID and grade_id = gradeID
	and (bill_item.type_id is null or bill_item.type_id in (
				select type_id from payment_student_type 
				left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
				left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
				where student_id = studentID
				and (fromscheme.batch_id < batchID /*If fromscheme was in previous batches*/
						or 
					fromscheme.due_date <= (SELECT Max(due_date) from payment_scheme where batch_id = batchID and grade_id = gradeID and due_date >= curdate())) 
				and (uptoscheme.due_date is null or uptoscheme.due_date >= curdate())
			)
		)
	group by payment_scheme.scheme_id;
	
	create temporary table currentPaid as
	select payment_scheme.scheme_id, sum(payment_student.payment_amount) as paidAmount, sum(payment_student.fine_amount) as finePaid
	from payment_scheme left join payment_student on payment_scheme.scheme_id = payment_student.payment_scheme_id
	and payment_student.student_id = studentID
	where batch_id = batchID and grade_id = gradeID
	group by payment_scheme.scheme_id;
	create temporary table currentWaiver as
	select payment_scheme.scheme_id, sum(waiver_amount) as waiverAmount
	from payment_scheme left join payment_waiver on payment_scheme.scheme_id = payment_waiver.scheme_id
	and student_id = studentID
	where batch_id = batchID and grade_id = gradeID
	group by payment_scheme.scheme_id;
		
	select currentPayable.*, currentPaid.paidAmount, currentPaid.finePaid, currentWaiver.waiverAmount
	from currentPayable
	left join currentPaid using (scheme_id)
	left join currentWaiver using (scheme_id)
	order by due_date;
	drop table if exists currentPayable;
	drop table if exists currentPaid;
	drop table if exists currentWaiver;
	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCurrentSubjectTeachers` (IN `subjectID` INT)  BEGIN
	select subject.subject_name, subject_teacher.allocated_sessions, subject_type,
	class.class_id,
	concat_ws(' ', grade_name, section) as grade_section,
	concat_ws(' ', first_name, middle_name, last_name) as employee_name,
	employee.employee_id,
	subject_teacher.class_time, subject_teacher.class_start, subject_teacher.class_end
	from subject left join class on subject.grade_id = class.grade_id and class.passed_out = 0 and class.is_deleted = 0
	left join grade on class.grade_id = grade.grade_id
	left join subject_teacher on subject.subject_id = subject_teacher.subject_id and class.class_id = subject_teacher.class_id
	left join employee on subject_teacher.employee_id = employee.employee_id
	where subject.subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetCurrentTerminal` ()  BEGIN
	select * from terminal where is_current = 1;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetDistrictList` ()  BEGIN
	select * from district order by district_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetDivision` (IN `obtainedPercentage` DOUBLE, IN `gradeID` INT)  BEGIN
	select division from ranking where percentage = (select max(percentage) from ranking where percentage <= obtainedPercentage
	and grade_id = gradeID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetDroppedOutStudents` ()  BEGIN
	select student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, home_phone, gender,
	joined_batch, jgrade.grade_name as joined_grade,
	batch.batch_name, concat_ws(' ', grade.grade_name, class.section) as class_name
	from student
	left join class using (class_id)
	left join batch on class.batch_id = batch.batch_id
	left join grade as grade on class.grade_id = grade.grade_id
	left join grade as jgrade on student.joined_grade_id = jgrade.grade_id
	where student.deleted = 0
	and student.dropped_out = 1
	order by batch_name desc, grade.grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployee` (IN `employeeID` BIGINT)  BEGIN
	select * from employee where employee_id = employeeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeID` (IN `userID` VARCHAR(36))  BEGIN
	select employee_id from employee where user_id = userID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeLeaveReport` ()  BEGIN
	select sum(leave_days) as TotalLeave, concat_ws(' ', first_name, middle_name, last_name) as employee_name, employee.employee_id,
	batch_id, batch_name
	from employee_leave
	left join employee using (employee_id)
	left join batch on employee_leave.year_id = batch.batch_id
	Group by batch_id, employee_id
	order by batch_name desc, employee_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeList` ()  BEGIN
	select employee_id, 
	concat_ws(' ', first_name, middle_name, last_name) as employee_name,
	phone_no, email, Date_Format(joined_date, '%Y-%m-%d') as joined_date, status,
	picture_path, employee_type, user_id
	from employee;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeNameFromUserID` (IN `userID` VARCHAR(36))  BEGIN
	select concat_ws(' ', first_name, middle_name, last_name) from employee
	where user_id = userID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeProfile` (IN `employeeID` BIGINT)  BEGIN
	select
	employee_id,
	concat_ws(' ', first_name, middle_name, last_name) as employee_name,
	qualification,
	phone_no,
	email,
	picture_path,
	agreement_type,
	Date_Format(joined_date, '%Y/%m/%d') as joined_date,
	biodata_path,
	basic_salary,
	additionals,
	address,
	Date_Format(birth_date, '%Y/%m/%d') as birth_date,
	dept,
	employee_type,
	Date_Format(biodata_date, '%Y/%m/%d') as biodata_date,
	status,
	designation,
	code
	from employee 
	where employee_id = employeeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeTypeFromUserID` (IN `userID` VARCHAR(36))  BEGIN
	select employee_type from employee where user_id = userID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEmployeeUserID` (IN `employeeID` BIGINT)  BEGIN
	select user_id from employee where employee_id = employeeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEvaluationDatesForParent` (IN `studentID` BIGINT)  BEGIN
	select distinct evaluation_date from parent_evaluation where student_id = studentID order by evaluation_date desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEvaluationDatesForStudent` (IN `studentID` BIGINT)  BEGIN
	select distinct evaluation_date from student_evaluation where student_id = studentID order by evaluation_date desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEvaluationDatesForSubject` (IN `studentID` BIGINT, IN `subjectID` INT)  BEGIN
	select distinct evaluation_date from subject_evaluation where student_id = studentID and subject_id = subjectID
	order by evaluation_date desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetEvaluationForSubject` (IN `studentID` BIGINT, IN `subjectID` INT, IN `evaluationDate` DATE)  BEGIN
	select subject_evaluation.*, subject_evaluation_option.*, subject_evaluation_type.*,
	concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name
	from subject_evaluation
	left join (subject_evaluation_option) using (evaluation_type_id)
	left join (subject_evaluation_type) using (evaluation_type_id)
	left join (employee) using (user_id)
	where student_id = studentID
	and subject_id = subjectID
	and evaluation_date = evaluationDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetFacultyList` ()  BEGIN
	select employee.employee_id, 
	CONCAT_WS(' ',employee.first_name, employee.middle_name, employee.last_name) as teacher_name
	from employee where employee.employee_type = "Faculty"
	order by teacher_name asc; 	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetFemaleDistribution` ()  BEGIN
	select count(*) as total_number, class.class_id, gender, batch.batch_id, class.is_deleted,
	concat_ws(' ', grade_name, section) as class_name 
	from student
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	left join batch on class.batch_id = batch.batch_id
	where batch.batch_id = (select max(batch_id) from batch)
	and gender = 'Female'
	and class.is_deleted = 0
	and student.deleted = 0 and student.passed_out = 0 and student.dropped_out = 0
	group by class_id, gender
	order by grade.grade_order, gender;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGenderDistributionByClass` (IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	declare batchID int;
	select max(batch_id) into batchID from batch;
	if sectionName = '' then
		select count(*) as total_number, gender
		from student
		left join class using (class_id)
		where
		student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0 and student.passed_out = 0 and student.dropped_out = 0
		and class.is_deleted = 0
		group by gender;
	else
		select count(*) as total_number, gender
		from student
		left join class using (class_id)
		where
		student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		and student.deleted = 0 and student.passed_out = 0 and student.dropped_out = 0
		and class.is_deleted = 0
		group by gender;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGeneralCommentsByTeacher` (IN `employeeID` BIGINT, IN `fromDate` DATE, IN `toDate` DATE)  BEGIN
	select st_comment.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	comments, comment_date
	from st_comment left join
	student using (student_id)
	where st_comment.user_id = (select user_id from employee where employee_id = employeeID)
	and comment_date between fromDate and toDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGeneralSubjectCommentsByTeacher` (IN `employeeID` BIGINT, IN `fromDate` DATE, IN `toDate` DATE)  BEGIN
	select subject_remarks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	remarks, evaluation_date, subject_name
	from subject_remarks left join
	student using (student_id)
	left join subject using (subject_id)
	where subject_remarks.user_id = (select user_id from employee where employee_id = employeeID)
	and evaluation_date between fromDate and toDate;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGradeList` ()  BEGIN
	select * from grade order by grade_order;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGradeNameFromID` (IN `gradeID` INT)  BEGIN
	select grade_name from grade where grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetGuardianByName` (IN `guardianName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(' ' , st_fname, st_mname, st_lname) as student_name, 
	gender, student.passed_out, dropped_out,
	guardian_name, occupation_name as guardian_occupation, guardian_phone, guardian_email,
	batch.batch_name, grade.grade_name, class.section
	from student left join class on student.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	left join occupation on guardian_occupation_id = occupation.occupation_id
	where guardian_name like concat(guardianName,'%')
	and student.deleted = 0
	order by batch_name desc, grade.grade_order, section, guardian_name;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetHeadWiseCollectionByUser` (IN `fromDate` DATE, IN `toDate` DATE, IN `userID` INT)  BEGIN
	select bill_item.item_id, bill_item.item_name, sum(bill_detail.item_amount) as itemTotal
	from bill left join bill_detail using (bill_id)
	left join bill_item using (item_id)
	where bill.bill_date between fromDate and toDate
	and bill.receiver_user = userID
	group by bill_item.item_id
	order by bill_item.item_order;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetHeadWiseCollectionReport` ()  BEGIN
	select bill_item.item_id, bill_item.item_name, sum(bill_detail.item_amount) as itemTotal
	from bill_detail left join bill_item using (item_id)
	group by bill_item.item_id
	order by bill_item.item_order;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetHeadWiseDue` (IN `batchID` INT)  BEGIN
	/*First we get the payable amounts by heading*/
	create temporary table batchPayable as
	select bill_item.item_id, bill_item.item_name, bill_item.item_order, sum(payment_headings.item_amount) as payableAmount
	from student
	left join class using (class_id)
	left join payment_scheme on class.batch_id = payment_scheme.batch_id and class.grade_id = payment_scheme.grade_id
	and payment_scheme.due_date <= curdate()
	left join payment_headings on payment_scheme.scheme_id = payment_headings.payment_scheme_id
	left join bill_item on payment_headings.item_id = bill_item.item_id
	where class.batch_id = 10
	and student.deleted = 0 /*What about dropped out students : need to consider dropped out date as well...0h my!*/
	and (bill_item.type_id is null or bill_item.type_id in (
			select type_id from payment_student_type 
			left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
			left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
			where student_id = student.student_id
			and (fromscheme.batch_id < batchID /*If fromscheme was in previous batches*/
					or 
				fromscheme.due_date <= (SELECT Max(due_date) from payment_scheme where batch_id = batchID and grade_id = class.grade_id and due_date >= curdate())) 
			and (uptoscheme.due_date is null or uptoscheme.due_date >= curdate())
		)
	)
	and bill_item.item_id is not null
	group by bill_item.item_id;
	/*Then, we get the collected amounts head wise for the batch*/
	create temporary table batchPaid as
	select item_id, sum(bill_detail.item_amount) as paidAmount
	from bill_detail left join payment_student using (bill_id)
	left join payment_scheme on payment_student.payment_scheme_id = payment_scheme.scheme_id
	where payment_scheme.batch_id = batchID
	group by item_id;
	/*Then, we get the waivers by head for the batch*/
	create temporary table batchWaiver as
	select item_id, sum(waiver_amount) as waiverAmount
	from payment_waiver left join payment_scheme using (scheme_id)
	where payment_scheme.batch_id = batchID
	group by item_id;
	
	select batchPayable.*, batchPaid.paidAmount, batchWaiver.waiverAmount
	from batchPayable
	left join batchPaid using (item_id)
	left join batchWaiver using (item_id)
	order by item_order;
	drop table if exists batchPayable;
	drop table if exists batchPaid;
	drop table if exists batchWaiver;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetHouseList` ()  BEGIN
	select * from house;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastEvaluation` (IN `studentID` BIGINT, IN `evaluationTypeID` INT)  BEGIN
	select evaluation_id, remarks from student_evaluation
	where student_id = studentID and evaluation_type_id = evaluationTypeID
	and evaluation_date = (select max(evaluation_date) from student_evaluation where student_id = studentID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastEvaluationDate` (IN `studentID` BIGINT)  BEGIN
	select max(evaluation_date) from student_evaluation where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastEvaluationOnParent` (IN `studentID` BIGINT, IN `evaluationTypeID` INT)  BEGIN
	select evaluation_id, remarks from parent_evaluation
	where student_id = studentID and evaluation_type_id = evaluationTypeID
	and evaluation_date = (select max(evaluation_date) from parent_evaluation where student_id = studentID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastEvaluationOnSubject` (IN `studentID` BIGINT, IN `evaluationTypeID` INT, IN `subjectID` INT)  BEGIN
	select evaluation_id, remarks from subject_evaluation
	where student_id = studentID and evaluation_type_id = evaluationTypeID and subject_id = subjectID
	and evaluation_date = (select max(evaluation_date) from subject_evaluation where student_id = studentID 
	and subject_id = subjectID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastParentEvaluationDate` (IN `studentID` BIGINT)  BEGIN
	select max(evaluation_date) from parent_evaluation where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLastSubjectEvaluationDate` (IN `studentID` BIGINT, IN `subjectID` INT)  BEGIN
	select max(evaluation_date) from subject_evaluation where student_id = studentID and subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetLatestCTEvaluationForStudent` (IN `studentID` BIGINT)  BEGIN
	select * from student_evaluation
	left join (ct_evaluation_option) using (evaluation_type_id)
	left join (ct_evaluation_type) using (evaluation_type_id)
	where student_id = studentID
	and evaluation_date = (select max(evaluation_date) from student_evaluation where student_id = studentID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetMaleDistribution` ()  BEGIN
	select count(*) as total_number, class.class_id, gender, batch.batch_id, 
	concat_ws(' ', grade_name, section) as class_name 
	from student
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	left join batch on class.batch_id = batch.batch_id
	where batch.batch_id = (select max(batch_id) from batch)
	and gender = 'Male'
	and class.is_deleted = 0
	and student.deleted = 0 and student.passed_out = 0 and student.dropped_out = 0
	group by class_id, gender
	order by grade.grade_order, gender;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetMedicationsForStudent` (IN `studentID` BIGINT)  BEGIN
	select * from student_medication where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetOccupationList` ()  BEGIN
	select * from occupation order by occupation_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetOptionalSubjects` (IN `gradeID` INT)  BEGIN
	select * from subject where grade_id = gradeID and subject_type = 'OPTIONAL' and is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetParentByName` (IN `parentName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(' ', st_fname, st_lname) as student_name,
	father_name, father_cell, father_email, father_education,
	mother_name, mother_cell, mother_email, mother_education,
	student.class_id, concat_ws(' ', grade_name, section) as class_name
	from student left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where (class.is_deleted = 0 or class.is_deleted is null)
	and student.deleted = 0
	and (father_name like concat(parentName,'%') or mother_name like concat(parentName,'%'))
	order by grade.grade_order, section, student_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetParentListByDistrict` (IN `districtID` INT)  BEGIN
	select student_id, concat_ws(' ', st_fname, st_lname) as student_name,
	father_name, father_cell, father_email, father_education,
	mother_name, mother_cell, mother_email, mother_education,
	student.class_id,
	batch.batch_name, grade.grade_name, class.section
	from student left join class on student.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	where (class.is_deleted = 0 or class.is_deleted is null)
	and student.deleted = 0
	and student.district_id = districtID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetParentsNCo` (IN `studentID` INT)  BEGIN
	select
		student.home_phone, student.home_address,
		father_name, father_cell, father_employer, fo.occupation_name as father_occupation, 
		father_business_add, father_email, father_education,
		mother_name, mother_cell, mother_employer, mo.occupation_name as mother_occupation,
		mother_business_add, mother_email, mother_education,
		guardian_name, go.occupation_name as guardian_occupation, 
		guardian_phone, guardian_email,
		emergency_contact, ec_address, ec_relation, ec_phone
		from student
		left join occupation fo on fo.occupation_id = father_occupation_id
		left join occupation mo on mo.occupation_id = mother_occupation_id
		left join occupation go on go.occupation_id = guardian_occupation_id
	where student.student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetPaymentWaivers` (IN `schemeID` INT, IN `studentID` BIGINT)  BEGIN
	select payment_headings.item_id, item_name, payment_headings.item_amount,payment_scheme_id,
	waiver_amount
	from payment_headings
	left join bill_item using (item_id)
	left join payment_waiver on payment_headings.item_id = payment_waiver.item_id and payment_waiver.student_id = studentID
	and payment_waiver.scheme_id = schemeID
	where payment_headings.payment_scheme_id = schemeID
	and (bill_item.type_id is null or bill_item.type_id in (select type_id from student 
left join item_type on student.boarding_type = item_type.type_name
where student_id = studentID) or bill_item.type_id in (select type_id from student left join bus_stop using (stop_id)
where student_id = studentID));
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetPickUpPoints` (IN `prefixText` VARCHAR(127))  BEGIN
	declare searchText varchar(128);
	set searchText = concat(prefixText, '%');
	select distinct pickup_point from student where pickup_point like searchText;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetPictureBaseName` (IN `classID` INT)  BEGIN
	select concat(batch_name,grade_name) as base_name from class
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	where class.class_id = classID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetQuestionPosters` (IN `subjectID` INT, IN `batchID` INT)  BEGIN
	
	select distinct employee.employee_id, concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name
	from questions left join employee on questions.posted_by = employee.employee_id
	where questions.batch_id = batchID and questions.subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSchoolList` ()  BEGIN
	select * from school order by school_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSectionList` ()  BEGIN
	select * from section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSiblings` (IN `studentID` BIGINT)  BEGIN
	select * from sibling where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudent` (IN `studentID` BIGINT)  BEGIN
	select * from student where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentAchievement` (IN `studentID` BIGINT)  BEGIN
	select * from student_achievement where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentAttendance` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `terminalID` INT)  BEGIN
	if sectionName = '' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll,
		present_days, absent_days, leave_days, total_days,
		student_attendance.class_id 
		from student_attendance left join student
		on student_attendance.student_id = student.student_id
		where student_attendance.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		and student_attendance.terminal_id = terminalID
		order by student_name;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll,
		present_days, absent_days, leave_days, total_days,
		student_attendance.class_id 
		from student_attendance left join student
		on student_attendance.student_id = student.student_id
		where student_attendance.class_id = (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		and student.deleted = 0
		and student_attendance.terminal_id = terminalID
		order by student_name;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentClassName` (IN `studentID` BIGINT)  BEGIN
	select concat_ws(' ', grade.grade_name, class.section) as class_name
	from student
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where student.student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentCommentsByClass` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `fromDate` DATE, IN `toDate` DATE)  BEGIN
	if sectionName = '' then
		select st_comment.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as comment_by,
		comments, comment_date
		from st_comment left join
		student using (student_id)
		left join employee on st_comment.user_id = employee.user_id
		where class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and comment_date between fromDate and toDate;
	else
		select st_comment.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as comment_by,
		comments, comment_date
		from st_comment left join
		student using (student_id)
		left join employee on st_comment.user_id = employee.user_id
		where class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID 
		and section = sectionName)
		and comment_date between fromDate and toDate;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentDataForReport` (IN `studentID` BIGINT)  BEGIN
	select
	student_id,
	concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	concat_ws(' ', grade_name, section) as class_name,
	current_roll,
	picture_path,
	grade.grade_id, class.class_id, class.batch_id
	from student 
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where student.student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentDesignation` (IN `studentID` BIGINT)  BEGIN
	select * from student_designation where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentDoctors` (IN `studentID` BIGINT)  BEGIN
	select * from doctor where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentGame` (IN `studentID` BIGINT)  BEGIN
	select * from student_game where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentHeadingPayments` (IN `schemeID` INT, IN `studentID` BIGINT)  BEGIN
	declare dueDate date;
	select due_date into dueDate from payment_scheme where scheme_id = schemeID;
	/*Gets the list of items and amounts for a particular scheme (based on grade/batch), while also filtering items like
	transport, hostel and day boarder which are specific to students*/
	select payment_headings.item_id, item_name, payment_headings.item_amount, payment_heading_id, payment_scheme_id,
	(select GetPaidAmount(payment_headings.item_id, studentID, schemeID)) as paid_amount,
	waiver_amount
	from payment_headings
	left join bill_item using (item_id)
	left join payment_waiver on payment_headings.item_id = payment_waiver.item_id and payment_waiver.student_id = studentID
	and payment_waiver.scheme_id = schemeID
	where payment_headings.payment_scheme_id = schemeID
	and (bill_item.type_id is null or bill_item.type_id in (
		select type_id from payment_student_type 
		left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
		left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
		where student_id = studentID
		and fromscheme.due_date <= dueDate and (uptoscheme.due_date is null or uptoscheme.due_date >= dueDate)
		/*we can use due_date from fromscheme in this case as we are dealing with current scheme and not current date*/
	)
);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentHeadWiseReport` (IN `batchID` INT, IN `gradeID` INT, IN `studentID` BIGINT)  BEGIN
	/*Get Payable*/
	create temporary table studentPayable as
	select bill_item.item_id, bill_item.item_name, bill_item.item_order, sum(payment_headings.item_amount) as payableAmount
	from payment_scheme
	left join payment_headings on payment_scheme.scheme_id = payment_headings.payment_scheme_id
	left join bill_item on payment_headings.item_id = bill_item.item_id
	where payment_scheme.batch_id = batchID and payment_scheme.grade_id = gradeID
	and (bill_item.type_id is null or bill_item.type_id in (
			select type_id from payment_student_type 
			left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
			left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
			where student_id = studentID
			and (fromscheme.batch_id < batchID /*If fromscheme was in previous batches*/
					or 
				fromscheme.due_date <= (SELECT Max(due_date) from payment_scheme where batch_id = batchID and grade_id = gradeID and due_date >= curdate()))
			and (uptoscheme.due_date is null or uptoscheme.due_date >= curdate())
		)
	)
	group by bill_item.item_id;
	/*Get Paid*/
	create temporary table studentPaid as
	select item_id, sum(bill_detail.item_amount) as paidAmount
	from bill_detail left join payment_student using (bill_id)
	left join payment_scheme on payment_student.payment_scheme_id = payment_scheme.scheme_id
	where payment_scheme.batch_id = batchID
	and payment_scheme.grade_id = gradeID
	and payment_student.student_id = studentID
	group by item_id;
	
	/*Get Waiver*/
	create temporary table studentWaiver as
	select item_id, sum(waiver_amount) as waiverAmount
	from payment_waiver left join payment_scheme using (scheme_id)
	where payment_waiver.student_id = studentID
	and payment_scheme.batch_id = batchID and payment_scheme.grade_id = gradeID	
	group by item_id;
	select studentPayable.*, studentPaid.paidAmount, studentWaiver.waiverAmount
	from studentPayable
	left join studentPaid using (item_id)
	left join studentWaiver using (item_id)
	order by item_order;
	drop table if exists studentPayable;
	drop table if exists studentPaid;
	drop table if exists studentWaiver;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentHobby` (IN `studentID` BIGINT)  BEGIN
	select * from student_hobby where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentList` ()  BEGIN
	select st_fname, st_mname, st_lname, gender, email from student where student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByClass` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	declare classID int;
	select class_id into classID from class where batch_id = batchID and grade_id = gradeID and section = sectionName;
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	Date_Format(st_dob, '%Y/%m/%d') as st_dob,
	gender,
	picture_path
	from student where class_id = classID
	and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByClassID` (IN `classID` INT)  BEGIN
	select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, 
	Date_Format(st_dob, '%Y/%m/%d') as st_dob, gender, 
	picture_path, class_representative.cr_id
	from student
	left join class_representative on student.student_id = class_representative.student_id
	and class_representative.class_id = classID
	where student.class_id = classID
	and student.deleted = 0
	order by student_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByDistrict` (IN `districtID` INT)  BEGIN
	select student_id, concat_ws(" ", st_fname, st_mname, st_lname) as student_name,
	picture_path
	from student
	where district_id = districtID
	and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByEmail` (IN `emailAddress` VARCHAR(128))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where email like concat('%',emailAddress,'%') and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByFirstName` (IN `firstName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where st_fname like concat(firstName,'%') and student.deleted = 0
	order by st_fname;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByGuardianName` (IN `guardianName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where guardian_name like concat(guardianName,'%') and student.deleted = 0 order by guardian_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByGuardianOccupation` (IN `occupationID` INT)  BEGIN
	select student_id, concat_ws(' ' , st_fname, st_mname, st_lname) as student_name, 
	gender, student.passed_out, dropped_out,
	guardian_name, occupation_name as guardian_occupation, guardian_phone, guardian_email,
	batch.batch_name, grade.grade_name, class.section
	from student left join class on student.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	left join occupation on guardian_occupation_id = occupation.occupation_id
	where guardian_occupation_id = occupationID
	and student.deleted = 0
	order by batch_name desc, grade.grade_order, section, student_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByLastName` (IN `lastName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where st_lname like concat(lastName,'%') and student.deleted = 0 order by st_lname;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByParentName` (IN `parentName` VARCHAR(100))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where (father_name like concat(parentName,'%') or mother_name like concat(parentName,'%'))
	and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByParentOccupation` (IN `occupationID` INT)  BEGIN
	select student_id, concat_ws(' ' , st_fname, st_mname, st_lname) as student_name, 
	gender, home_phone, email, student.passed_out, dropped_out,
	father_name, mother_name, fo.occupation_name as father_occupation, mo.occupation_name as mother_occupation,
	grade.grade_name as last_grade,
	gr.grade_name as current_grade
	from student left join class on student.class_id = class.class_id
	left join grade on student.last_grade_id = grade.grade_id
	left join grade gr on class.grade_id = gr.grade_id
	left join occupation as fo on father_occupation_id = fo.occupation_id
	left join occupation as mo on mother_occupation_id = mo.occupation_id
	where (father_occupation_id = occupationID or mother_occupation_id = occupationID)
	and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByPhoneNumber` (IN `phoneNumber` VARCHAR(50))  BEGIN
	select student_id, concat_ws(" ", st_fname, st_lname) as student_name,
	picture_path
	from student
	where home_phone like concat('%',phoneNumber,'%')
	and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByPickUpPoint` (IN `pickPlace` VARCHAR(128))  BEGIN
	select student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	concat_ws(' ', grade.grade_name, class.section) as class_name,
	current_roll, pickup_point, pickup_time, drop_time, passed_out, dropped_out
	from student
	left join class using (class_id)
	left join grade on class.grade_id = grade.grade_id
	where student.pickup_point like concat(pickPlace,'%') and student.deleted = 0
	and student.passed_out = 0 and student.dropped_out = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListByPreviousSchool` (IN `previousSchoolID` INT)  BEGIN
	select student_id, concat_ws(' ' , st_fname, st_mname, st_lname) as student_name, 
	gender, st_dob, home_phone, email, joined_date,
	grade.grade_name as last_grade,
	gr.grade_name as current_grade
	from student left join class on student.class_id = class.class_id
	left join grade on student.last_grade_id = grade.grade_id
	left join grade gr on class.grade_id = gr.grade_id
	where last_school_id = previousSchoolID
	and student.passed_out = 0 and student.dropped_out = 0 and student.deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListBySubject` (IN `subjectID` INT, IN `classID` INT)  BEGIN
	declare subjectType varchar(20);
	select subject_type into subjectType from subject where subject_id = subjectID;
	
	if subjectType = 'COMPULSORY' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, 
		Date_Format(st_dob, '%Y/%m/%d') as st_dob, gender, 
		picture_path
		from student
		where student.class_id = classID
		and student.deleted = 0
		order by student_name;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, 
		Date_Format(st_dob, '%Y/%m/%d') as st_dob, gender, 
		picture_path
		from student
		left join student_optional on student.student_id = student_optional.student_id
		and student_optional.subject_id = subjectID
		where student.class_id = classID
		and student.deleted = 0
		and student_optional.student_id is not null
		order by student_name;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListForClassAttendance` (IN `classID` INT, IN `terminalID` INT)  BEGIN
	select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll,
	present_days, absent_days, leave_days, total_days 
	from student left join student_attendance
	on student.student_id = student_attendance.student_id
	and student.class_id = student_attendance.class_id
	and student_attendance.terminal_id = terminalID
	where student.class_id = classID and student.deleted = 0
	order by student_name;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentListForClassChange` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and student.class_id = st_marks.class_id
		left join student_status on student.student_id = student_status.student_id
		and student.class_id = student_status.class_id
		and student_status.terminal_id = 0
		where student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		group by student.student_id
		order by total desc;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and student.class_id = st_marks.class_id
		left join student_status on student.student_id = student_status.student_id
		and student.class_id = student_status.class_id
		and student_status.terminal_id = 0
		where student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		and student.deleted = 0
		group by student.student_id
		order by total desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentNameFromID` (IN `studentID` BIGINT)  BEGIN
	select concat_ws(' ', st_fname, st_mname, st_lname) from student where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentProfile` (IN `studentID` BIGINT)  BEGIN
	select
	student_id,
	concat_ws(' ', st_fname, st_mname, st_lname) as student_name, st_lname,
	Date_Format(st_dob, '%Y/%m/%d') as st_dob,
	registration_number,
	birth_place, gender, home_phone, home_address, district_name,
	joined_batch, jgrade.grade_name as joined_grade,
	father_name, mother_name, guardian_name, blood_group, email, picture_path,
	boarding_type, transport_type, school_name, grade.grade_name, section, lgrade.grade_name as last_grade,
	house_name, current_roll, class.grade_id, student.class_id,
	class.batch_id,	birth_mark, weight, height, special_needs,family_number
	from student 
	left join school on student.last_school_id = school.school_id
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	left join house on student.house_id = house.house_id
	left join district on student.district_id = district.district_id
	left join grade jgrade on student.joined_grade_id = jgrade.grade_id
	left join grade lgrade on student.last_grade_id = lgrade.grade_id
	where student.student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentRank` (IN `studentID` BIGINT, IN `batchID` INT, IN `gradeID` INT, IN `terminalID` INT)  BEGIN
	declare studentTotal double;drop table if exists classRank;
	create temporary table classRank as
	select st_marks.student_id, st_marks.terminal_id, sum(total_marks) as grandTotal, student_status.confirmed_status
	from st_marks
	left join student_status
	on st_marks.student_id = student_status.student_id and st_marks.terminal_id = student_status.terminal_id
	and st_marks.class_id = student_status.class_id
	where st_marks.terminal_id = terminalID
	and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
	group by student_id;
	select confirmed_status into @studentStatus from classRank where student_id = studentID;
	if @studentStatus = 'PASS' then
		select grandTotal into studentTotal from classRank where student_id = studentID;
		select count(*)+1 from classRank where grandTotal > studentTotal and confirmed_status = 'PASS';
	else
		select -1;
	end if;
	drop table if exists classRank;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentsForGradeChange` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select aggregate_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name from student
		left join class_result on student.student_id = class_result.student_id
		where student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		order by aggregate_marks desc;
	else
		select aggregate_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name from student
		left join class_result on student.student_id = class_result.student_id
		where student.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID 
		and section = sectionName)
		and student.deleted = 0
		order by aggregate_marks desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentsForOptionalAssignment` (IN `gradeID` INT, IN `subjectID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll, subject_id 
		from student 
		left join student_optional on student.student_id = student_optional.student_id
		and student_optional.subject_id = subjectID
		where 
		class_id in (select class_id from class where grade_id = gradeID and batch_id = (select max(batch_id) from batch))
		and student.deleted = 0
		order by current_roll, student_name asc;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll, subject_id 
		from student 
		left join student_optional on student.student_id = student_optional.student_id
		and student_optional.subject_id = subjectID
		where 
		class_id in (select class_id from class where grade_id = gradeID and batch_id = (select max(batch_id) from batch)
		and section = sectionName)
		and student.deleted = 0
		order by current_roll, student_name asc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetStudentTerminalRank` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT, IN `terminalID` INT)  BEGIN
	drop temporary table if exists tbl;
	create temporary table tbl
	select student_id, sum(total_marks) as total from st_marks where terminal_id = terminalID
	and class_id in (select class_id from class where grade_id = gradeID and batch_id = batchID) 
	group by student_id;
	select total into @studentTotal from tbl where student_id = studentID;
	select count(*)+1 as rank from tbl
	where tbl.total > @studentTotal;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectCommentsForStudent` (IN `studentID` BIGINT)  BEGIN
	select 
	comment_id,
	comments,
	Date_Format(date, '%e %b %Y') as date,
	concat(employee.first_name, " ", employee.last_name) as comment_by,
	subject_name
	from subject_comment
	left join employee on subject_comment.user_id = employee.user_id
	left join subject on subject_comment.subject_id = subject.subject_id
	where subject_comment.student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectEvaluationOptions` (IN `evaluationTypeID` INT)  BEGIN
	select * from subject_evaluation_option where evaluation_type_id = evaluationTypeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectEvaluationTypes` ()  BEGIN
	select * from subject_evaluation_type;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectFullMarks` (IN `subjectID` INT)  BEGIN
	select full_marks from subject where subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectGeneralRemark` (IN `studentID` BIGINT, IN `evaluationDate` DATE, IN `subjectID` INT)  BEGIN
	select subject_remarks.*, 
	concat_ws(' ', employee.first_name, employee.middle_name, employee.last_name) as employee_name
	from subject_remarks left join (employee) using (user_id)
	where student_id = studentID
	and evaluation_date = evaluationDate
	and subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectGradeFromMarks` (IN `subjectID` INT, IN `batchID` INT, IN `marks` DOUBLE)  BEGIN
	select grade_name from subject_grading where subject_id = subjectID and
	batch_id = batchID and min_marks <= marks
	order by min_marks desc
	limit 0,1;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectListByClass` (IN `classID` INT)  BEGIN
	declare gradeID int;
	select grade_id into gradeID from class where class_id = classID;
	select * from subject where grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectListByGrade` (IN `gradeID` INT)  BEGIN
	select * from subject where grade_id = gradeID and is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectListByStudent` (IN `studentID` BIGINT)  BEGIN
	declare classID int;
	declare gradeID int;
	select class_id into classID from student where student_id = studentID;
	select grade_id into gradeID from class where class_id = classID;
	select * from subject where grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectMarksForClass` (IN `classID` INT, IN `subjectID` INT, IN `terminalID` INT)  BEGIN
	declare subjectType varchar(20);
	select subject_type into subjectType from subject where subject_id = subjectID;
	select batch_id into @bID from batch where batch_name = (select max(batch_name) from batch);
	
	if subjectType = 'COMPULSORY' then
		select student.student_id, concat_ws(' ',st_fname, st_mname, st_lname) as student_name, current_roll,
		obtained_marks, obtained_grade, ct_marks, wt_obtained_marks, total_marks, wt_total_marks
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and st_marks.subject_id = subjectID and st_marks.terminal_id = terminalID
		where student.class_id = classID and student.deleted = 0
		order by student_name asc;
	else
		select student.student_id, concat_ws(' ',st_fname, st_mname, st_lname) as student_name, current_roll,
		obtained_marks, obtained_grade, ct_marks, wt_obtained_marks, total_marks, wt_total_marks
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and st_marks.subject_id = subjectID and st_marks.terminal_id = terminalID
		where student.class_id = classID
		and student.student_id in (select student_id from student_optional where subject_id = subjectID)
		and student.deleted = 0
		order by student_name asc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectMarksForStudents` (IN `gradeID` INT, IN `subjectID` INT, IN `terminalID` INT)  BEGIN
	declare subjectType varchar(20);
	select subject_type into subjectType from subject where subject_id = subjectID;
	select batch_id into @bID from batch where batch_name = (select max(batch_name) from batch);
	
	if subjectType = 'COMPULSORY' then
		select student.student_id, concat_ws(' ',st_fname, st_mname, st_lname) as student_name, current_roll,
		obtained_marks, obtained_grade, ct_marks, wt_obtained_marks, total_marks, wt_total_marks
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and st_marks.subject_id = subjectID and st_marks.terminal_id = terminalID
		where student.class_id in 
		(select class_id from class where grade_id = gradeID and batch_id = @bID)
		and student.deleted = 0
		order by student_name asc;
	else
		select student.student_id, concat_ws(' ',st_fname, st_mname, st_lname) as student_name, current_roll,
		obtained_marks, obtained_grade, ct_marks, wt_obtained_marks, total_marks, wt_total_marks
		from student 
		left join st_marks on student.student_id = st_marks.student_id
		and st_marks.subject_id = subjectID and st_marks.terminal_id = terminalID
		where student.class_id in 
		(select class_id from class where grade_id = gradeID and batch_id = @bID)
		and student.student_id in (select student_id from student_optional where subject_id = subjectID)
		and student.deleted = 0
		order by student_name asc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectName` (IN `subjectID` INT)  BEGIN
	select subject_name from subject where subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetSubjectProgressForStudent` (IN `studentID` BIGINT, IN `subjectID` INT)  BEGIN
	select terminal_id, total_marks from st_marks where student_id = studentID and subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalExamSummary` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `terminalID` INT)  BEGIN
	if sectionName = '' then
		select sum(wt_total_marks) as total, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from student
		left join st_marks on student.student_id = st_marks.student_id 
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		where terminal_id = terminalID 
		and student.deleted = 0	
		group by student_id 
		order by sum(wt_total_marks) desc;
	else
		select sum(wt_total_marks) as total, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name
		from student
		left join st_marks on student.student_id = st_marks.student_id 
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID 
		and section = sectionName)
		where terminal_id = terminalID 
		and student.deleted = 0
		group by student_id 
		order by sum(wt_total_marks) desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalList` ()  BEGIN
	select * from terminal where is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalName` (IN `terminalID` INT)  BEGIN
	select terminal_name from terminal where terminal_id = terminalID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalResult` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `terminalID` INT)  BEGIN
	if sectionName = '' then
		select terminal_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from terminal_result
		left join student on terminal_result.student_id = student.student_id
		and student.deleted = 0
		where terminal_result.terminal_id = terminalID
		and terminal_result.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		order by terminal_marks desc;
	else
		select terminal_marks as total, full_marks, status, student.student_id, 
		concat_ws(' ', st_fname, st_mname, st_lname) as student_name 
		from terminal_result
		left join student on terminal_result.student_id = student.student_id
		and student.deleted = 0
		where terminal_result.terminal_id = terminalID 
		and terminal_result.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		order by terminal_marks desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminals` (IN `gradeID` INT)  BEGIN
	select terminal.*, terminal_weight.grade_id, terminal_weight.weightage, terminal_weight.ct_weight
	from terminal left join terminal_weight on (terminal.terminal_id = terminal_weight.terminal_id
	and grade_id = gradeID)
	where terminal.is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalSummaryReport` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `terminalID` INT)  BEGIN
	if sectionName = '' then
		select st_marks.student_id, st_marks.terminal_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from st_marks 
		left join student on st_marks.student_id = student.student_id
		left join student_status on st_marks.student_id = student_status.student_id 
		and st_marks.terminal_id = student_status.terminal_id
		and st_marks.class_id = student_status.class_id
		where st_marks.terminal_id = terminalID
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID) 
		and student.deleted = 0
		group by st_marks.student_id
		order by total desc;
	else
		select st_marks.student_id, st_marks.terminal_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
		sum(total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
		confirmed_status as status
		from st_marks 
		left join student  on st_marks.student_id = student.student_id
		left join student_status on st_marks.student_id = student_status.student_id 
		and st_marks.terminal_id = student_status.terminal_id
		and st_marks.class_id = student_status.class_id
		where st_marks.terminal_id = terminalID
		and st_marks.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName) 
		 and student.deleted = 0
		group by st_marks.student_id
		order by total desc;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalTopperList` (IN `batchID` INT, IN `terminalID` INT)  BEGIN
	select student_id, student_name, max(total) as total, full_marks, status, class_id, class_name, picture_path, gender
	from (select st_marks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	sum(total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
	confirmed_status as status,
	st_marks.class_id, concat_ws(' ', grade_name, section) as class_name,
	grade_order, section,
	student.picture_path, student.gender
	from st_marks 
	left join student using (student_id)
	left join student_status on st_marks.student_id = student_status.student_id
	and st_marks.terminal_id = student_status.terminal_id
	and st_marks.class_id = student_status.class_id
	left join class on st_marks.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	where  st_marks.terminal_id = terminalID
	and st_marks.class_id  in (select class_id from class where batch_id=batchID)/*It also ensures that multiple classes are not included for the same student and therefore we can group by student_id*/
	and student.deleted = 0
	group by st_marks.student_id) tempTable /*If grade topper is to be found rather than individual class, then we can add group by grade_id*/
	group by class_id order by grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTerminalWeight` (OUT `termWeight` INT, IN `terminalID` INT, IN `gradeID` INT)  BEGIN	
	select weightage into termWeight from terminal_weight
	where terminal_id = terminalID and grade_id = gradeID;
	if termWeight is null then
		select weightage into termWeight from terminal_weight
		where terminal_id = terminalID and grade_id = 0;
	end if;
	if termWeight is null then
		set termWeight = 0;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTopicDetails` (IN `topicID` INT)  BEGIN
	select * from topic where topic_id = topicID and is_deleted = 0;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTopicPlan` (IN `subjectID` INT, IN `parentID` BIGINT, IN `employeeID` BIGINT)  BEGIN
	select * from topic 
	left join topic_plan on topic.topic_id = topic_plan.topic_id and topic_plan.employee_id = employeeID
	where topic.subject_id = subjectID and topic.parent_id = parentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTopics` ()  BEGIN
	select * from topic;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTopicsInSubject` (IN `subjectID` INT)  BEGIN
	select * from topic where subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTopperListByYear` (IN `batchID` INT)  BEGIN
	select student_id, student_name, max(total) as total, full_marks, status, class_id, class_name, picture_path, gender
	from (select st_marks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
	confirmed_status as status,
	st_marks.class_id, concat_ws(' ', grade_name, section) as class_name,
	grade_order, section,
	student.picture_path, student.gender
	from st_marks 
	left join student using (student_id)
	left join student_status on st_marks.student_id = student_status.student_id
	and st_marks.class_id = student_status.class_id
	and student_status.terminal_id = 0
	left join class on st_marks.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	where st_marks.class_id  in (select class_id from class where batch_id=batchID)
	and student.deleted = 0
	group by st_marks.student_id) tempTable
	group by class_id order by grade_order, section;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTotalCollected` ()  BEGIN
	select batch_name, grade_name, sum(payment_amount) as totalPaid, sum(fine_amount) as totalFine from
	payment_scheme left join payment_student on payment_scheme.scheme_id = payment_student.payment_scheme_id
	left join batch on payment_scheme.batch_id = batch.batch_id
	left join grade on payment_scheme.grade_id = grade.grade_id
	group by payment_scheme.batch_id , payment_scheme.grade_id
	order by batch.batch_id, grade.grade_order;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTotalExamStudents` (IN `gradeID` INT, IN `batchID` INT, IN `terminalID` INT)  BEGIN
	select count(distinct student_id) as totalStudents from st_marks where
	class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
	and terminal_id = terminalID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTotalFullMarks` (OUT `totalFM` DOUBLE, IN `studentID` INT, IN `gradeID` INT, IN `batchID` INT)  BEGIN
	declare cmpFM double;
	declare optFM double;
	declare totalFullMarks double;
	select sum(full_marks) into cmpFM from subject where grade_id = gradeID
	and subject_type = 'COMPULSORY'
	and added_batch <= batchID 
	and (removed_batch is null or removed_batch > batchID);
	select sum(full_marks) into optFM from subject where grade_id = gradeID
	and subject_id in 
	(select subject_id from student_optional where student_id = studentID and grade_id = gradeID);
	if optFM is not null then
		select (cmpFM + optFM) into totalFM;
	else
		select cmpFM into totalFM;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTotalGenderCount` ()  BEGIN
	select count(*) as total_number, gender, batch.batch_id
	from student
	left join class on student.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	where batch.batch_id = (select max(batch_id) from batch)
	and student.deleted = 0 and student.passed_out = 0 and student.dropped_out = 0
	and class.is_deleted = 0
	group by gender;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTotalStudentAttendance` (IN `batchID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20))  BEGIN
	if sectionName = '' then
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll,
		sum(present_days) as present_days, sum(absent_days) as absent_days, 
		sum(leave_days) as leave_days, sum(total_days) as total_days,
		student_attendance.class_id
		from student_attendance left join student
		on student_attendance.student_id = student.student_id
		where student_attendance.class_id in (select class_id from class where batch_id = batchID and grade_id = gradeID)
		and student.deleted = 0
		group by student_attendance.student_id
		order by student_name;
	else
		select student.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name, current_roll,
		sum(present_days) as present_days, sum(absent_days) as absent_days, 
		sum(leave_days) as leave_days, sum(total_days) as total_days,
		student_attendance.class_id
		from student_attendance left join student
		on student_attendance.student_id = student.student_id
		where student_attendance.class_id = (select class_id from class where batch_id = batchID and grade_id = gradeID
		and section = sectionName)
		and student.deleted = 0
		group by student_attendance.student_id
		order by student_name;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetTypesForStudent` (IN `studentID` BIGINT)  BEGIN
	select payment_student_type.student_type_id, item_type.type_id, item_type.type_name,
	frombatch.batch_name as from_batch, fromgrade.grade_name as from_grade, fromname.payment_name as from_name,
	uptobatch.batch_name as upto_batch, uptograde.grade_name as upto_grade, uptoname.payment_name as upto_name
	from payment_student_type left join item_type using (type_id)
	left join payment_scheme fromscheme on payment_student_type.from_scheme = fromscheme.scheme_id
	left join payment_name fromname on fromscheme.payment_name_id = fromname.payment_name_id
	left join batch frombatch on fromscheme.batch_id = frombatch.batch_id
	left join grade fromgrade on fromscheme.grade_id = fromgrade.grade_id
	left join payment_scheme uptoscheme on payment_student_type.upto_scheme = uptoscheme.scheme_id
	left join payment_name uptoname on uptoscheme.payment_name_id = uptoname.payment_name_id
	left join batch uptobatch on uptoscheme.batch_id = uptobatch.batch_id
	left join grade uptograde on uptoscheme.grade_id = uptograde.grade_id
	where payment_student_type.student_id = studentID;
	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetUsedTerminalIDs` (IN `studentID` INT, IN `batchID` INT, IN `gradeID` INT)  BEGIN
	/*declare classID int;
	declare gradeID int;
	select student.class_id into classID from student where student_id = studentID;
	select class.grade_id into gradeID from class where class_id = classID;*/
	select distinct terminal_id from st_marks where student_id = studentID and 
	subject_id in 
	(select subject_id from subject where grade_id = gradeID
	and subject.added_batch <= batchID 
	and (subject.removed_batch is null or subject.removed_batch > batchID));
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spGetWaivers` (IN `batchID` INT, IN `gradeID` INT, IN `monthID` INT)  BEGIN
/*This is deprecated*/
	if monthID = 0 then
		select bill_amount.amount_id, bill_amount.item_amount, bill_amount.is_monthly,
			bill_item.item_name, bill_item.item_type, bill_item.item_description, bill_item.item_order,
			waiver.waiver_amount
		from bill_amount left join bill_item on bill_amount.item_id = bill_item.item_id
		left join waiver on bill_amount.amount_id = waiver.amount_id and waiver.month_id = monthID
		where bill_amount.batch_id = batchID and bill_amount.grade_id = gradeID;
	else
		select bill_amount.amount_id, bill_amount.item_amount, bill_amount.is_monthly,
                bill_item.item_name, bill_item.item_type, bill_item.item_description, bill_item.item_order,
                waiver.waiver_amount
		from bill_amount left join bill_item on bill_amount.item_id = bill_item.item_id
		left join waiver on bill_amount.amount_id = waiver.amount_id and waiver.month_id = monthID
		where bill_amount.batch_id = batchID and bill_amount.grade_id = gradeID
		and bill_amount.is_monthly = 1;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertBatch` (OUT `batchID` INT, IN `batchName` VARCHAR(20), IN `copyPrevious` BOOL)  BEGIN
	select batch_id into batchID from batch where batch_name = batchName;
	
	if batchID is null then
		insert into batch (batch_name) values (batchName);
		select Last_Insert_ID() into batchID;
		
		-- Set all previous classes to passed out
		update class set passed_out = 1 where passed_out = 0;
		-- Create default classes for new year
		if copyPrevious then
			Call internalCopyPreviousClasses(batchID);
		else	
			call internalAddClassesForNewBatch(batchID);
		END if;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertClass` (OUT `classID` INT, IN `gradeID` INT, IN `sectionName` VARCHAR(20), IN `classTeacherID` INT, IN `isPassedOut` BOOL, IN `isDeleted` BOOL, IN `className` VARCHAR(30))  BEGIN
	declare batchID int;
	select batch_id into batchID from batch where batch_name = (select max(batch_name) from batch);
	select class_id into classID from class where grade_id = gradeID and section = sectionName and batch_id = batchID;
	
	if classID is null then
	insert into class (grade_id, section, batch_id, class_teacher_id, passed_out, is_deleted, class_name) 
	values (gradeID, sectionName, batchID, classTeacherID, isPassedOut, isDeleted, className);
	select Last_Insert_ID() into classID;
	
	else
	update class set class_teacher_id = classTeacherID, passed_out = isPassedOut, is_deleted = isDeleted, class_name = className
	where class_id = classID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertCourseTopic` (OUT `courseTopicID` BIGINT, IN `courseTopicTitle` VARCHAR(100), IN `subjectTeacherID` INT)  BEGIN
	select cp_course_topic_id into courseTopicID from cp_course_topic where
	course_topic_title = courseTopicTitle and subject_teacher_id = subjectTeacherID;
	
	if courseTopicID is null then	
		insert into cp_course_topic (course_topic_title, subject_teacher_id)
		values (courseTopicTitle, subjectTeacherID);
		
		select Last_Insert_ID() into courseTopicID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertDistrict` (OUT `districtID` INT, IN `districtName` VARCHAR(64))  BEGIN
	select district_id into districtID from district where district_name = districtName;
	
	if districtID is null then
	insert into district (district_name) values (districtName);
	select Last_Insert_ID() into districtID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertEmployee` (OUT `employeeID` BIGINT, IN `firstName` VARCHAR(100), IN `middleName` VARCHAR(100), IN `lastName` VARCHAR(100), IN `empQualification` VARCHAR(255), IN `phoneNumber` VARCHAR(50), IN `empEmail` VARCHAR(128), IN `picturePath` VARCHAR(255), IN `agreementType` VARCHAR(50), IN `joinedDate` VARCHAR(20), IN `biodataPath` VARCHAR(255), IN `basicSalary` DECIMAL(20,2), IN `empAdditionals` DECIMAL(20,2), IN `empAddress` VARCHAR(255), IN `birthDate` VARCHAR(20), IN `department` VARCHAR(50), IN `employeeType` VARCHAR(50), IN `biodataDate` VARCHAR(20), IN `empStatus` VARCHAR(50), IN `empDesignation` VARCHAR(50), IN `empCode` VARCHAR(20), IN `userID` VARCHAR(36))  BEGIN
	insert into employee
	(
		first_name,
		middle_name,
		last_name,
		qualification,
		phone_no,
		email,
		picture_path,
		agreement_type,
		joined_date,
		biodata_path,
		basic_salary,
		additionals,
		address,
		birth_date,
		dept,
		employee_type,
		biodata_date,
		status,
		designation,
		code,
		user_id
	)
	values
	(
		firstName,
		middleName,
		lastName,
		empQualification,
		phoneNumber,
		empEmail,
		picturePath,
		agreementType,
		joinedDate,
		biodataPath,
		basicSalary,
		empAdditionals,
		empAddress,
		birthDate,
		department,
		employeeType,
		biodataDate,
		empStatus,
		empDesignation,
		empCode,
		userID
	);
	select Last_Insert_ID() into employeeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertGrade` (OUT `gradeID` INT, IN `gradeName` VARCHAR(20))  BEGIN
	declare gradeOrder int;
	select grade_id into gradeID from grade where grade_name = gradeName;
	
	if gradeID is null then
	select max(grade_order) into gradeOrder from grade;
	insert into grade (grade_name, grade_order) values (gradeName, gradeOrder+1);
	select Last_Insert_ID() into gradeID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertHouse` (OUT `houseID` INT, IN `houseName` VARCHAR(50), IN `houseColor` VARCHAR(20))  BEGIN
	select house_id into houseID from house where house_name = houseName;
	
	if houseID is null then
	insert into house (house_name, house_color) values (houseName, houseColor);
	select Last_Insert_ID() into houseID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertOccupation` (OUT `occupationID` INT, IN `occupationName` VARCHAR(64))  BEGIN
	select occupation_id into occupationID from occupation where occupation_name = occupationName;
	
	if occupationID is null then
	insert into occupation (occupation_name) values (occupationName);
	select Last_Insert_ID() into occupationID;
	end if;
	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertSchool` (OUT `schoolID` INT, IN `schoolName` VARCHAR(100) charset utf8, IN `schoolAddress` VARCHAR(255))  BEGIN
	select school_id into schoolID from school where school_name = schoolName;
	
	if schoolID is null then
	insert into school (school_name, school_address) values (schoolName, schoolAddress);
	select Last_Insert_ID() into schoolID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertStudent` (OUT `studentID` INT, IN `registrationNumber` VARCHAR(20), IN `firstName` VARCHAR(100), IN `middleName` VARCHAR(100), IN `lastName` VARCHAR(100), IN `birthDate` VARCHAR(20), IN `birthPlace` VARCHAR(255), IN `studentGender` VARCHAR(8), IN `homePhone` VARCHAR(50), IN `homeAddress` VARCHAR(255), IN `districtID` INT, IN `joinedGradeID` INT, IN `joinedBatch` VARCHAR(4), IN `lastSchoolID` INT, IN `lastGradeID` INT, IN `fatherName` VARCHAR(100), IN `fatherCell` VARCHAR(50), IN `fatherEmployer` VARCHAR(100), IN `fatherOccupationID` INT, IN `fatherBusinessAddress` VARCHAR(255), IN `fatherEmail` VARCHAR(128), IN `fatherEducation` VARCHAR(100), IN `motherName` VARCHAR(100), IN `motherCell` VARCHAR(50), IN `motherEmployer` VARCHAR(100), IN `motherOccupationID` INT, IN `motherBusinessAddress` VARCHAR(255), IN `motherEmail` VARCHAR(128), IN `motherEducation` VARCHAR(100), IN `guardianName` VARCHAR(100), IN `guardianOccupationID` INT, IN `guardianPhone` VARCHAR(50), IN `guardianEmail` VARCHAR(128), IN `bloodGroup` VARCHAR(8), IN `studentEmail` VARCHAR(128), IN `houseID` INT, IN `emergencyContact` VARCHAR(100), IN `ecAddress` VARCHAR(255), IN `ecRelation` VARCHAR(100), IN `ecPhone` VARCHAR(50), IN `picturePath` VARCHAR(255), IN `classID` INT, IN `currentRoll` VARCHAR(10), IN `boardingType` VARCHAR(100), IN `transportType` VARCHAR(100), IN `busID` INT, IN `stopID` INT, IN `pickupPoint` VARCHAR(128), IN `pickupTime` VARCHAR(50), IN `dropTime` VARCHAR(50), IN `birthMark` VARCHAR(255), IN `stWeight` VARCHAR(30), IN `stHeight` VARCHAR(30), IN `specialNeeds` VARCHAR(255), IN `familyNumber` INT)  BEGIN
	insert into student 
	(
		registration_number,
		st_fname, st_mname, st_lname, st_dob, birth_place, gender, 
		home_phone, home_address, district_id,
		joined_grade_id, joined_batch, last_school_id, last_grade_id,
		father_name, father_cell, father_employer, father_occupation_id, father_business_add, father_email, father_education,
		mother_name, mother_cell, mother_employer, mother_occupation_id, mother_business_add, mother_email, mother_education,
		guardian_name, guardian_occupation_id, guardian_phone, guardian_email, 
		blood_group, email, house_id,
		emergency_contact, ec_address, ec_relation, ec_phone,
		picture_path, class_id, current_roll,
		boarding_type,transport_type,
		bus_id, stop_id,
		pickup_point, pickup_time, drop_time,
		birth_mark, weight, height, special_needs, family_number
	)
	values
	(
		registrationNumber,
		firstName, middleName, lastName, birthDate, birthPlace, studentGender,
		homePhone, homeAddress, districtID,
		joinedGradeID, joinedBatch, lastSchoolID, lastGradeID,
		fatherName, fatherCell, fatherEmployer, fatherOccupationID, fatherBusinessAddress, fatherEmail, fatherEducation,
		motherName, motherCell, motherEmployer, motherOccupationID, motherBusinessAddress, motherEmail, motherEducation,
		guardianName, guardianOccupationID, guardianPhone, guardianEmail,
		bloodGroup, studentEmail, houseID,
		emergencyContact, ecAddress, ecRelation, ecPhone,
		picturePath, classID, currentRoll,
		boardingType, transportType,
		busID, stopID,
		pickupPoint, pickupTime, dropTime,
		birthMark, stWeight, stHeight, specialNeeds, familyNumber
	);
	select Last_Insert_ID() into studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertSubject` (OUT `subjectID` INT, IN `subjectName` VARCHAR(100), IN `gradeID` INT, IN `allocatedSessions` INT, IN `fullMarks` INT, IN `passMarks` INT, IN `subjectType` VARCHAR(20))  BEGIN
	declare currentBatch int;
	select max(batch_id) into currentBatch from batch;
	select subject_id into subjectID from subject where subject_name = subjectName and grade_id = gradeID and is_deleted = 0;
	
	if subjectID is null then
	insert into subject (subject_name, grade_id, allocated_sessions, full_marks, pass_marks, added_batch, subject_type) 
	values (subjectName, gradeID, allocatedSessions, fullMarks, passMarks, currentBatch, subjectType);
	select Last_Insert_ID() into subjectID;
	else
	update subject set is_deleted = 0, subject_type = subjectType 
	where subject_name = subjectName and grade_id = gradeID and is_deleted = 1;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertSubTopic1` (OUT `subTopic1ID` BIGINT, IN `subTopic1Title` VARCHAR(255), IN `depthCode` VARCHAR(100), IN `topicHours` FLOAT, IN `periodEnd` FLOAT, IN `topicCovered` VARCHAR(4), IN `courseTopicID` BIGINT, IN `serialNumber` VARCHAR(10), IN `txtRemarks` VARCHAR(100), IN `activityID` BIGINT)  BEGIN
	select cp_sub_topic1_id into subTopic1ID from cp_sub_topic1 where
	sub_topic1_title = subTopic1Title and cp_course_topic_id = courseTopicID;
	
	if subTopic1ID is null then	
		insert into cp_sub_topic1 (sub_topic1_title, depth_code, topic_hours, period_end, topic_covered, 
		cp_course_topic_id, sn_no, remarks, activity_id)
		values (subTopic1Title, depthCode, topicHours, periodEnd, topicCovered,
		courseTopicID, serialNumber, txtRemarks, activityID);
		
		select Last_Insert_ID() into subTopic1ID;
	else
		update cp_sub_topic1 set
			depth_code = depthCode,
			topic_hours = topicHours,
			period_end = periodEnd,
			topic_covered = topicCovered,
			cp_course_topic_id = courseTopicID,
			sn_no = serialNumber,
			remarks = txtRemarks,
			activity_id = activityID
		where cp_sub_topic1_id = subTopic1ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertSubTopic2` (OUT `subTopic2ID` BIGINT, IN `subTopic2Title` VARCHAR(100), IN `depthCode` VARCHAR(100), IN `subTopic1ID` BIGINT, IN `txtRemarks` VARCHAR(100), IN `serialNumber` VARCHAR(10))  BEGIN
	select cp_sub_topic2_id into subTopic2ID from cp_sub_topic2 where
	sub_topic2_title = subTopic2Title and cp_sub_topic1_id = subTopic1ID;
	
	if subTopic2ID is null then	
		insert into cp_sub_topic2 (sub_topic2_title, depth_code, cp_sub_topic1_id, remarks, sn_no)
		values (subTopic2Title, depthCode, subTopic1ID, txtRemarks, serialNumber);
		
		select Last_Insert_ID() into subTopic2ID;
	else
		update cp_sub_topic2 set
			depth_code = depthCode,
			remarks = txtRemarks,
			sn_no = serialNumber			
		where cp_sub_topic2_id = subTopic2ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertTerminal` (OUT `terminalID` INT, IN `terminalName` VARCHAR(50), IN `gradeID` INT, IN `termWeight` INT, IN `ctWeight` INT)  BEGIN
	select terminal_id into terminalID from terminal where terminal_name = terminalName;	
	if terminalID is null then
	insert into terminal (terminal_name) values (terminalName);
	select last_insert_id() into terminalID;
	if gradeID is not null then
		insert into terminal_weight (terminal_id, grade_id, weightage, ct_weight)
		values (terminalID, gradeID, termWeight, ctWeight);
	end if;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateAttendance` (IN `studentID` BIGINT, IN `classID` INT, IN `presentDays` INT, IN `absentDays` INT, IN `leaveDays` INT, IN `studentRoll` VARCHAR(10), IN `totalDays` INT, IN `terminalID` INT)  BEGIN
	declare ID bigint;
	select attendance_id into ID from student_attendance where student_id = studentID and class_id = classID 
	and terminal_id = terminalID;
	
	if ID is null then
		insert into student_attendance (student_id, class_id, present_days, absent_days, leave_days, student_roll, 
		total_days, terminal_id)
		values (studentID, classID, presentDays, absentDays, leaveDays, studentRoll, totalDays, terminalID);
	else
		update student_attendance set
		present_days = presentDays,
		absent_days = absentDays,
		leave_days = leaveDays,
		student_roll = studentRoll,
		total_days = totalDays
		where attendance_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateClassResult` (IN `studentID` BIGINT, IN `totalFullMarks` DOUBLE, IN `outcome` VARCHAR(50))  BEGIN	
	declare ID bigint;
	declare classID int;
	declare marks double;
	select class_id into classID from student where student_id = studentID;
	if classID is not null then
	select sum(wt_total_marks) into marks from st_marks where student_id = studentID and class_id = classID;
	select class_result_id into ID from class_result where student_id = studentID and class_id = classID;
	if ID is null then
		insert into class_result (class_id, student_id, aggregate_marks, full_marks, status)
		values (classID, studentID, marks, totalFullMarks, outcome);
	else
		update class_result set aggregate_marks = marks, 
		full_marks = totalFullMarks,
		status = outcome
		where class_result_id = ID;
	end if;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateGrading` (IN `studentID` BIGINT, IN `subjectID` INT, IN `terminalID` INT, IN `obtainedGrade` CHAR(5))  BEGIN
	declare ID bigint;
	select stmarks_id into ID from st_marks where student_id = studentID and subject_id = subjectID
	and terminal_id = terminalID;
	
	if ID is null then
		insert into st_marks (student_id, subject_id, terminal_id, obtained_grade) 
		values (studentID, subjectID, terminalID, obtainedGrade);
	else
		update st_marks set
		obtained_grade = obtainedGrade,
		obtained_marks = null
		where stmarks_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateInvoiceItem` (OUT `itemID` INT, IN `itemName` VARCHAR(100), IN `itemType` VARCHAR(100), IN `itemDescription` VARCHAR(255))  BEGIN
	declare itemOrder int;
	
	select item_id into itemID from bill_item where item_name = itemName and deleted = 0;
	if itemID is null then
		select max(item_order) into itemOrder from bill_item;
		insert into bill_item(item_name, item_type, item_description, item_order, added_date)
		values (itemName, itemType, itemDescription, itemOrder+1, curdate());
		
		select Last_Insert_ID() into itemID;
	else
		update bill_item set
		item_type = itemType, item_description = itemDescription
		where item_id = itemID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateMarks` (IN `studentID` BIGINT, IN `subjectID` INT, IN `terminalID` INT, IN `obtainedMarks` DOUBLE, IN `ctMarks` DOUBLE)  BEGIN
	declare ID bigint;
	declare ctWeight int;
	declare termWeight int;
	declare wtObtainedMarks double;
	declare wtTerminalMarks double;
	declare totalMarks double;
	declare gradeID int;
	declare classID int;
	
	declare obtainedGrade varchar(20);
	declare totalGrade varchar(20);
	declare outcome varchar(50); /*** Pass or Fail for the subject on terminal exam ***/ 
	declare outcomeTotal varchar(50); /*** Pass or Fail for the subject on terminal exam marks combined with class test marks ***/
	declare outcomeTerminal varchar(50); /*** Overall Pass or Fail on terminal exam ***/
	
	declare totalFullMarks double;
	declare batchID int;
	
	select grade_id into gradeID from subject where subject_id = subjectID;
	select class_id into classID from student where student_id = studentID;
	select batch_id into batchID from class where class_id = classID;
	
	call spGetCTWeight(ctWeight, terminalID, gradeID);
	set wtObtainedMarks = ((100 - ctWeight)/100)*obtainedMarks;
	set totalMarks = wtObtainedMarks + ctMarks;
	call spGetTerminalWeight(termWeight, terminalID, gradeID);
	set wtTerminalMarks = (termWeight * totalMarks)/100;
	select stmarks_id into ID from st_marks where student_id = studentID and subject_id = subjectID
	and terminal_id = terminalID;
	
	/*** For grading calc ***/	
	call internalGetGradeMapping(obtainedGrade, obtainedMarks);
	call internalGetGradeMapping(totalGrade, totalMarks);
	/*** End grading calc ***/
	
	/*** Find pass or fail ***/
	call spFindResult(outcome, outcomeTotal, obtainedMarks, totalMarks, subjectID);
	call spFindTerminalResult(outcomeTerminal, studentID, gradeID, terminalID);
	/*** End find pass or fail ***/
	/*** Get total full marks for this class(grade) ***/
	call spGetTotalFullMarks(totalFullMarks, studentID, gradeID, batchID);
	/*** End of get total fm ***/
	if ID is null then
		insert into st_marks (student_id, subject_id, terminal_id, obtained_marks, ct_marks, wt_obtained_marks, 
		total_marks, wt_total_marks, obtained_grade, total_grade, class_id, result, result_total) 
		values (studentID, subjectID, terminalID, obtainedMarks, ctMarks, wtObtainedMarks, 
		totalMarks, wtTerminalMarks, obtainedGrade, totalGrade, classID, outcome, outcomeTotal);
	else
		update st_marks set
		obtained_marks = obtainedMarks,
		obtained_grade = null,
		ct_marks = ctMarks,
		wt_obtained_marks = wtObtainedMarks,
		total_marks = totalMarks,
		wt_total_marks = wtTerminalMarks,
		obtained_grade = obtainedGrade,
		total_grade = totalGrade,
		class_id = classID,
		result = outcome,
		result_total = outcomeTotal
		where stmarks_id = ID;
	end if;
	
	/*** Update class_result ***/
	call spInsertUpdateClassResult(studentID, totalFullMarks, outcomeTerminal);/***outcomeTerminal: assuming last 
	terminal marks are entered last - need to make that a requirement in code***/
	/*** End update class_result ***/
	
	/*** Update terminal_result ***/
	call spInsertUpdateTerminalResult(studentID, terminalID, totalFullMarks, outcomeTerminal);
	/*** End update terminal_result ***/
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateMarks2` (IN `studentID` BIGINT, IN `subjectID` INT, IN `terminalID` INT, IN `obtainedMarks` DOUBLE, IN `ctMarks` DOUBLE)  BEGIN
	declare ID bigint;
	declare ctWeight int;
	declare termWeight int;
	declare wtObtainedMarks double;
	declare wtTerminalMarks double;
	declare totalMarks double;
	declare gradeID int;
	declare classID int;
	
	declare obtainedGrade varchar(20);
	declare totalGrade varchar(20);
	declare outcome varchar(50); /*** Pass or Fail for the subject on terminal exam ***/ 
	declare outcomeTotal varchar(50); /*** Pass or Fail for the subject on terminal exam marks combined with class test marks ***/
	declare outcomeTerminal varchar(50); /*** Overall Pass or Fail on terminal exam ***/
	
	declare totalFullMarks double;
	declare batchID int;
	
	select grade_id into gradeID from subject where subject_id = subjectID;
	select class_id into classID from student where student_id = studentID;
	select batch_id into batchID from class where class_id = classID;
	
	call spGetCTWeight(ctWeight, terminalID, gradeID);
	set wtObtainedMarks = ((100 - ctWeight)/100)*obtainedMarks;
	set totalMarks = wtObtainedMarks + ctMarks;
	call spGetTerminalWeight(termWeight, terminalID, gradeID);
	set wtTerminalMarks = (termWeight * totalMarks)/100;
	select stmarks_id into ID from st_marks where student_id = studentID and subject_id = subjectID
	and terminal_id = terminalID;
	
	/*** For grading calc ***/	
	call internalGetGradeMapping(obtainedGrade, obtainedMarks);
	call internalGetGradeMapping(totalGrade, totalMarks);
	/*** End grading calc ***/
	
	/*** Find pass or fail ***/
	call spFindResult(outcome, outcomeTotal, obtainedMarks, totalMarks, subjectID);
	call spFindTerminalResult(outcomeTerminal, studentID, gradeID, terminalID);
	/*** End find pass or fail ***/
	/*** Get total full marks for this class(grade) ***/
	call spGetTotalFullMarks(totalFullMarks, studentID, gradeID, batchID);
	/*** End of get total fm ***/
	if ID is null then
		insert into st_marks (student_id, subject_id, terminal_id, obtained_marks, ct_marks, wt_obtained_marks, 
		total_marks, wt_total_marks, obtained_grade, total_grade, class_id, result, result_total) 
		values (studentID, subjectID, terminalID, obtainedMarks, ctMarks, wtObtainedMarks, 
		totalMarks, wtTerminalMarks, obtainedGrade, totalGrade, classID, outcome, outcomeTotal);
	else
		update st_marks set
		obtained_marks = obtainedMarks,
		obtained_grade = null,
		ct_marks = ctMarks,
		wt_obtained_marks = wtObtainedMarks,
		total_marks = totalMarks,
		wt_total_marks = wtTerminalMarks,
		obtained_grade = obtainedGrade,
		total_grade = totalGrade,
		class_id = classID,
		result = outcome,
		result_total = outcomeTotal
		where stmarks_id = ID;
	end if;
	
	/*** Update class_result ***/
	call spInsertUpdateClassResult(studentID, totalFullMarks, outcomeTerminal);/***outcomeTerminal: assuming last 
	terminal marks are entered last - need to make that a requirement in code***/
	/*** End update class_result ***/
	
	/*** Update terminal_result ***/
	call spInsertUpdateTerminalResult(studentID, terminalID, totalFullMarks, outcomeTerminal);
	/*** End update terminal_result ***/
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateParentEvaluation` (IN `studentID` INT, IN `evaluationTypeID` INT, IN `evaluationID` INT, IN `textRemark` TEXT, IN `evaluationDate` DATE, IN `userID` VARCHAR(36))  BEGIN
	declare previousID int;
	select parent_evaluation_id into previousID from parent_evaluation where student_id = studentID
	and evaluation_type_id = evaluationTypeID and Year(evaluation_date) = Year(evaluationDate)
	and Month(evaluation_date) = Month(evaluationDate);
	
	if previousID is null then
		insert into parent_evaluation (student_id, evaluation_type_id, evaluation_id, evaluation_date, remarks, user_id) 
		values (studentID, evaluationTypeID, evaluationID, evaluationDate, textRemark, userID);
	else
		update parent_evaluation set student_id = studentID, evaluation_type_id = evaluationTypeID,
		evaluation_id = evaluationID, evaluation_date = evaluationDate, remarks = textRemark, user_id = userID
		where parent_evaluation_id = previousID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateStudentEvaluation` (IN `studentID` INT, IN `evaluationTypeID` INT, IN `evaluationID` INT, IN `textRemark` TEXT, IN `evaluationDate` DATE, IN `userID` VARCHAR(36))  BEGIN
	declare classID int;
	declare previousID int;
	select st_evaluation_id into previousID from student_evaluation where student_id = studentID
	and evaluation_type_id = evaluationTypeID and Year(evaluation_date) = Year(evaluationDate)
	and Month(evaluation_date) = Month(evaluationDate);
	
	select class_id into classID from student where student_id = studentID;
	
	if previousID is null then
		insert into student_evaluation (student_id, evaluation_type_id, evaluation_id, evaluation_date, 
			class_id,
			remarks, user_id) 
		values (studentID, evaluationTypeID, evaluationID, evaluationDate, classID, textRemark, userID);
	else
		update student_evaluation set student_id = studentID, evaluation_type_id = evaluationTypeID,
		evaluation_id = evaluationID, evaluation_date = evaluationDate, 
		class_id = classID, remarks = textRemark, user_id = userID
		where st_evaluation_id = previousID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateStudentStatus` (IN `studentID` BIGINT, IN `classID` INT, IN `terminalID` INT, IN `newStatus` VARCHAR(50))  BEGIN
	declare ID bigint;
	select student_status_id into ID from student_status where student_id = studentID and class_id = classID
	and terminal_id = terminalID;
	if ID is null then
		insert into student_status(student_id, class_id, terminal_id, confirmed_status)
		values (studentID, classID, terminalID, newStatus);
	else
		update student_status set confirmed_status = newStatus where student_status_id = ID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateSubjectEvaluation` (IN `studentID` INT, IN `evaluationTypeID` INT, IN `evaluationID` INT, IN `textRemark` TEXT, IN `evaluationDate` DATE, IN `subjectID` INT, IN `userID` VARCHAR(36))  BEGIN
	declare previousID int;
	select st_evaluation_id into previousID from subject_evaluation where student_id = studentID
	and evaluation_type_id = evaluationTypeID and Year(evaluation_date) = Year(evaluationDate)
	and Month(evaluation_date) = Month(evaluationDate) and subject_id = subjectID;
	
	if previousID is null then
		insert into subject_evaluation (student_id, evaluation_type_id, evaluation_id, evaluation_date, remarks, subject_id,
		user_id) 
		values (studentID, evaluationTypeID, evaluationID, evaluationDate, textRemark, subjectID, userID);
	else
		update subject_evaluation set student_id = studentID, evaluation_type_id = evaluationTypeID,
		evaluation_id = evaluationID, evaluation_date = evaluationDate, remarks = textRemark, 
		subject_id = subjectID, user_id = userID
		where st_evaluation_id = previousID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateSubjectMarks` (IN `studentID` BIGINT, IN `subjectID` INT, IN `terminalID` INT, IN `obtainedMarks` DOUBLE, IN `wtObtainedMarks` DOUBLE, IN `ctMarks` DOUBLE, IN `totalMarks` DOUBLE)  BEGIN
	declare ID bigint;
	declare gradeID int;
	declare classID int;
	declare passMarks int;
	Declare subjectStatus varchar(20);
	
	declare termWeight int;
	declare wtTerminalMarks double;
	select grade_id into gradeID from subject where subject_id = subjectID;
	select class_id into classID from student where student_id = studentID;
	/*Calculate the contribution of the terminal total marks for the final aggregate marks*/
	call spGetTerminalWeight(termWeight, terminalID, gradeID);
	set wtTerminalMarks = (termWeight * totalMarks)/100;
	select stmarks_id into ID from st_marks where student_id = studentID and subject_id = subjectID
	and terminal_id = terminalID;
	/*** Check if Fail in this subject ***/
	select pass_marks into passMarks from subject where subject_id = subjectID;
	if totalMarks < passMarks then
		set subjectStatus = 'FAIL';
	else
		set subjectStatus = 'PASS';
	END if;
	if ID is null then
		insert into st_marks (student_id, subject_id, terminal_id, obtained_marks, ct_marks, wt_obtained_marks, 
		total_marks, wt_total_marks, class_id, result) 
		values (studentID, subjectID, terminalID, obtainedMarks, ctMarks, wtObtainedMarks, 
		totalMarks, wtTerminalMarks, classID, subjectStatus);
	else
		update st_marks set
		obtained_marks = obtainedMarks,
		ct_marks = ctMarks,
		wt_obtained_marks = wtObtainedMarks,
		total_marks = totalMarks,
		wt_total_marks = wtTerminalMarks,
		class_id = classID,
		result = subjectStatus
		where stmarks_id = ID;
	end if;
	
	/*Set student status like pass/fail*/
	
	/*** Find all subjects for the student for current grade ***/
	select count(*) into @subjectCount from subject where grade_id =gradeID and is_deleted = 0 and 
	(subject_type = 'COMPULSORY' or subject_id in (select subject_id from student_optional where student_id = studentID));
			
	/*** Find total marks entries for the student for this grade ***/
	select count(*) into @totalEntries from st_marks where student_id = studentID and terminal_id = terminalID
	and (subject_id in (select subject_id from subject where grade_id = gradeID and subject_type = 'COMPULSORY')
	or subject_id in (select subject_id from student_optional where student_id = studentID))
	and subject_id in (select subject_id from subject where is_deleted = 0);
	if @totalEntries < @subjectCount then /*** Not all required marks entries are completed ***/
		call spInsertUpdateStudentStatus(studentID, classID, terminalID, 'PENDING');
	
	else
		if subjectStatus = 'FAIL' then
			call spInsertUpdateStudentStatus(studentID, classID, terminalID, 'FAIL');
		else /*Can still be pass or fail*/
			select count(*) into @failCount from st_marks where student_id = studentID and terminal_id = terminalID
			and class_id = classID and result = 'FAIL';
			if @failCount > 0 then
				call spInsertUpdateStudentStatus(studentID, classID, terminalID, 'FAIL');
			else
				call spInsertUpdateStudentStatus(studentID, classID, terminalID, 'PASS');
			END if;
		end if;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateSubjectTeacher` (OUT `subjectTeacherID` INT, IN `subjectID` INT, IN `classID` INT, IN `classTime` TIME, IN `employeeID` BIGINT, IN `classStart` VARCHAR(20), IN `classEnd` VARCHAR(20), IN `allocatedSessions` INT)  BEGIN
	select subject_teacher_id into subjectTeacherID from subject_teacher 
	where subject_id = subjectID and class_id = classID;
	
	if subjectTeacherID is null then
		insert into subject_teacher (subject_id, class_id, class_time, employee_id, class_start, class_end,allocated_sessions) 
		values (subjectID, classID, classTime, employeeID, classStart, classEnd,allocatedSessions);
		select Last_Insert_ID() into subjectTeacherID;
	else
		update subject_teacher set employee_id = employeeID, class_time = classTime,
		class_start = classStart, class_end = classEnd,allocated_sessions=allocatedSessions
		where subject_teacher_id = subjectTeacherID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spInsertUpdateTerminalResult` (IN `studentID` BIGINT, IN `terminalID` INT, IN `totalFullMarks` DOUBLE, IN `outcome` VARCHAR(50))  BEGIN	
	declare ID bigint;
	declare classID int;
	declare marks double;
	select class_id into classID from student where student_id = studentID;
	if classID is not null then
	select sum(total_marks) into marks from st_marks where student_id = studentID and class_id = classID
	and terminal_id = terminalID;
	select terminal_result_id into ID from terminal_result where student_id = studentID and class_id = classID
	and terminal_id = terminalID;
	if ID is null then
		insert into terminal_result (class_id, student_id, terminal_id, terminal_marks, full_marks, status)
		values (classID, studentID, terminalID, marks, totalFullMarks, outcome);
	else
		update terminal_result set terminal_marks = marks,
		full_marks = totalFullMarks,
		status = outcome
		where terminal_result_id = ID;
	end if;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spRemoveStudentFromClub` (IN `ID` BIGINT)  BEGIN
	delete from student_club where st_club_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spRemoveStudentOptional` (IN `studentID` BIGINT, IN `subjectID` INT)  BEGIN
	delete from student_optional where student_id = studentID and subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportClassAggregate` (IN `classID` INT)  BEGIN
	select st_marks.student_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	sum(wt_total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
	confirmed_status as status
	from st_marks 
	left join student on st_marks.student_id = student.student_id
	left join student_status on st_marks.student_id = student_status.student_id
	and st_marks.class_id = student_status.class_id
	and student_status.terminal_id = 0
	where st_marks.class_id = classID
	and student.deleted = 0
	group by st_marks.student_id
	order by total desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportClassTerminal` (IN `classID` INT, IN `terminalID` INT)  BEGIN
	select st_marks.student_id, st_marks.terminal_id, concat_ws(' ', st_fname, st_mname, st_lname) as student_name,
	sum(total_marks) as total, (select spGetFMForClassStudent(st_marks.student_id, st_marks.class_id)) as full_marks,
	confirmed_status as status
	from st_marks 
	left join student on st_marks.student_id = student.student_id
	left join student_status on st_marks.student_id = student_status.student_id 
	and st_marks.terminal_id = student_status.terminal_id
	and st_marks.class_id = student_status.class_id
	where st_marks.terminal_id = terminalID
	and st_marks.class_id = classID
	and student.deleted = 0
	group by st_marks.student_id
	order by total desc;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportDistrictWiseDistribution` ()  BEGIN
	select class.class_id, concat_ws(' ', grade_name, section) as class_name, 
	grade_name, section, district_name, district_id, count(*) as number from student
	left join district using (district_id)
	left join class on student.class_id = class.class_id
	left join grade on class.grade_id = grade.grade_id
	where class.batch_id = (select max(batch_id) from batch) and class.is_deleted = 0
	group by class_id, district_name
	order by grade_order, section, district_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportFinal` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT)  BEGIN	
	select subject_name, full_marks, pass_marks, subject_type,
	wt_total_marks, terminal_id, subject.subject_id
	from subject left join st_marks on subject.subject_id = st_marks.subject_id
	and st_marks.student_id = studentID 
	where subject.grade_id = gradeID and subject.added_batch <= batchID 
	and (subject.removed_batch is null or subject.removed_batch > batchID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportFinalGrading` (IN `studentID` BIGINT, IN `gradeID` INT, IN `batchID` INT)  BEGIN	
	select subject_name, full_marks, pass_marks, subject_type,
	total_grade, terminal_id, subject.subject_id
	from subject left join st_marks on subject.subject_id = st_marks.subject_id
	and st_marks.student_id = studentID 
	where subject.grade_id = gradeID and subject.added_batch <= batchID 
	and (subject.removed_batch is null or subject.removed_batch > batchID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportOverallSummary` ()  BEGIN
	select batch_name, concat_ws(' ', grade.grade_name, section) as class_name, terminal_name,
	student_status.class_id, student_status.terminal_id, student_status.confirmed_status, 
	count(*) as number from student_status 
	left join class on student_status.class_id = class.class_id
	left join batch on class.batch_id = batch.batch_id
	left join grade on class.grade_id = grade.grade_id
	left join terminal on student_status.terminal_id = terminal.terminal_id
	where class.is_deleted = 0
	group by student_status.class_id, student_status.terminal_id, student_status.confirmed_status
	order by batch.batch_id, grade_order, section, terminal.terminal_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportStudentFinalGrade` (IN `studentID` BIGINT)  BEGIN
	declare classID int;
	declare gradeID int;
	select student.class_id into classID from student where student_id = studentID;
	select class.grade_id into gradeID from class where class_id = classID;
	
	select subject_name, full_marks, pass_marks, total_grade, terminal_id, subject_id
	from subject left join (st_marks) using (subject_id) 
	where subject.grade_id = gradeID and (st_marks.student_id = studentID or st_marks.student_id is null);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportStudentFinalMarks` (IN `studentID` BIGINT)  BEGIN
	declare classID int;
	declare gradeID int;
	select student.class_id into classID from student where student_id = studentID;
	select class.grade_id into gradeID from class where class_id = classID;
	
	select subject_name, full_marks, pass_marks, wt_total_marks, terminal_id, subject_id
	from subject left join (st_marks) using (subject_id) 
	where subject.grade_id = gradeID and (st_marks.student_id = studentID or st_marks.student_id is null);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportStudentSummary` ()  BEGIN
	select Year(joined_date) as batch, joined_grade_id, grade_name, count(*) as enrolled from student
	left join grade on student.joined_grade_id = grade.grade_id
	where student.deleted = 0
	group by Year(joined_date), joined_grade_id 
	order by Year(joined_date), joined_grade_id;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportStudentTerminalMarks` (IN `studentID` BIGINT, IN `terminalID` INT)  BEGIN
	declare classID int;
	declare gradeID int;
	select student.class_id into classID from student where student_id = studentID;
	select class.grade_id into gradeID from class where class_id = classID;
	
	select subject_name, full_marks, pass_marks, obtained_marks, wt_obtained_marks, ct_marks, total_marks, total_grade  
	from subject left join (st_marks) using (subject_id) 
	where subject.grade_id = gradeID and (st_marks.student_id = studentID or st_marks.student_id is null)
	and (st_marks.terminal_id = terminalID  or st_marks.terminal_id is null);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spReportTerminal` (IN `studentID` BIGINT, IN `terminalID` INT, IN `gradeID` INT, IN `batchID` INT)  BEGIN
	select subject.subject_id, subject_name, full_marks, pass_marks, subject_type,
	obtained_marks, wt_obtained_marks, ct_marks, total_marks, wt_total_marks, total_grade,
	(select GetGradeFromMarks(subject.subject_id, batchID, total_marks)) as mappedGrade,
	(select GetHighestMarksInClass(subject.subject_id, gradeID, batchID, terminalID)) as maxMarks
	from subject left join st_marks on subject.subject_id = st_marks.subject_id
	and st_marks.student_id = studentID and st_marks.terminal_id = terminalID
	where subject.grade_id = gradeID and subject.added_batch <= batchID 
	and (subject.removed_batch is null or subject.removed_batch > batchID);
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spSetCurrentTerminal` (IN `terminalID` INT)  BEGIN
	update terminal set is_current = 0 where terminal_id <> terminalID;
	update terminal set is_current = 1 where terminal_id = terminalID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spSetSubjectDeleted` (IN `subjectID` INT)  BEGIN
	declare currentBatch int;
	declare addedBatch int;
	select max(batch_id) into currentBatch from batch; /*** Find the year whence the subject was removed from the syllabus ***/
	
	select added_batch into addedBatch from subject where subject_id = subjectID;
	if(addedBatch != currentBatch) then
	update subject set is_deleted = 1, removed_batch = currentBatch where subject_id = subjectID;
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spStudentAdmittedByYearGrade` ()  BEGIN
	/*select count(*) as number, Year(joined_date) as joined_year, grade_name 
	from student
	left join grade on student.joined_grade_id = grade.grade_id
	where student.deleted = 0
	group by Year(joined_date), grade_name 
	order by Year(joined_date), grade_order;*/
	select count(*) as number, joined_batch as joined_year, grade_name 
	from student
	left join grade on student.joined_grade_id = grade.grade_id
	where student.deleted = 0
	group by joined_batch, grade_name 
	order by joined_batch, grade_order;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateClass` (IN `classID` INT, IN `sectionName` VARCHAR(20), IN `classTeacherID` INT)  BEGIN
	update class set section = sectionName, class_teacher_id = classTeacherID
	where class_id = classID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateClub` (IN `clubID` INT, IN `clubName` VARCHAR(255), IN `clubType` VARCHAR(30))  BEGIN
	update clubs set club_name = clubName, club_type = clubType
	where club_id = clubID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateDistrict` (IN `districtID` INT, IN `districtName` VARCHAR(64))  BEGIN
	update district set district_name = districtName where district_id = districtID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateEmployee` (IN `employeeID` BIGINT, IN `firstName` VARCHAR(100), IN `middleName` VARCHAR(100), IN `lastName` VARCHAR(100), IN `empQualification` VARCHAR(255), IN `phoneNumber` VARCHAR(50), IN `empEmail` VARCHAR(128), IN `picturePath` VARCHAR(255), IN `agreementType` VARCHAR(50), IN `joinedDate` VARCHAR(20), IN `biodataPath` VARCHAR(255), IN `basicSalary` DECIMAL(20,2), IN `empAdditionals` DECIMAL(20,2), IN `empAddress` VARCHAR(255), IN `birthDate` VARCHAR(20), IN `department` VARCHAR(50), IN `employeeType` VARCHAR(50), IN `biodataDate` VARCHAR(20), IN `empStatus` VARCHAR(50), IN `empDesignation` VARCHAR(50), IN `empCode` VARCHAR(20))  BEGIN
	update employee
	set first_name = firstName,
		middle_name = middleName,
		last_name = lastName,
		qualification = empQualification,
		phone_no = phoneNumber,
		email = empEmail,
		picture_path = picturePath,
		agreement_type = agreementType,
		joined_date = joinedDate,
		biodata_path = biodataPath,
		basic_salary = basicSalary,
		additionals = empAdditionals,
		address = empAddress,
		birth_date = birthDate,
		dept = department,
		employee_type = employeeType,
		biodata_date = biodataDate,
		status = empStatus,
		designation = empDesignation,
		code = empCode
	where employee_id = employeeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateEmployeeUserID` (IN `employeeID` INT, IN `userID` VARCHAR(36))  BEGIN
	select user_id into @previousID from employee where employee_id = employeeID;
	update employee set user_id = userID where employee_id = employeeID;
	/*if @previousID is not null then
		delete from users where PKID = @previousID;
	end if;*/
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateEvaluationOption` (IN `optionID` INT, IN `optionName` VARCHAR(100))  BEGIN
	update ct_evaluation_option set evaluation_option_name = optionName where evaluation_option_id = optionID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateGrade` (IN `gradeID` INT, IN `gradeName` VARCHAR(20))  BEGIN
	update grade set grade_name = gradeName where grade_id = gradeID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateHouse` (IN `houseID` INT, IN `houseName` VARCHAR(50), IN `houseColor` VARCHAR(20))  BEGIN
	update house
	set house_name = houseName, house_color = houseColor
	where house_id = houseID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateOccupation` (IN `occupationID` INT, IN `occupationName` VARCHAR(64))  BEGIN
	update occupation
	set occupation_name = occupationName
	where occupation_id = occupationID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateParentEvaluationOption` (IN `optionID` INT, IN `optionName` VARCHAR(100))  BEGIN
	update ct_parent_evaluation_option set evaluation_option_name = optionName where evaluation_option_id = optionID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateSchool` (IN `schoolID` INT, IN `schoolName` VARCHAR(100), IN `schoolAddress` VARCHAR(255))  BEGIN
	update school
	set school_name = schoolName,
	school_address = schoolAddress
	where school_id = schoolID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateSibling` (IN `siblingID` BIGINT, IN `siblingName` VARCHAR(100), IN `siblingRelation` VARCHAR(100), IN `siblingDOB` VARCHAR(30), IN `siblingQualification` VARCHAR(255), IN `siblingInstitution` VARCHAR(255))  BEGIN
	update sibling set
		sibling_name = siblingName,
		relation = siblingRelation,
		sibling_dob = siblingDOB,
		sibling_qualification = siblingQualification,
		sibling_institution = siblingInstitution
	where sibling_id = siblingID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateStudent` (IN `studentID` INT, IN `registrationNumber` VARCHAR(20), IN `firstName` VARCHAR(100), IN `middleName` VARCHAR(100), IN `lastName` VARCHAR(100), IN `birthDate` VARCHAR(20), IN `birthPlace` VARCHAR(255), IN `studentGender` VARCHAR(8), IN `homePhone` VARCHAR(50), IN `homeAddress` VARCHAR(255), IN `districtID` INT, IN `joinedGradeID` INT, IN `joinedBatch` VARCHAR(4), IN `lastSchoolID` INT, IN `lastGradeID` INT, IN `fatherName` VARCHAR(100), IN `fatherCell` VARCHAR(50), IN `fatherEmployer` VARCHAR(100), IN `fatherOccupationID` INT, IN `fatherBusinessAddress` VARCHAR(255), IN `fatherEmail` VARCHAR(128), IN `fatherEducation` VARCHAR(100), IN `motherName` VARCHAR(100), IN `motherCell` VARCHAR(50), IN `motherEmployer` VARCHAR(100), IN `motherOccupationID` INT, IN `motherBusinessAddress` VARCHAR(255), IN `motherEmail` VARCHAR(128), IN `motherEducation` VARCHAR(100), IN `guardianName` VARCHAR(100), IN `guardianOccupationID` INT, IN `guardianPhone` VARCHAR(50), IN `guardianEmail` VARCHAR(128), IN `bloodGroup` VARCHAR(8), IN `studentEmail` VARCHAR(128), IN `houseID` INT, IN `emergencyContact` VARCHAR(100), IN `ecAddress` VARCHAR(255), IN `ecRelation` VARCHAR(100), IN `ecPhone` VARCHAR(50), IN `picturePath` VARCHAR(255), IN `classID` INT, IN `currentRoll` VARCHAR(10), IN `boardingType` VARCHAR(100), IN `transportType` VARCHAR(100), IN `busID` INT, IN `stopID` INT, IN `pickupPoint` VARCHAR(128), IN `pickupTime` VARCHAR(50), IN `dropTime` VARCHAR(50), IN `birthMark` VARCHAR(255), IN `stWeight` VARCHAR(30), IN `stHeight` VARCHAR(30), IN `specialNeeds` VARCHAR(255), IN `familyNumber` INT)  BEGIN
	update student set
		registration_number = registrationNumber,
		st_fname = firstName,
		st_mname = middleName,
		st_lname = lastName,
		st_dob = birthDate,
		birth_place = birthPlace,
		gender = studentGender,
		home_phone = homePhone,
		home_address = homeAddress,
		district_id = districtID,
		joined_grade_id = joinedGradeID,
		joined_batch = joinedBatch,
		last_school_id = lastSchoolID,
		last_grade_id = lastGradeID,
		father_name = fatherName,
		father_cell = fatherCell,
		father_employer = fatherEmployer,
		father_occupation_id = fatherOccupationID,
		father_business_add = fatherBusinessAddress,
		father_email = fatherEmail,
		father_education = fatherEducation,
		mother_name = motherName,
		mother_cell = motherCell,
		mother_employer = motherEmployer,
		mother_occupation_id = motherOccupationID,
		mother_business_add = motherBusinessAddress,
		mother_email = motherEmail,
		mother_education = motherEducation,
		guardian_name = guardianName,
		guardian_occupation_id = guardianOccupationID,
		guardian_phone = guardianPhone,
		guardian_email = guardianEmail,
		blood_group = bloodGroup,
		email = studentEmail,
		house_id = houseID,
		emergency_contact = emergencyContact,
		ec_address = ecAddress,
		ec_relation = ecRelation,
		ec_phone = ecPhone,
		picture_path = picturePath,
		class_id = classID,
		current_roll = currentRoll,
		boarding_type = boardingType,
		transport_type = transportType,
		bus_id = busID, stop_id = stopID,
		pickup_point = pickupPoint,
		pickup_time = pickupTime,
		drop_time = dropTime,
		birth_mark = birthMark,
		weight = stWeight,
		height = stHeight,
		special_needs = specialNeeds,
		family_number = familyNumber
	where student_id = studentID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateStudentClubDesignation` (IN `ID` INT, IN `clubRole` VARCHAR(100))  BEGIN
	update student_club set designation = clubRole where st_club_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateStudentDoctor` (IN `ID` INT, IN `doctorName` VARCHAR(100), IN `docHospital` VARCHAR(255), IN `docPhone` VARCHAR(100))  BEGIN
	update doctor set
	doctor_name = doctorName,
	hospital = docHospital,
	phone = docPhone
	where doctor_id = ID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateSubject` (IN `subjectID` INT, IN `subjectName` VARCHAR(100), IN `allocatedSessions` INT, IN `fullMarks` INT, IN `passMarks` INT)  BEGIN
	update subject set subject_name = subjectName,
	allocated_sessions = allocatedSessions,
	full_marks = fullMarks,
	pass_marks = passMarks
	where subject_id = subjectID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateSubjectEvaluationOption` (IN `optionID` INT, IN `optionName` VARCHAR(100))  BEGIN
	update subject_evaluation_option set evaluation_option_name = optionName where evaluation_option_id = optionID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateSubjectGradeMap` (IN `subjectGradingID` INT, IN `minMarks` DOUBLE, IN `gradeName` VARCHAR(30))  BEGIN
	update subject_grading set min_marks = minMarks, grade_name = gradeName
	where subject_grading_id = subjectGradingID;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateTerminal` (IN `terminalID` INT, IN `terminalName` VARCHAR(50))  BEGIN
	update terminal set terminal_name = terminalName where terminal_id = terminalID;	
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `spUpdateTerminalWeight` (IN `terminalID` INT, IN `gradeID` INT, IN `termWeight` INT, IN `ctWeight` INT)  BEGIN
	declare terminalWtID int;
	select terminal_weight_id into terminalWtID from terminal_weight where terminal_id = terminalID
	and grade_id = gradeID;	
	if terminalWtID is not null then
		update terminal_weight set weightage = termWeight, ct_weight = ctWeight where terminal_weight_id = terminalWtID;
	else
		insert into terminal_weight (terminal_id, grade_id, weightage, ct_weight)
		values (terminalID, gradeID, termWeight, ctWeight);
	end if;
    END$$

CREATE DEFINER=`root`@`%` PROCEDURE `test` ()  BEGIN
    END$$

--
-- Functions
--
CREATE DEFINER=`root`@`%` FUNCTION `GetGradeFromMarks` (`subjectID` INT, `batchID` INT, `marks` DOUBLE) RETURNS VARCHAR(30) CHARSET latin1 BEGIN
	declare grade varchar(30);
	
	select grade_name into grade from subject_grading
	where subject_id = subjectID and batch_id = batchID
	and min_marks = (select max(min_marks) from subject_grading where min_marks <= marks);
	return grade;
    END$$

CREATE DEFINER=`root`@`%` FUNCTION `GetHighestMarksInClass` (`subjectID` INT, `gradeID` INT, `batchID` INT, `terminalID` INT) RETURNS DOUBLE BEGIN
	declare maxMarks double;
	select max(total_marks) into maxMarks from st_marks 
	where class_id in (select class_id from class where grade_id = gradeID and batch_id = batchID)
	and subject_id = subjectID and terminal_id = terminalID;
	
	return maxMarks;
    END$$

CREATE DEFINER=`root`@`%` FUNCTION `GetPaidAmount` (`itemID` INT, `studentID` BIGINT, `schemeID` INT) RETURNS DECIMAL(20,2) BEGIN
	declare paidAmount double(20,2);
	select sum(bill_detail.item_amount) into paidAmount from payment_student
	left join bill_detail on payment_student.bill_id = bill_detail.bill_id
	and bill_detail.item_id = itemID
	where payment_student.student_id = studentID and payment_student.payment_scheme_id = schemeID;
	return paidAmount;
    END$$

CREATE DEFINER=`root`@`%` FUNCTION `GetTotalCollected` (`studentID` BIGINT, `batchID` INT) RETURNS DECIMAL(20,2) BEGIN
	declare totalCollected decimal(20,2);
	select sum(amount) into totalCollected from invoice left join invoice_payment using (invoice_id)
	where invoice.client_id = studentID
	and invoice.batch_id = batchID;
	return totalCollected;
    END$$

CREATE DEFINER=`root`@`%` FUNCTION `GetTotalPayable` (`studentID` BIGINT, `batchID` INT) RETURNS DECIMAL(20,2) BEGIN
	declare totalPayable decimal(20,2);
	select sum(payable_amount) into totalPayable from invoice where invoice.client_id = studentID
	and invoice.batch_id = batchID;
	return totalPayable;
    END$$

CREATE DEFINER=`root`@`%` FUNCTION `spGetFMForClassStudent` (`studentID` BIGINT, `classID` INT) RETURNS DOUBLE BEGIN
	
	declare totalFullMarks double;
	declare gradeID int;
	declare batchID int;
	select grade_id , batch_id into gradeID, batchID from class where class_id = classID;
	call spGetTotalFullMarks(totalFullMarks, studentID, gradeID, batchID);
	return totalFullMarks;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_standards`
--

CREATE TABLE `activity_standards` (
  `id` int(11) NOT NULL,
  `standard_name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_standards`
--

INSERT INTO `activity_standards` (`id`, `standard_name`, `status`, `added_on`) VALUES
(1, 'Visual', 1, '2017-12-11 07:42:34'),
(3, 'Audio', 1, '2017-12-11 08:02:44'),
(4, 'Kinesthetic (Physical)', 1, '2017-12-11 08:02:54'),
(5, 'Presentation', 1, '2018-02-23 06:40:38'),
(6, 'xyz', 1, '2018-03-28 08:48:49'),
(7, 'Visual, Demonstration', 1, '2018-03-28 08:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `appraisal`
--

CREATE TABLE `appraisal` (
  `appraisal_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `section_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `grade` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_fields`
--

CREATE TABLE `appraisal_fields` (
  `field_id` int(11) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_description` varchar(255) NOT NULL,
  `head_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appraisal_fields`
--

INSERT INTO `appraisal_fields` (`field_id`, `field_name`, `field_description`, `head_id`) VALUES
(20, 'Basketball', '', 3),
(21, 'Cricket', '', 3),
(22, 'Taekwando', '', 3),
(23, 'Table Tennis', '', 3),
(24, 'Theater & Drama', '', 3),
(25, 'Scouts', '', 3),
(26, 'Yoga', '', 3),
(27, 'Futsal', '', 3),
(28, 'Creative Writing & Public Speaking', '', 3),
(29, 'Violin', '', 4),
(30, 'Guiter', '', 4),
(31, 'Craft', '', 4),
(32, 'Art', '', 4),
(34, 'Dance (Modern/Classical)', '', 4),
(35, 'Leather Instrument', '', 4),
(36, 'Social Skills', '', 5),
(37, 'Vocal', '', 4),
(38, 'Keyboard', '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_grade`
--

CREATE TABLE `appraisal_grade` (
  `grade_name` varchar(10) NOT NULL DEFAULT '',
  `grade_description` varchar(100) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appraisal_grade`
--

INSERT INTO `appraisal_grade` (`grade_name`, `grade_description`, `order`) VALUES
('A', 'Excellent', 2),
('A+', 'Outstanding', 1),
('B', 'Very Good', 3),
('C', 'Good', 4),
('D', 'Average', 5);

-- --------------------------------------------------------

--
-- Table structure for table `appraisal_heads`
--

CREATE TABLE `appraisal_heads` (
  `head_id` int(11) NOT NULL,
  `head_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appraisal_heads`
--

INSERT INTO `appraisal_heads` (`head_id`, `head_name`) VALUES
(3, 'ECA'),
(4, 'CRE'),
(5, 'Social Skills');

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `assessment_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `assessment_name` varchar(32) NOT NULL,
  `numeric_value` int(11) NOT NULL,
  `assessment_mark` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `batch_name`) VALUES
(11, '2070'),
(12, '2072'),
(13, '2073'),
(14, '2074'),
(15, '2075');

-- --------------------------------------------------------

--
-- Table structure for table `blocked_ip`
--

CREATE TABLE `blocked_ip` (
  `id` int(11) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `blocked_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bug`
--

CREATE TABLE `bug` (
  `id` int(11) NOT NULL,
  `bug_title` varchar(500) NOT NULL,
  `bug_description` text NOT NULL,
  `bug_img` varchar(255) DEFAULT NULL,
  `report_id` varchar(50) NOT NULL,
  `report_role` varchar(50) NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bug`
--

INSERT INTO `bug` (`id`, `bug_title`, `bug_description`, `bug_img`, `report_id`, `report_role`, `report_date`, `status`, `remarks`) VALUES
(3, 'Password Changing issue', 'my password is not changed, though it shows success message.', '', '294', 'faculty', '2016-08-31 09:12:03', 'Fixed', ''),
(4, 'php error', 'looks like you have php error in home controller.', 'bug/1706247ee241c3d0f8309e50f5c164f6.png', '5057', 'student', '2016-11-20 15:30:32', 'Fixed', ''),
(5, 'Syllabus Download Not Working', 'When I download the syllabus of a particular subject, the file format is unknown and it doesnt open.', '', '4882', 'student', '2016-12-04 15:37:30', 'Fixed', '');

-- --------------------------------------------------------

--
-- Table structure for table `bus_stop`
--

CREATE TABLE `bus_stop` (
  `stop_id` int(11) NOT NULL,
  `bus_id` int(11) NOT NULL,
  `stop_name` varchar(100) NOT NULL,
  `pick_time` time NOT NULL,
  `drop_time` time NOT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_attendance`
--

CREATE TABLE `class_attendance` (
  `id` int(11) NOT NULL,
  `class_days_id` int(11) NOT NULL,
  `terminal_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `total_class` int(11) NOT NULL,
  `present_class` int(11) NOT NULL,
  `absent_class` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_days`
--

CREATE TABLE `class_days` (
  `class_days_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `section_id` int(11) NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `class_time` time NOT NULL,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `end_date` date NOT NULL DEFAULT '0000-00-00',
  `class_days` float NOT NULL DEFAULT '0',
  `updater` varchar(255) NOT NULL,
  `last_changed_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_routine`
--

CREATE TABLE `class_routine` (
  `routing_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `routine` text,
  `uploaded_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `club_id` int(11) NOT NULL,
  `club_name` varchar(255) NOT NULL,
  `club_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`club_id`, `club_name`, `club_type`) VALUES
(3, 'Basket Ball', 'ECA'),
(5, 'Dance', 'ECA'),
(6, 'Wushu', 'ECA'),
(7, 'Theatre', 'CRE'),
(8, 'Music', 'CRE'),
(9, 'Writers'' & Speakers''', 'CRE'),
(10, 'Documentary', 'CRE'),
(11, 'Drawing & Painting', 'CRE'),
(12, 'Drama', 'CRE'),
(17, 'trt 2', 'eca'),
(18, 'Sports', 'Sports Club'),
(19, 'abd', 'Basketball');

-- --------------------------------------------------------

--
-- Table structure for table `club_type`
--

CREATE TABLE `club_type` (
  `id` int(11) NOT NULL,
  `club_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `club_type`
--

INSERT INTO `club_type` (`id`, `club_type`) VALUES
(6, 'Basketball'),
(7, 'Table Tennis'),
(8, 'Public Speaking'),
(9, 'Cricket'),
(10, 'Futsal'),
(11, 'Drama'),
(12, 'Scouts'),
(13, 'Yoga');

-- --------------------------------------------------------

--
-- Table structure for table `ct_evaluation_option`
--

CREATE TABLE `ct_evaluation_option` (
  `evaluation_option_id` int(11) NOT NULL,
  `evaluation_option_name` varchar(100) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ct_evaluation_option`
--

INSERT INTO `ct_evaluation_option` (`evaluation_option_id`, `evaluation_option_name`, `evaluation_type_id`) VALUES
(1, 'Very Careful', 1),
(2, 'Good', 1),
(3, 'Needs Improvement', 1),
(4, 'Regular', 2),
(5, 'Satisfactory', 2),
(6, 'Irregular', 2),
(7, 'Good', 3),
(8, 'Fair', 3),
(9, 'Needs Improvement', 3),
(10, 'Very Sincere', 4),
(11, 'Sincere', 4),
(12, 'Needs Improvement', 4),
(13, 'Neat', 5),
(14, 'Fair', 5),
(15, 'Needs Improvement', 5),
(16, 'Polite', 6),
(17, 'Needs Improvement', 6),
(18, 'Beautiful', 7),
(19, 'Improving', 7),
(20, 'Needs Hard Work', 7),
(21, 'Very Good', 8),
(22, 'Good', 8),
(23, 'Needs Improvement', 8),
(24, 'Very Active', 9),
(25, 'Active', 9),
(26, 'Needs Improvement', 9),
(27, 'Efficient', 10),
(28, 'Good', 10),
(29, 'Needs Improvement', 10),
(30, 'Very Regular', 11),
(31, 'Regular', 11),
(32, 'Needs Improvement', 11),
(33, 'Very Creative', 12),
(34, 'Creative', 12),
(35, 'Needs Guidance', 12),
(36, 'Very Good', 13),
(37, 'Good', 13),
(38, 'Poor', 13),
(42, 'polite and ', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ct_evaluation_type`
--

CREATE TABLE `ct_evaluation_type` (
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_type_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ct_evaluation_type`
--

INSERT INTO `ct_evaluation_type` (`evaluation_type_id`, `evaluation_type_name`) VALUES
(1, 'Work Habit'),
(3, 'Participation in Class Room Activities'),
(4, 'Sincerity and Attentiveness'),
(5, 'General Appearance and Dress-up'),
(6, 'General Behaviour'),
(7, 'Handwriting'),
(8, 'Spoken English'),
(9, 'Written English'),
(10, 'Maintenance of Materials'),
(11, 'Participation in ECA'),
(12, 'Interpersonal Skills'),
(13, 'Regularity'),
(14, 'Creativity'),
(15, 'Academic Interest');

-- --------------------------------------------------------

--
-- Table structure for table `ct_parent_evaluation_option`
--

CREATE TABLE `ct_parent_evaluation_option` (
  `evaluation_option_id` int(11) NOT NULL,
  `evaluation_option_name` varchar(100) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ct_parent_evaluation_option`
--

INSERT INTO `ct_parent_evaluation_option` (`evaluation_option_id`, `evaluation_option_name`, `evaluation_type_id`) VALUES
(1, 'No Complaint', 1),
(2, 'Satisfactory', 1),
(3, 'Not Satisfactory', 1),
(4, 'No Complaint', 2),
(5, 'Satisfactory', 2),
(6, 'Not Satisfactory', 2),
(7, 'Promptly Responsive', 3),
(8, 'Occasionally Responsive', 3),
(9, 'Indifferent', 3),
(10, 'Frequently', 4),
(11, 'Occasionally', 4),
(12, 'Hardly', 4),
(13, 'Prompt', 5),
(14, 'Satisfactory', 5),
(15, 'Indifferent', 5),
(16, 'Highly Conscious', 6),
(17, 'Conscious', 6),
(18, 'Indifferent', 6);

-- --------------------------------------------------------

--
-- Table structure for table `ct_parent_evaluation_type`
--

CREATE TABLE `ct_parent_evaluation_type` (
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_type_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ct_parent_evaluation_type`
--

INSERT INTO `ct_parent_evaluation_type` (`evaluation_type_id`, `evaluation_type_name`) VALUES
(1, 'Helping children with their homework'),
(2, 'Helping children with their studies'),
(3, 'Response to remarks on diary'),
(4, 'Consultation with the class teachers and other teachers'),
(5, 'Response to children''s extra-textual needs (materials)'),
(6, 'Class teacher''s overall remark on parents'' performance');

-- --------------------------------------------------------

--
-- Table structure for table `ct_parent_remarks`
--

CREATE TABLE `ct_parent_remarks` (
  `ct_parent_remarks_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `remarks` text NOT NULL,
  `evaluation_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` bigint(20) NOT NULL,
  `head_id` bigint(20) DEFAULT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `head_id`, `department_name`) VALUES
(1, NULL, 'Administrative'),
(2, NULL, 'Academic');

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE `district` (
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `district_name` varchar(64) NOT NULL DEFAULT '',
  `zone_name` varchar(255) NOT NULL,
  `region_name` varchar(255) NOT NULL,
  `state` varchar(56) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`district_id`, `district_name`, `zone_name`, `region_name`, `state`) VALUES
(70, 'NAWALPARASI', 'LUMBINI', 'WESTERN', ''),
(63, 'KATHMANDU', 'BAGMATI II', 'CENTRAL II', '3'),
(62, 'LALITPUR', 'BAGMATI', 'CENTRAL ', ''),
(66, 'GORKHA', 'GANDAGI', 'WESTERN', ''),
(65, 'JHAPA', 'MECHI', 'EASTERN', ''),
(64, 'BHAKTAPUR', 'BAGMATI', 'CENTRAL', ''),
(10, 'DHANUSA', 'JANAKPUR', 'CENTRAL ', ''),
(11, 'PALPA', 'LUMBINI', 'WESTERN', ''),
(76, 'KASKI', 'GANDAGI', 'WESTERN', ''),
(13, 'KAILALI', 'SETI', 'FAR-WESTERN', ''),
(14, 'MORANG', 'KOSHI', 'EASTERN', ''),
(15, 'SUNSARI', 'KOSHI', 'EASTERN', ''),
(16, 'KANCHANPUR', 'MAHAKALI', 'FAR-WESTERN', ''),
(17, 'SINDHUPALCHOK', 'BAGMATI', 'CENTRAL ', ''),
(18, 'KAVREPALANCHOWK', 'BAGMATI', 'CENTRAL ', ''),
(19, 'DOTI', 'SETI', 'FAR-WESTERN', ''),
(20, 'DHANKUTA', 'KOSHI', 'EASTERN', ''),
(22, 'ILAM', 'MECHI', 'EASTERN', ''),
(23, 'BHOJPUR', 'KOSHI', 'EASTERN', ''),
(24, 'TAPLEJUNG', 'MECHI', 'EASTERN', ''),
(25, 'SOLUKHUMBU', 'SAGARMATHA', 'EASTERN', ''),
(26, 'SANKHUWASABA', 'KOSHI', 'EASTERN', ''),
(27, 'DHADING', 'BAGMATI', 'CENTRAL ', ''),
(1, 'RUPANDEHI', 'LUMBINI', 'WESTERN', ''),
(35, 'MUGU', 'KARNALI', 'MID WESTERN', ''),
(36, 'DOLPA', 'KARNALI', 'MID WESTERN', ''),
(37, 'MANANG', 'GANDAGI', 'WESTERN', ''),
(38, 'MUSTANG', 'DHAULAGIRI', 'WESTERN', ''),
(39, 'BANKE', 'BHERI', 'MID WESTERN', ''),
(40, 'BARDIYA', 'BHERI', 'MID WESTERN', ''),
(41, 'UDAYAPUR', 'SAGARMATHA', 'EASTERN', ''),
(42, 'OKHELDUNGA', 'SAGARMATHA', 'EASTERN', ''),
(43, 'KHOTANG', 'SAGARMATHA', 'EASTERN', ''),
(44, 'SAPTARI', 'SAGARMATHA', 'EASTERN', ''),
(45, 'CHITWAN', 'NARAYANI', 'CENTRAL ', ''),
(46, 'DARCHULA', 'MAHAKALI', 'FAR-WESTERN', ''),
(50, 'DAILEKH', 'BHERI', 'MID WESTERN', ''),
(51, 'SALYAN', 'RAPTI', 'MID WESTERN', ''),
(52, 'PYUTHAN', 'RAPTI', 'MID WESTERN', ''),
(53, 'ROLPA', 'RAPTI', 'MID WESTERN', ''),
(54, 'RUKUM', 'RAPTI', 'MID WESTERN', ''),
(56, 'BAJURA', 'SETI', 'FAR-WESTERN', ''),
(57, 'DANG', 'RAPTI', 'MID WESTERN', ''),
(58, 'SURKHET', 'BHERI', 'MID WESTERN', ''),
(71, 'PARSA', 'NARAYANI', 'CENTRAL ', ''),
(72, 'KAPILBASTU', 'LUMBINI', 'WESTERN', ''),
(74, 'TANAHUN', 'GANDAGI', 'WESTERN', ''),
(75, 'MAKWANPUR', 'NARAYANI', 'CENTRAL ', ''),
(77, 'BAGLUNG', 'DHAULAGIRI', 'WESTERN', ''),
(78, 'NOT AVAILABLE', '', '', ''),
(79, 'BARA', 'NARAYANI', 'CENTRAL ', ''),
(80, 'JUMLA', 'KARNALI', 'MID WESTERN', ''),
(81, 'SIRAHA', 'SAGARMATHA', 'EASTERN', ''),
(82, 'ARGHAKHACHI', 'LUMBINI', 'WESTERN', ''),
(83, 'DOLAKHA', 'JANAKPUR', 'CENTRAL ', ''),
(95, 'SINDHULI', 'JANAKPUR', 'CENTRAL ', ''),
(86, 'MAHOTTARI', 'JANAKPUR', 'CENTRAL ', ''),
(87, 'SYANGJA', 'GANDAGI', 'WESTERN', ''),
(88, 'NUWAKOT', 'BAGMATI', 'CENTRAL ', ''),
(89, 'PARBAT', 'DHAULAGIRI', 'WESTERN', ''),
(90, 'RAMECHHAP', 'JANAKPUR', 'CENTRAL ', ''),
(91, 'GULMI', 'LUMBINI', 'WESTERN', ''),
(92, 'MYAGDI', 'DHAULAGIRI', 'WESTERN', ''),
(93, 'SARLAHI', 'JANAKPUR', 'CENTRAL ', ''),
(94, 'TERHATHUM', 'KOSHI', 'EASTERN', ''),
(96, 'RAUTAHAT', 'NARAYANI', 'CENTRAL ', ''),
(97, 'PANCHTHAR', 'MECHI', 'EASTERN', ''),
(98, 'BAJHANG', 'SETI', 'FAR-WESTERN', ''),
(101, 'LAMJUNG', 'GANDAGI', 'WESTERN', ''),
(102, 'DADELDHURA', 'MAHAKALI', 'FAR-WESTERN', ''),
(103, 'BAITADI', 'MAHAKALI', 'FAR-WESTERN', ''),
(104, 'JAJARKOT', 'BHERI', 'MID WESTERN', ''),
(105, 'AACHAM', 'SETI', 'FAR-WESTERN', ''),
(106, 'KALIKOT', 'KARNALI', 'MID WESTERN', ''),
(107, 'RASUWA', 'BAGMATI', 'CENTRAL ', ''),
(108, 'HUMLA', 'KARNALI', 'MID WESTERN', ''),
(115, 'DFSS', 'DFSF', 'SDFSF', '1');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `doctor_name` varchar(100) NOT NULL,
  `hospital` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `student_id`, `doctor_name`, `hospital`, `phone`) VALUES
(2, 144, 'Saasd', 'sdfasd asdf asddf', '34234234'),
(3, 152, 'Dr. Ross Geller', 'Bir Hospital', '123456789'),
(4, 152, 'Dr. Abc Xyz', 'Narvik', '789456123'),
(5, 1214, 'teste', 'kmc', '34234'),
(6, 1218, 'Ayush', 'Bir Hospital', '04465288');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` bigint(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `agreement_type` varchar(50) DEFAULT NULL,
  `joined_date` varchar(20) DEFAULT NULL,
  `biodata_path` varchar(255) DEFAULT NULL,
  `basic_salary` decimal(20,2) UNSIGNED DEFAULT NULL,
  `additionals` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birth_date` varchar(20) DEFAULT NULL,
  `dept` varchar(50) DEFAULT NULL,
  `employee_type` varchar(50) DEFAULT NULL,
  `biodata_date` varchar(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `resign_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_leave`
--

CREATE TABLE `employee_leave` (
  `employee_leave_id` bigint(20) NOT NULL,
  `employee_id` bigint(20) NOT NULL DEFAULT '0',
  `leave_type` enum('sick','home','substitute','other') DEFAULT NULL,
  `leave_from` date DEFAULT NULL,
  `leave_to` date DEFAULT NULL,
  `leave_days` float NOT NULL,
  `purpose` text,
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_type`
--

CREATE TABLE `employee_type` (
  `employee_type_id` int(11) NOT NULL,
  `employee_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_type`
--

INSERT INTO `employee_type` (`employee_type_id`, `employee_type_name`) VALUES
(1, 'Faculty'),
(2, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_option`
--

CREATE TABLE `evaluation_option` (
  `evaluation_option_id` int(11) NOT NULL,
  `evaluation_option_name` varchar(100) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_type`
--

CREATE TABLE `evaluation_type` (
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam`
--

CREATE TABLE `exam` (
  `exam_id` bigint(20) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `terminal_name` varchar(32) NOT NULL,
  `numeric_value` int(11) NOT NULL,
  `full_mark` int(11) NOT NULL,
  `pass_mark` int(11) NOT NULL,
  `average_at` int(11) NOT NULL,
  `convert_to` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `conducted_from` date DEFAULT NULL,
  `conducted_till` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exam_grades`
--

CREATE TABLE `exam_grades` (
  `id` int(11) NOT NULL,
  `mark_from` int(11) NOT NULL,
  `mark_to` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `description` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_grades`
--

INSERT INTO `exam_grades` (`id`, `mark_from`, `mark_to`, `grade`, `description`) VALUES
(1, 90, 100, 'A+', 'Outstanding'),
(2, 80, 89, 'A', 'Excellent'),
(3, 70, 79, 'B', 'Very Good'),
(4, 60, 69, 'C', 'Good'),
(5, 50, 59, 'D', 'Average'),
(7, 40, 49, 'E', 'Threshold'),
(8, 0, 39, 'F', 'Below Threshold');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_comment`
--

CREATE TABLE `faculty_comment` (
  `fac_cmt_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `comment` longblob,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `final_result`
--

CREATE TABLE `final_result` (
  `final_result_id` bigint(20) NOT NULL,
  `class_days_id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `scale_up_mark` text NOT NULL,
  `final_mark` varchar(10) DEFAULT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(20) NOT NULL,
  `grade_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`grade_id`, `grade_name`, `grade_order`) VALUES
(4, 'One', 5),
(5, 'Two', 4),
(6, 'Three', 6),
(7, 'Four', 7),
(8, 'Five', 8),
(9, 'Six', 9),
(10, 'Seven', 10),
(11, 'Eight', 11),
(12, 'Nine', 12),
(13, 'Ten', 13),
(14, 'Eleven', 14),
(16, 'Twelve', 15);

-- --------------------------------------------------------

--
-- Table structure for table `house`
--

CREATE TABLE `house` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(50) NOT NULL DEFAULT '',
  `house_color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `house`
--

INSERT INTO `house` (`house_id`, `house_name`, `house_color`) VALUES
(5, 'CREST', 'BLUE'),
(6, 'VERTEX', 'GREEN'),
(7, 'SUMMIT', 'YELLOW'),
(8, 'PINNACLE', 'RED');

-- --------------------------------------------------------

--
-- Table structure for table `illness`
--

CREATE TABLE `illness` (
  `illness_id` int(11) NOT NULL,
  `illness_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lession_plan`
--

CREATE TABLE `lession_plan` (
  `id` int(11) NOT NULL,
  `ch_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `main_topic` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sub_topic` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `objective` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activity` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `target_exam` varchar(10) NOT NULL,
  `section_id` varchar(255) NOT NULL,
  `class_days_id` int(11) NOT NULL,
  `st_stat` int(11) NOT NULL,
  `t_stat` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lesson_activity`
--

CREATE TABLE `lesson_activity` (
  `activity_id` int(11) NOT NULL,
  `class_days_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `teaching_material` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activity_key` varchar(255) NOT NULL,
  `activity_title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activity_objective` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `activity_date` tinytext NOT NULL,
  `assignments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `home_assignments` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `standard` varchar(64) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `activity_file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marksheet_restrict`
--

CREATE TABLE `marksheet_restrict` (
  `id` int(11) NOT NULL,
  `student_id` varchar(32) NOT NULL,
  `batch_id` varchar(10) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `grade` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marksheet_restrict`
--

INSERT INTO `marksheet_restrict` (`id`, `student_id`, `batch_id`, `exam_id`, `grade`, `status`) VALUES
(3, '1279', '2073', 2, 'One', 1),
(8, '1218', '2073', 1, 'One', 1),
(9, '1219', '2073', 1, 'One', 1),
(10, '1220', '2073', 1, 'One', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(1, '[{"id":18,"children":[{"id":227}]},{"id":21,"children":[{"id":17},{"id":67},{"id":16},{"id":138},{"id":180},{"id":187}]},{"id":188,"children":[{"id":189},{"id":190},{"id":193},{"id":194}]},{"id":236,"children":[{"id":204},{"id":203},{"id":205},{"id":206},{"id":207},{"id":198},{"id":219}]},{"id":197},{"id":199,"children":[{"id":202},{"id":220},{"id":228},{"id":221},{"id":230}]},{"id":235,"children":[{"id":209},{"id":212},{"id":210},{"id":211},{"id":231}]},{"id":216,"children":[{"id":213},{"id":215},{"id":214},{"id":217},{"id":218}]},{"id":225,"children":[{"id":222},{"id":224},{"id":226},{"id":223},{"id":208}]},{"id":195,"children":[{"id":200},{"id":201}]},{"id":229},{"id":196},{"id":233,"children":[{"id":234},{"id":238},{"id":254}]},{"id":245,"children":[{"id":246},{"id":247},{"id":248},{"id":249},{"id":250},{"id":251}]},{"id":232,"children":[{"id":256},{"id":252},{"id":257},{"id":253}]},{"id":255},{"id":237},{"id":239,"children":[{"id":243},{"id":240},{"id":241},{"id":242},{"id":244}]},{"id":258},{"id":259},{"id":"260"},{"id":"261"},{"id":"262"},{"id":"263"},{"id":"264"}]');

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE `menu_links` (
  `id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `access` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_links`
--

INSERT INTO `menu_links` (`id`, `link`, `title`, `access`, `icon`) VALUES
(16, 'theme_option/manage_menu', 'Manage Menu', 'a:1:{i:0;s:1:"1";}', 'icon-list'),
(17, 'theme_option/site_info', 'Software Configuration', 'a:1:{i:0;s:1:"1";}', 'icon-speech'),
(18, 'pages/home', 'Home', 'a:6:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"5";i:3;s:1:"6";i:4;s:1:"1";i:5;s:1:"4";}', 'icon-home'),
(21, '#', 'Configuration', 'a:1:{i:0;s:1:"1";}', 'icon-key'),
(67, 'theme_option/manage_role', 'Manage Role', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(138, 'theme_option/user_account/lists', 'User Accounts ', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(180, 'theme_option/user_account/add_user', 'Add Account', 'a:1:{i:0;s:1:"1";}', 'icon-user-follow'),
(187, 'theme_option/home/access_control', 'Account Access', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(188, '#', 'General Content', 'a:1:{i:0;s:1:"1";}', 'icon-screen-desktop'),
(189, 'pages/general_content/district', 'District List', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(190, 'pages/general_content/school', 'School List', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(193, 'pages/general_content/occupation', 'Occupation List', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(194, 'pages/general_content/transportation', 'Transportation', 'a:1:{i:0;s:1:"1";}', 'icon-basket'),
(195, '#', 'Employee Entry', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(196, '#', 'Reports', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(197, '#', 'Student Profile Entry', 'N;', 'icon-social-dropbox'),
(198, 'pages/classes/grade_manager', 'Grade Manager', 'a:1:{i:0;s:1:"1";}', 'icon-screen-desktop'),
(199, '#', 'Student Profile Entry', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(200, 'pages/profile/employee/add', 'Employee Profile Entry', 'a:1:{i:0;s:1:"1";}', 'icon-user-follow'),
(201, 'pages/profile/employee/manage', 'Manage Employee', 'a:1:{i:0;s:1:"1";}', 'icon-user-following'),
(202, 'pages/profile/student/add', 'Student Profile Entry', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(203, 'pages/classes/class_manager', 'Class Manager', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(204, 'pages/classes/batch', 'Batch', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(205, 'pages/classes/section_manager', 'Section Manager', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(206, 'pages/classes/subject_manager', 'Subject Manager', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(207, 'pages/classes/course_manager', 'Course Manager', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(208, 'pages/classes/house_manager', 'House Manager', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(209, '#', 'Student Marks Entry', 'N;', 'icon-mouse'),
(210, 'pages/exam/exam_setting', 'Exam Setting', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(211, 'pages/exam/assessment_setting', 'Assessment Setting ', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(212, 'pages/exam/marks_entry', 'Marks Entry', 'a:1:{i:0;s:1:"1";}', 'icon-hourglass'),
(213, 'pages/classes/lession_plan/add', 'Add Lesson Plan', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(214, 'pages/classes/lession_plan/migrate', 'Migrate Lesson Plan', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-layers'),
(215, 'pages/classes/lession_plan/edit', 'Edit Lesson Plan', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-note'),
(216, '#', 'Lesson Plan', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(217, 'pages/classes/lession_plan/add_activity', 'Add Activities', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(218, 'pages/classes/lession_plan/standards', 'Add Standards', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(219, 'pages/classes/subject_manager/migrate', 'Migrate Subject', 'a:1:{i:0;s:1:"1";}', 'icon-book-open'),
(220, 'pages/profile/student/manage', 'Manage Students', 'a:1:{i:0;s:1:"1";}', 'icon-users'),
(221, 'pages/profile/student/roll_no_reassign', 'Roll Number Reassign', 'a:1:{i:0;s:1:"1";}', 'icon-user-following'),
(222, 'pages/classes/appraisal_manager', 'Apprasial Manager', 'a:1:{i:0;s:1:"1";}', 'icon-trophy'),
(223, 'pages/classes/evaluation_criteria_manager', 'Evaluation Criteria Manager', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(224, 'pages/classes/club_manager', 'Club Manager', 'a:1:{i:0;s:1:"1";}', 'icon-layers'),
(225, '#', 'School', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(226, 'pages/classes/department_manager', 'Department Manager', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(227, 'theme_option/home/site_map', 'Site Map', 'a:1:{i:0;s:1:"1";}', 'icon-graph'),
(228, 'pages/profile/student/bulk_edit', 'Student Bulk Edit', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(229, 'pages/profile/student/class_reassign', 'Re-assign Class', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(230, 'pages/profile/student_photo', 'Bulk Photo Upload', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(231, 'pages/exam/marks_entry/terminal_total', 'Terminal Totaling', 'a:1:{i:0;s:1:"1";}', 'icon-screen-smartphone'),
(232, '#', 'Student Status', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(233, '#', 'Marksheet Reports', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(234, 'pages/reports/academic_report/exam_summary_report', 'Exam Summary Report', 'a:1:{i:0;s:1:"1";}', 'icon-screen-tablet'),
(235, '#', 'Marks Update', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-bag'),
(236, '#', 'Program', 'a:1:{i:0;s:1:"1";}', 'icon-screen-smartphone'),
(237, 'pages/reports/academic_report/st_attendance_report', 'Student Attendance Report', 'a:1:{i:0;s:1:"1";}', 'icon-user'),
(238, 'pages/reports/academic_report/class_rank', 'Class Rank', 'a:1:{i:0;s:1:"1";}', 'icon-speedometer'),
(239, '#', 'Employee Reports', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(240, 'pages/reports/employee_reports/employee_list_type', 'Employee List By Type', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(241, 'pages/reports/employee_reports/employee_list_agreement', 'Employee List By Agreement', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(242, 'pages/reports/employee_reports/employee_list_department', 'Employee List By Department', 'a:1:{i:0;s:1:"1";}', 'icon-screen-smartphone'),
(243, 'pages/reports/employee_reports/employee_list', 'Employee List', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(244, 'pages/reports/employee_reports/class_teachers', 'List Of Class Teacher', 'a:1:{i:0;s:1:"1";}', ''),
(245, '#', 'General Reports', 'a:3:{i:0;s:1:"3";i:1;s:1:"1";i:2;s:1:"4";}', 'icon-social-dropbox'),
(246, 'pages/reports/general_reports/student_list', 'Student List', 'a:3:{i:0;s:1:"3";i:1;s:1:"1";i:2;s:1:"4";}', 'icon-notebook'),
(247, 'pages/reports/general_reports/prev_school_st_list', 'Search By Previous School', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(248, 'pages/reports/general_reports/district_st_list', 'Student List According To District', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(249, 'pages/reports/general_reports/guardian_list_class', 'Guardian List By Class', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(250, 'pages/reports/general_reports/occupation_guardian_list', 'Student List According To Guardian Occupation', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-notebook'),
(251, 'pages/reports/general_reports/search_guardian_list', 'Guardian List By Name', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-eye'),
(252, 'pages/reports/general_reports/student_overall', 'Student Enrolled Report', 'a:1:{i:0;s:1:"1";}', 'icon-user-follow'),
(253, 'pages/reports/general_reports/dropped_student_list', 'Dropped Student List', 'a:2:{i:0;s:1:"1";i:1;s:1:"4";}', 'icon-social-dropbox'),
(254, 'pages/exam/exam_setting/marksheet_allow', 'Mark Sheet Restrict', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(255, 'pages/reports/class_reports/list_classes', 'Course Pointer Overview', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(256, 'pages/reports/general_reports/birthday_students', 'Student Birthday', 'a:1:{i:0;s:1:"1";}', 'icon-user'),
(257, 'pages/reports/general_reports/current_student_overall', 'Current Student Overall List', 'a:1:{i:0;s:1:"1";}', 'icon-screen-smartphone'),
(258, 'pages/reports/academic_report/student_evaluation_overall', 'Student Evaluation Overall Report', 'a:1:{i:0;s:1:"1";}', 'icon-trophy'),
(259, 'pages/notification', 'Notification', 'a:1:{i:0;s:1:"1";}', 'icon-social-twitter'),
(260, 'pages/reports/class_reports/gender_distribution', 'Student Gender Distribution', 'a:2:{i:0;s:1:"3";i:1;s:1:"1";}', 'icon-users'),
(261, 'pages/reports/general_reports/student_by_bus', 'Student List By Bus Stop', 'a:1:{i:0;s:1:"1";}', 'icon-social-dropbox'),
(262, 'pages/reports/general_reports/bus_time_table', 'Bus Route Time Table', 'a:1:{i:0;s:1:"1";}', 'icon-notebook'),
(263, 'pages/reports/general_reports/employee_distribution', 'Employee Distribution Chart', 'a:1:{i:0;s:1:"1";}', 'icon-social-dribbble'),
(264, 'pages/reports/general_reports/teacher_feedback_list', 'Teacher Feedback List', 'a:1:{i:0;s:1:"1";}', 'icon-notebook');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `usertype_id` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `notification_title` varchar(50) NOT NULL,
  `added_by` varchar(30) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `by_user_type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `usertype_id`, `msg`, `notification_title`, `added_by`, `added_on`, `by_user_type`) VALUES
(3, 'a:6:{i:0;s:1:"2";i:1;s:1:"3";i:2;s:1:"7";i:3;s:1:"5";i:4;s:1:"1";i:5;s:1:"4";}', 'this ti to notify that notification module workd', 'test Notification', 'satishm', '2018-04-06 10:53:37', NULL),
(4, 'a:1:{i:0;s:1:"4";}', 'hello sir', 'hello', 'lokeshm', '2018-04-13 14:27:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `occupation`
--

CREATE TABLE `occupation` (
  `occupation_id` int(10) NOT NULL,
  `occupation_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `occupation`
--

INSERT INTO `occupation` (`occupation_id`, `occupation_name`) VALUES
(2, 'ENGINEER'),
(3, 'BUSINESSMAN'),
(5, 'MINISTER'),
(6, 'SERVICE'),
(7, 'TEACHING'),
(8, 'LAWYER'),
(9, 'OTHERS'),
(11, 'GOVT SERVICE'),
(12, 'CONTRACTOR'),
(13, 'BANK MANAGER'),
(14, 'FARMER'),
(15, 'COODINATOR'),
(16, 'POLICE OFFICER'),
(17, 'ARMY OFFICER'),
(18, 'READER'),
(19, 'SOCIAL WORK'),
(20, 'ADVISOR'),
(21, 'SR C.H.O. (HEALTH)'),
(22, 'CIVIL OFFICER'),
(24, 'AGRICULTURIST'),
(25, 'POLITICIAN'),
(26, 'RESOURCE PERSON'),
(27, 'QUALITY CONTROL'),
(28, 'OFFICER'),
(29, 'AUDITOR'),
(30, 'CONSULTANT'),
(31, 'TREKKING GUIDE'),
(32, 'NATURALIST'),
(33, 'MGMT CONSULTANT'),
(34, 'SHOPKEEPER'),
(35, 'RESEARCHER'),
(36, 'JOURNALIST'),
(37, 'BIOLOGIST'),
(38, 'EMPLOYEE'),
(39, 'OVERSEAR'),
(40, 'INDUSTRIALIST'),
(41, 'RETIRED'),
(42, 'NOT AVAILABLE'),
(43, 'JUDGE'),
(45, 'HOUSE WIFE'),
(46, 'BANKER'),
(47, 'ASSISTANT DEAN'),
(48, 'ACCOUNTANT'),
(50, 'STUDENT'),
(51, 'PILOT'),
(52, 'FATHER'),
(53, 'ADMINISTRATOR'),
(54, 'FORESTY'),
(55, 'CHARTER ACCOUNTENT'),
(56, 'LECTURER'),
(57, 'OPTHALMOLOGIST'),
(58, 'MECHANICAL ENGINEERING'),
(59, 'COLD STORE SHOP'),
(60, 'RETD. SECRETARY OF HMG'),
(61, 'ADVOCATE'),
(62, 'UNITED NATION JOB'),
(63, 'RETD. GOVT. OFFICER'),
(64, 'INDUSTRALIST (SUJAL FOODS)'),
(66, 'STATISCIAN'),
(67, 'RETIRED BOARD SECRETARY, NIDC'),
(68, 'REGD, AUDITOR'),
(69, 'RETIRED OFFICER'),
(70, 'RETIRED POLICE OFFICER'),
(71, 'BANKING SERVICE'),
(75, 'LANDLORD'),
(76, 'NGAKPA'),
(79, 'INGO'),
(80, 'SHOP'),
(81, 'GIS SPECIALIST'),
(82, 'ADMINISTRATION ASSISTANT'),
(83, 'CONSULTANT (CEAMP PROJECT-TEAM LEADER)'),
(84, 'CIVIL ENGINEER'),
(85, 'HANDICRAFT'),
(86, 'CONSULTANT-ECONOMIST'),
(87, 'RETIRED ARMY OFFICER'),
(89, 'NURSING'),
(90, 'PRINCIPLE'),
(92, 'SERVICE-RASTRIYA BANIJYA BANK'),
(94, 'MANAGER'),
(95, 'CARPET INDUSTRY'),
(97, 'FINANCE COMPANY -PROMOTER'),
(98, 'CONSTRUCTOR'),
(100, 'LAB. TECHNICIAN'),
(101, 'CLOTH SHOP'),
(103, 'MANAGER OF CHAMUNDA HALL'),
(104, 'SECTION OFFICER'),
(105, 'X-ARMY'),
(106, 'CAMARA PROCESSING'),
(109, 'ELECTRICIAN'),
(110, 'CIVIL SERVENT'),
(111, 'EX- BRITISH ARMY'),
(112, 'RTD. BRITISH ARMY'),
(113, 'TRADE'),
(114, 'PREACHER'),
(115, 'GOVERNMENT OFFICER'),
(116, 'EX-ARMY'),
(117, 'SOUND-RECORDIST'),
(118, 'EX-EMPLOYEE'),
(119, 'HOUSE HOLD'),
(120, 'PROJECT MANAGER (LWF)'),
(121, 'GOVERNMENT SERVICE (MINISTRY OF FINANCE)'),
(122, 'DFO(FOREST DEPARTMENT)'),
(123, 'ASSISTANT PROFESSOR'),
(125, 'PROGRAMMER'),
(126, 'AIR HOSTESS'),
(127, 'RETIRED NEPAL BANK LTD'),
(128, 'PROJECT WORK'),
(129, 'CAMPUS CHIEF (MADAN BHANDARI MEMORIAL)'),
(130, 'PETROL PUMP'),
(131, 'SERVICE-JYOTI GROUP'),
(134, 'WELFARE OFFICER'),
(135, 'SERVICE (RNAC)'),
(136, 'SERVICE( BANIJYA BANK)'),
(138, 'LEGAL ADVISER'),
(139, 'WSP PROJECT'),
(140, 'TOURISM'),
(141, 'WHOLESALE'),
(142, 'GOVERNMENT SERVICE-UDAYAPUR CEMENT'),
(143, 'HOME MINISTER'),
(144, 'MINISTER OF FINANCE'),
(147, 'DEO'),
(148, 'SERVICE-NEPAL EYE HOSPITAL'),
(149, 'SHOP-TREKKING TYPE'),
(150, 'PROPRIETOR-TRAVELS'),
(151, 'JOB-ADVERTISING AGENCY'),
(152, 'TAILORING SHOP'),
(153, 'FOREIGN GOODS SHOP'),
(155, 'PHOTOCOPY-SHOP'),
(157, 'KNITTING'),
(160, 'ARMY'),
(161, 'GOVERNMENT OFFICER-FINANCIAL CONTROLLER'),
(164, 'SURVEYOR'),
(166, 'ARCHITECTURE'),
(167, 'DIRECTOR-NGCC'),
(168, 'REAL STATE'),
(169, 'CASHIER'),
(170, 'NEPAL TRANSIT WARE HOUSING COMPANY LTD.'),
(171, 'ASSISTANT MANAGER TOURS'),
(172, 'BREWMASTER'),
(173, 'PROFESSOR'),
(174, 'TRAVEL AGENT'),
(175, 'SALESMAN'),
(177, 'VICE CHANCELLOR'),
(178, 'FREE LANCER'),
(179, 'ACTING PRESIDENT'),
(180, 'MEDICAL OFFICER'),
(181, 'BHCM'),
(182, 'IT PROFESSIONAL'),
(183, 'INDIAN ARMY'),
(184, 'DEPUTY DIRECTOR'),
(185, 'EXECUTIVE DIRECTOR'),
(186, 'HOTEL PROPRITER'),
(187, 'BOARD OF DIRECTOR'),
(188, 'LOGISTIC MANAGER'),
(189, 'BEE KEEPER'),
(190, 'TECHNICIAN'),
(191, 'T.U. SERVICE'),
(192, 'PAINTER'),
(193, 'ARCHITECT'),
(194, 'AMBASSDOR'),
(195, 'RANGER'),
(196, 'ABROAD'),
(199, 'Finance Serice'),
(200, 'FINANCE SERVICE'),
(201, 'SUPERVISOR'),
(202, 'JOB'),
(203, 'PROPRIETOR / MD'),
(204, 'COMPUTER ENGINEER'),
(205, 'MARKETING ASSISTANT'),
(206, 'VETERINARIAN'),
(207, 'CIVIL SERVICE'),
(208, 'LIBRARIAN'),
(209, 'BEAUTICIAN'),
(210, 'DRIVER'),
(211, 'PRIVATE SERVICE'),
(212, 'MANAGING DIRECTOR'),
(213, 'TAILOR'),
(214, 'TRANSORTATION SERVICE'),
(215, 'AGRICULTURE'),
(216, 'COMPUTER WORKER'),
(217, 'HR ACTIVIST'),
(218, 'SCIENTIST'),
(219, 'IT ENGINEER'),
(220, 'SOCIAL ACTIVIST'),
(221, 'EMPLOYMENT'),
(222, 'MEDICINE (S.M.)'),
(223, 'GM'),
(224, 'PHOTOGRAPHER'),
(225, 'DRUGS TREATMENT'),
(226, 'CONSTRUCTION WORK'),
(227, 'AUDITING'),
(228, 'PRINCIPAL'),
(229, 'DIRECTOR'),
(230, 'FINANCE OFFICER'),
(231, 'COOK'),
(232, 'LABOUR'),
(234, 'MATRON'),
(235, 'ECONOMIST'),
(236, 'Doctor');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `org_id` bigint(20) NOT NULL,
  `org_name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) DEFAULT NULL,
  `description` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`org_id`, `org_name`, `address`, `phone`, `description`) VALUES
(1, 'HIMALAYAN TIMES', '', '', '  '),
(2, 'NEPAL BANK LTD', 'NEWROAD', '', ' '),
(3, 'SUBISU CABLENET PVT LTD', 'BALUWATAR', '', ' '),
(4, 'HUKUM PHARMACEUTICALS PVT LTD', 'PUTALISADAK', '', ' '),
(5, 'WORLD DISTRIBUTION PVT LTD', 'KANTIPATH', '', ' '),
(6, 'USA-FURTHER STUDIES', 'USA', '', '   '),
(7, 'NABIL BANK LTD', 'PULCHOWK', '', ' '),
(8, 'STANDARD CHARTERED BANK NEPAL LTD', 'BANESHWOR', '', '  '),
(9, 'HYATT- REGENCY', 'BOUDDHA', '', ' '),
(10, 'THE BOSS MAGAZINE', 'BANESHWOR', '', ' '),
(11, 'INFOCAN PVT. LTD', 'KAMALPOKHARI', '', ' '),
(12, 'RNAC', 'NEWROAD', '', ' '),
(13, 'CHAUDHARY GROUP', 'PULCHOWK', '', ' '),
(14, 'SELF EMPLOYED', '', '', ' '),
(15, 'INDIA-FURTHER STUDY', 'INDIA', '', ' '),
(16, 'FURTHER STUDY', '', '', ' '),
(17, 'PULCHOWK CAMPUS', '', '', ' '),
(18, 'JAPAN-FURTHER STUDY', 'JAPAN', '', ' '),
(19, 'WORLD LINK COMMUICATIONS PVT LTD', '', '', ' '),
(20, 'AIT', '', '', ' '),
(21, 'KU FURTHER STUDY', 'DHULIKHEL', '', ' '),
(22, 'ZTE CORPORATION', 'West Wing, First Floor Hotel Yak & Yeti', '4418931', ' '),
(23, 'NEA TRAINING CENTER', 'KHARIPATI, BHAKTAPUR', '', ' '),
(24, 'NEA-BAGMATI TRANSMISSION MAINBRANCH', 'MINBHAWAN', '', ' '),
(25, 'ICL CERTIFICATIONS NEPAL PVT. LTD', 'INDRACHOWK', '4220438', '  '),
(26, ' BMK GROUP INTERNATIONAL PVT. LTD', 'JHAMSIKHEL', '5552289', '   '),
(27, 'BANK OF KATHMANDU', 'KATHMANDU', '', '  '),
(28, 'NATARAJ TRAVELS', '', '', ' '),
(29, 'I MAX', '', '', ' '),
(30, 'ALTERNATIVE SOLUTIONS', '', '', ' '),
(31, 'NOT AVAILABLE', '', '', ' '),
(32, 'NEPAL INVESTMENT BANK LTD', '', '', ' '),
(33, 'NEPAL BANGLADESH BANK LTD.', '', '', ' '),
(34, 'GOLCHHA ORGANIZATION', '', '', ' '),
(35, 'RASTRIYA BANIJYA BANK', '', '', ' '),
(36, 'PRUDENTIAL INSURANCE COMPANY', '', '', ' '),
(37, 'APEX COLLEGE', 'BANESHWOR', '4478841', 'College for Undergraduate and Graduate studies.'),
(38, 'INFORMATION TECHNOLOGY EXPERTS GROUP', 'BANESHWOR', '012042874', 'A Complete Software Solution Industry');

-- --------------------------------------------------------

--
-- Table structure for table `parentfeedback`
--

CREATE TABLE `parentfeedback` (
  `feedback_id` bigint(20) NOT NULL,
  `parent_name` varchar(128) DEFAULT NULL,
  `parent_email` varchar(128) DEFAULT NULL,
  `parent_comment` longtext,
  `parent_username` varchar(32) DEFAULT NULL,
  `ipaddress` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `comment_date` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parent_evaluation`
--

CREATE TABLE `parent_evaluation` (
  `parent_evaluation_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `evaluation_date` date NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `section_id` int(11) NOT NULL,
  `remarks` text,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `ROLE_ID` int(11) NOT NULL,
  `ROLE_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ROLE_ID`, `ROLE_NAME`) VALUES
(2, 'admin'),
(3, 'board'),
(7, 'parent'),
(5, 'student'),
(1, 'su_admin'),
(4, 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship`
--

CREATE TABLE `scholarship` (
  `scholarship_id` bigint(20) NOT NULL,
  `st_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `semester_name` varchar(64) NOT NULL DEFAULT '',
  `scholarship_type` varchar(64) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `school_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`school_id`, `school_name`, `school_address`) VALUES
(1, 'Tajeswari English Boarding School', 'Baneshwor, Kathmandu'),
(2, 'Lotus Public School', 'Gaurighat, Chabhil'),
(4, 'TEZENSHREE SCHOOL', 'BANESHWOR'),
(5, 'MONTESSORI KINDER HOUSE', 'MID BANESHWOR - 34, KATHMANDU'),
(6, 'SHINING PARADISE ACADEMY SCHOOL', ''),
(7, 'VENUS ENGLISH SCHOOL', 'BHIMSENGOLA'),
(8, 'MODERN CONVENT SCHOOL', 'RATO POOL'),
(9, 'MORAL ACADEMY', 'NEW BANESHWOR'),
(10, 'VIDYA PUNJA E. S. SCHOOL', 'LAMATAR - 8 , LALITPUR'),
(11, 'NEPAL IDEAL SCHOOL', 'BANESHWOR'),
(12, 'SEASON BOARDING HIGH SCHOOL', 'BANESHWOR'),
(13, 'NAVA JYOTI ENGLISH BOARDING SCHOOL', 'KOTESHWOR - 35, KATHMANDU, NEPAL'),
(14, 'KENJI INTERNATIONAL SCHOOL', 'TINKUNE'),
(15, 'TEJASBIN B. SCHOOL', 'OLD BANESHWOR HEIGHT, NEAR MELAMCHI OFFICE'),
(16, 'INNOVATIVE ENGLISH SCHOOL', 'BUDDHANAGAR, KATHMANDU'),
(17, 'MUNAL ENGLISH BOARDING HIGH SCHOOL', 'JYOTI PATH, BUTWAL- 8,RUPANDEHI, LUMBINI, NEPAL'),
(18, 'JAI BAGESWORI HIGHER SECONDARY SCHOOL', 'NEPALGUNJ'),
(19, 'DENEB INTERNATIONAL SCHOOL', 'NEW BANESHWOR, THAPA GAUN'),
(20, 'SUNRISE BOARDING SCHOOL', 'DAILEKH'),
(21, 'TULSI BOARDING SCHOOL', 'TULSIPUR 5, DANG'),
(22, 'CAMBRIDGE PUBLIC HIGH SCHOOL', 'OLD BANESHWOR'),
(23, 'HIMALAYAN BIDYA MANDIR', 'KALOPOOL'),
(24, 'BIDHYA SAGAR ENGLISH BOARDING SCHOOL', 'JORPATI, KATHMANDU'),
(25, 'HOLY GEMS ACADEMY', 'BANESHWOR, LAKHECHAUR MARG, KATHMANDU'),
(26, 'SIDDHARTHA SHISHU SADAN', 'DHARAN'),
(27, 'PRAGYA KUNJA SCHOOL', 'MILAN CHOWK'),
(28, 'BRIGHT FUTURE', 'SATDOBATO, LALITPUR '),
(29, 'MAHA SIDDHARTHA', 'BOUDDHA'),
(30, 'VS NIKETAN', 'MINBHUWAN'),
(31, 'USHA BAL VATIKA SECONDARY SCHOOL', 'BIRENDRA NAGAR, SURKHET'),
(32, 'SHANTI NIKETAN', 'KAPILVASTU'),
(33, 'SENT DEVIS SCHOOL', 'SUKEDHARA, KATHMANDU'),
(34, 'AASHA ENGLSIH BOARDING SCHOOL', 'MAITIDEVI, KATHMANDU'),
(35, 'TRIYOG HIGH SCHOOL', 'DHAPASI 6, KATHMANDU'),
(36, 'THREE STARS ENGLISH SCHOOL', 'DHANGADI, KAILALI'),
(37, 'PIOUS PUBLIC SCHOOL', ''),
(38, 'BRIHASPATI BIDHYA SADAN', 'NAXAL, KATHMANDU'),
(39, 'PEOPLE SECONDARY SCHOOL', 'SARASWOTI NAGAR, KOTESHWOR'),
(40, 'HOLYLAND INTERNATIONAL SCHOOL', ''),
(41, 'DIKTEL ENGLISH SECONDARY BOARDING SCHOOL', ''),
(42, 'UNITED ACADEMY', ''),
(43, 'SHISHU NIKETAN SCHOOL', ''),
(44, 'BUDDHA JYOTI H. S. SCHOOL', 'SIDDHARTHANAGAR, RUPANDEHI'),
(45, 'SAIPAL ACADEMY', 'NEW BANESHWOR'),
(46, 'JAN JYOTI BOARDING SCHOOL', 'GULARIA MUNICAPILITY, BARDIA'),
(47, 'STANDFORD INTERNATIONAL SCHOOL', 'BHAKTAPUR, KAUSALTAR'),
(48, 'LALIGURANS ACADEMY', 'ISHWORPUR 2, SARLAHI'),
(49, 'CANVAS BOARDING HIGH SCHOOL', ''),
(50, 'LITTLE ANGLE''S SCHOOL', ''),
(51, 'PARAGON PUBLIC SCHOOL', 'GAUSHALA, KATHMANDU'),
(52, 'S.N.S', 'OLD BANESHWOR, KATHMANDU'),
(53, 'SHREE MAHENDRA HIGHER SECONDARY SCHOOL', 'KHALAHGA, PYUTHAN'),
(54, 'SHREE 5 RATNA RAJYA HIGH SCHOOL', 'BANESHWOR, KATHMANDU'),
(55, 'SARASWOTI H.S. SCHOOL', 'CHHETRAPATI'),
(56, 'GALAXY PUBLIC SCHOOL', 'GANESHWOR, KATHMANDU'),
(57, 'IDEAL MODEL SCHOOL', 'JHAMSIKHEL, LALITPUR'),
(58, 'ITAHARI MODEL SCHOOL', ''),
(59, 'UDAYASI ENGLISH SECONDARY SCHOOL', 'JALJALE, UDAYAPUR'),
(60, 'SHREE MAHANKAL SECONDARY SCHOOL', ''),
(61, 'UDHAYAPUR ENGLISH BOARDING SCHOOL ', 'GAIGHAT 2, UDAYAPUR'),
(62, 'NEPAL ENGLISH PREPARATORY S.B.SCHOOL', 'BASANTAPUR TOLE, PALPA'),
(63, 'ACME ACADEMY', 'BHIMSENGOLA 34'),
(64, 'MOUNT SINAI ENGLISH SCHOOL', 'MINBHAWAN'),
(65, 'GYAN NIKETAN SCHOOL', 'SHANKHAMUL'),
(66, 'DAFFODIL PUBLIC SCHOOL', 'KAPAN'),
(67, 'OCCIDENTAL PUBLIC SCHOOL', 'ANAMNAGAR, KATHMANDU'),
(68, 'THE CITY ACADEMY', 'BANESHWOR, KATHMANDU'),
(69, 'OM GYAN MANDIR', ''),
(70, 'SATHYA SAI SCHOOL', 'GAUSHALA, PINGLASTHAN'),
(71, 'LOYOLA HIGH SCHOOL', 'BANESHWOR, KATHMANDU'),
(72, 'RELIANCE RESIDENTAL SCHOOL', ''),
(73, 'DIVYAJYOTI ENGLISH BOARDING SCHOOL', ''),
(74, 'IDEAL ENGLISH H. S . SCHOOL', 'MAIJUBAHAL, CHABAHIL'),
(75, 'RATNA SHIKSHA SADAN', 'KOTESHWOR'),
(76, 'BAL KANYA SCHOOL', ''),
(77, 'SHREE GANESH HIMAL BOARDING SCHOOL', 'GONGABU, KATHMANDU'),
(78, 'SIDDHARTHA VIDYA SADAN', 'NEW BANESHWOR'),
(79, 'BALKUMARI SECONDARY BOARDING SCHOOL', ''),
(80, 'St. MARYS HIGH SCHOOL', 'POKHARA '),
(81, 'SIDDHARTHA VANASTHALI INSTITUTION', 'VANASTHALI'),
(82, 'STAR INTERNATIONAL ', 'OLD BANESHWOR, KATHMANDU'),
(83, 'NEW HORIZON ENGLISH SCHOOL', 'KAUSHALTAR'),
(84, 'PACIFIC ACADEMY', 'SHANKHAMUL'),
(85, 'TELIC MODEL INTE''L SCHOOL', 'KULESHWOR, KATHMANDU'),
(86, 'ADARSHA VIDYA MANDIR', 'LALITPUR'),
(87, 'INDRADHANUSH E. H. SCHOOL', 'OLD BANESHWOR'),
(88, 'NEPAL DON BOSCO SCHOOL', 'SIDDHIPUR, LALITPUR'),
(89, 'SAROJ BABY CARE', 'OLD BANESHWOR'),
(90, 'PUSPA SADAN HIGH SCHOOL', 'KIRTIPUR'),
(91, 'MACHPERSON PRIMARY SCHOOL', 'SINGAPORE'),
(92, 'ANGEL LORD ACADEMY', 'KOTESHWOR 35, KATHMANDU'),
(93, 'MAHENDRA BHAWAN SCHOOL', 'SANO GAUCHARAN, GYANESHWOR'),
(94, 'SIDDARTTH PUBLIC SCHOOL', 'TIIBHUWAN BASTI, I.B.R.D., KANCHANPUR'),
(95, 'VIDYA MEMORAL SECONDARY ', 'BIRENDRANAGAR, CHITWAN'),
(96, 'RELIANCE ENGLISH BOARDING SCHOOL', 'BASUDEV MARG, HETAUDA 2'),
(97, 'L.R.I SCHOOL ', 'KALANKI KATHMANDU'),
(98, 'ASDF', 'ASDF'),
(99, 'CLINTON SCHOOL', 'KATHMANDU');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `batch` int(11) NOT NULL,
  `grade` varchar(32) NOT NULL,
  `section_name` varchar(32) NOT NULL,
  `class_teacher_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sibling`
--

CREATE TABLE `sibling` (
  `sibling_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `sibling_name` varchar(302) NOT NULL DEFAULT '',
  `relation` varchar(100) DEFAULT NULL,
  `sibling_dob` varchar(30) DEFAULT NULL,
  `sibling_qualification` varchar(255) DEFAULT NULL,
  `sibling_institution` varchar(255) DEFAULT NULL,
  `sibling_st_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` bigint(20) NOT NULL,
  `registration_number` varchar(20) DEFAULT NULL,
  `st_fname` varchar(100) NOT NULL,
  `st_mname` varchar(100) DEFAULT NULL,
  `st_lname` varchar(100) NOT NULL,
  `st_dob` date DEFAULT NULL,
  `st_dob_np` varchar(32) NOT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `gender` varchar(8) DEFAULT NULL,
  `home_phone` varchar(50) DEFAULT NULL,
  `home_address` varchar(255) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `joined_grade_id` varchar(11) DEFAULT NULL,
  `joined_date` varchar(20) DEFAULT NULL,
  `joined_date_np` varchar(255) NOT NULL,
  `joined_batch` varchar(4) DEFAULT NULL,
  `last_school_id` int(11) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_cell` varchar(50) DEFAULT NULL,
  `father_employer` varchar(100) DEFAULT NULL,
  `father_occupation_id` int(11) DEFAULT NULL,
  `father_business_add` varchar(255) DEFAULT NULL,
  `father_email` varchar(128) DEFAULT NULL,
  `father_education` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_cell` varchar(50) DEFAULT NULL,
  `mother_employer` varchar(100) DEFAULT NULL,
  `mother_occupation_id` int(11) DEFAULT NULL,
  `mother_business_add` varchar(255) DEFAULT NULL,
  `mother_email` varchar(128) DEFAULT NULL,
  `mother_education` varchar(100) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_occupation_id` int(11) DEFAULT NULL,
  `guardian_phone` varchar(50) DEFAULT NULL,
  `guardian_email` varchar(128) DEFAULT NULL,
  `blood_group` varchar(8) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `house_id` int(11) DEFAULT NULL,
  `emergency_contact` varchar(100) DEFAULT NULL,
  `ec_address` varchar(255) DEFAULT NULL,
  `ec_relation` varchar(100) DEFAULT NULL,
  `ec_phone` varchar(50) DEFAULT NULL,
  `picture_path` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `current_roll` varchar(10) DEFAULT NULL,
  `boarding_type` varchar(100) DEFAULT NULL,
  `bus_id` int(11) DEFAULT NULL,
  `stop_id` int(11) DEFAULT NULL,
  `passed_out` tinyint(1) DEFAULT '0',
  `dropped_out` tinyint(1) DEFAULT '0',
  `birth_mark` varchar(255) DEFAULT NULL,
  `weight` varchar(30) DEFAULT NULL,
  `height` varchar(30) DEFAULT NULL,
  `special_needs` varchar(255) DEFAULT NULL,
  `family_number` int(11) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_achievement`
--

CREATE TABLE `student_achievement` (
  `st_achievement_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `achievement` varchar(255) NOT NULL DEFAULT '',
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_achievement`
--

INSERT INTO `student_achievement` (`st_achievement_id`, `student_id`, `achievement`, `remarks`) VALUES
(1, 144, 'Gold Medal', 'First place in the inter school competetion in swimming'),
(2, 152, 'School Badminton Champion', 'School Champion 2006'),
(4, 1214, 'www', 'r'),
(5, 1218, 'Table Tennis', 'Ranked First Position');

-- --------------------------------------------------------

--
-- Table structure for table `student_allergy`
--

CREATE TABLE `student_allergy` (
  `st_allergy_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `allergy` varchar(255) NOT NULL,
  `start_date` varchar(30) DEFAULT NULL,
  `end_date` varchar(30) DEFAULT NULL,
  `current_status` varchar(255) DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_category`
--

CREATE TABLE `student_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_category`
--

INSERT INTO `student_category` (`category_id`, `category_name`) VALUES
(1, 'Day Scholar'),
(2, 'Boarder'),
(3, 'Day Boarder');

-- --------------------------------------------------------

--
-- Table structure for table `student_club`
--

CREATE TABLE `student_club` (
  `st_club_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `club_type` varchar(32) NOT NULL,
  `club` varchar(32) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_club`
--

INSERT INTO `student_club` (`st_club_id`, `student_id`, `club_type`, `club`, `designation`, `active`) VALUES
(15, 1214, 'Sports Club', '', 'asdfasdf', 1),
(16, 1218, 'Sports Club', '', 'President', 1),
(17, 1218, 'Sports Club', '', 'President', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_condition`
--

CREATE TABLE `student_condition` (
  `st_condition_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `condition_name` varchar(255) NOT NULL DEFAULT '',
  `start_date` varchar(30) DEFAULT NULL,
  `end_date` varchar(30) DEFAULT NULL,
  `current_status` varchar(255) DEFAULT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_designation`
--

CREATE TABLE `student_designation` (
  `st_designation_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_evaluation`
--

CREATE TABLE `student_evaluation` (
  `st_evaluation_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `evaluation_date` date NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `remarks` text,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_game`
--

CREATE TABLE `student_game` (
  `st_game_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `game` varchar(100) NOT NULL DEFAULT '',
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_hobby`
--

CREATE TABLE `student_hobby` (
  `st_hobby_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `hobby` varchar(255) NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_medical`
--

CREATE TABLE `student_medical` (
  `st_illness_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `illness_id` int(11) NOT NULL,
  `period_suffered` varchar(20) DEFAULT NULL,
  `current_status` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_medication`
--

CREATE TABLE `student_medication` (
  `st_medication_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `medication` varchar(255) NOT NULL,
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_optional`
--

CREATE TABLE `student_optional` (
  `st_opt_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_optional`
--

INSERT INTO `student_optional` (`st_opt_id`, `student_id`, `grade_id`, `subject_id`) VALUES
(1, 156, 13, 103),
(2, 152, 13, 103);

-- --------------------------------------------------------

--
-- Table structure for table `student_status`
--

CREATE TABLE `student_status` (
  `student_status_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `terminal_id` int(11) NOT NULL,
  `confirmed_status` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_summary`
--

CREATE TABLE `student_summary` (
  `summary_id` bigint(20) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `grade_id` int(11) NOT NULL,
  `section` varchar(20) NOT NULL,
  `joined` int(11) DEFAULT NULL,
  `promoted` int(11) DEFAULT NULL,
  `existent` int(11) DEFAULT NULL,
  `passed` int(11) DEFAULT NULL,
  `failed` int(11) DEFAULT NULL,
  `dropped` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `st_comment`
--

CREATE TABLE `st_comment` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `comments` longtext,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` varchar(36) NOT NULL,
  `comment_type` varchar(32) DEFAULT NULL,
  `parent_contact_required` tinyint(1) DEFAULT NULL,
  `parent_contacted` tinyint(1) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL,
  `class_days_id` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `st_comment`
--

INSERT INTO `st_comment` (`comment_id`, `student_id`, `comments`, `comment_date`, `user_id`, `comment_type`, `parent_contact_required`, `parent_contacted`, `is_public`, `class_days_id`) VALUES
(3, 1198, 'this the comment for aaradhya dahal', '2018-01-31 08:03:34', '11', 'Academic', 1, 1, NULL, 1295),
(4, 1218, 'He needs to work hard', '2018-04-02 10:17:58', '67', 'General', 1, 1, NULL, 1379),
(5, 1218, 'test', '2018-04-05 04:57:16', '11', 'Academic', 1, 1, NULL, 1379),
(6, 1218, 'test', '2018-04-05 06:06:15', '11', 'General', 1, 1, NULL, 1379),
(7, 1218, 'He has not done homewark', '2018-04-10 06:48:04', '67', 'Attendance', 1, 1, NULL, 1379);

-- --------------------------------------------------------

--
-- Table structure for table `st_marks`
--

CREATE TABLE `st_marks` (
  `stmarks_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `obtain_mark` int(11) NOT NULL,
  `assessment_marks` text NOT NULL,
  `total_marks` double DEFAULT NULL,
  `class_days_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `grade` varchar(32) NOT NULL,
  `full_marks` int(11) DEFAULT NULL,
  `pass_marks` int(11) DEFAULT NULL,
  `added_batch` int(11) DEFAULT NULL,
  `subject_type` varchar(20) DEFAULT 'COMPULSORY'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `grade`, `full_marks`, `pass_marks`, `added_batch`, `subject_type`) VALUES
(9, 'Mathematics', 'Seven', 100, 40, 2071, 'COMPULSORY'),
(10, 'Science', 'Seven', 100, 40, 2071, 'COMPULSORY'),
(11, 'Social Studies', 'Seven', 100, 40, 2071, 'COMPULSORY'),
(12, 'Computer', 'Seven', 50, 20, 2071, 'COMPULSORY'),
(13, 'Project', 'Seven', 100, 40, 2071, 'COMPULSORY'),
(14, 'Creative Expression', 'Seven', 100, 40, 2071, 'COMPULSORY'),
(15, 'English', 'Four', 100, 40, 2071, 'COMPULSORY'),
(21, 'Nepali', 'Four', 100, 40, 2071, 'COMPULSORY'),
(22, 'Mathematics', 'Four', 100, 40, 2071, 'COMPULSORY'),
(23, 'Science', 'Four', 100, 40, 2071, 'COMPULSORY'),
(24, 'Social Studies', 'Four', 100, 40, 2071, 'COMPULSORY'),
(25, 'Computer', 'Four', 50, 20, 2071, 'COMPULSORY'),
(26, 'Creative Expression', 'Four', 100, 40, 2071, 'COMPULSORY'),
(27, 'English', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(28, 'Nepali', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(29, 'Mathematics', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(30, 'Science', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(31, 'Social Studies', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(32, 'Computer', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(33, 'Optional Maths', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(34, 'Project', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(35, 'HPE', 'Eight', NULL, NULL, 2071, 'COMPULSORY'),
(36, 'English', 'Five', 100, 40, 2071, 'COMPULSORY'),
(37, 'Nepali', 'Five', 100, 40, 2071, 'COMPULSORY'),
(38, 'Mathematics', 'Five', 100, 40, 2071, 'COMPULSORY'),
(39, 'Science', 'Five', 100, 40, 2071, 'COMPULSORY'),
(40, 'Social Studies', 'Five', 100, 40, 2071, 'COMPULSORY'),
(41, 'Computer', 'Five', 50, 20, 2071, 'COMPULSORY'),
(42, 'C R E', 'Five', 100, 40, 2071, 'COMPULSORY'),
(43, 'English', '17', 50, 20, 2071, 'COMPULSORY'),
(44, 'Nepali', '17', 50, 20, 2071, 'COMPULSORY'),
(45, 'Maths', '17', 50, 20, 2071, 'COMPULSORY'),
(46, 'Science', '17', 50, 20, 2071, 'COMPULSORY'),
(47, 'English', '16', 50, 20, 2071, 'COMPULSORY'),
(48, 'Nepali', '16', 50, 20, 2071, 'COMPULSORY'),
(49, 'Mathematics', '16', 50, 20, 2071, 'COMPULSORY'),
(50, 'Science', '16', 50, 20, 2071, 'COMPULSORY'),
(51, 'English', 'Two', 100, 40, 2071, 'COMPULSORY'),
(52, 'Nepali', 'Two', 100, 40, 2071, 'COMPULSORY'),
(53, 'Mathematics', 'Two', 100, 40, 2071, 'COMPULSORY'),
(54, 'Science', 'Two', 100, 40, 2071, 'COMPULSORY'),
(55, 'Social Studies', 'Two', 100, 40, 2071, 'COMPULSORY'),
(57, 'Nepali', 'One', 100, 40, 2071, 'COMPULSORY'),
(58, 'Mathematics', 'One', 100, 40, 2071, 'COMPULSORY'),
(59, 'Science', 'One', 100, 40, 2071, 'COMPULSORY'),
(60, 'Social Studies', 'One', 100, 40, 2071, 'COMPULSORY'),
(61, 'English', 'Six', 100, 40, 2071, 'COMPULSORY'),
(62, 'Nepali', 'Six', 100, 40, 2071, 'COMPULSORY'),
(63, 'Mathematics', 'Six', 100, 40, 2071, 'COMPULSORY'),
(64, 'Science', 'Six', 100, 40, 2071, 'COMPULSORY'),
(65, 'Social Studies', 'Six', 100, 40, 2071, 'COMPULSORY'),
(66, 'Computer', 'Six', 50, 20, 2071, 'COMPULSORY'),
(67, 'Creative Expression', 'Six', 100, 40, 2071, 'COMPULSORY'),
(68, 'Project', 'Six', 100, 40, 2071, 'COMPULSORY'),
(69, 'English', 'Three', 100, 40, 2071, 'COMPULSORY'),
(70, 'Nepali', 'Three', 100, 40, 2071, 'COMPULSORY'),
(71, 'Mathematics', 'Three', 100, 40, 2071, 'COMPULSORY'),
(72, 'Science', 'Three', 100, 40, 2071, 'COMPULSORY'),
(73, 'Social Studies', 'Three', 100, 40, 2071, 'COMPULSORY'),
(74, 'Computer', 'Three', 100, 40, 2071, 'COMPULSORY'),
(75, 'English', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(76, 'Nepali', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(77, 'C Mathematics', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(78, 'Science', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(79, 'Social Studies', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(84, 'CRE', 'Nine', 100, 40, 2071, 'COMPULSORY'),
(85, 'English', '18', 100, 40, 2071, 'COMPULSORY'),
(86, 'Nepali', '18', 100, 40, 2071, 'COMPULSORY'),
(89, 'Social studies', '18', 100, 40, 2071, 'COMPULSORY'),
(92, 'Opt II', '18', 100, 40, 2071, 'COMPULSORY'),
(93, 'English', 'Ten', 100, 40, 2071, 'COMPULSORY'),
(111, 'English', 'One', 100, 45, 2072, 'COMPULSORY'),
(112, 'Mathematics', 'One', 100, 45, 2072, 'COMPULSORY'),
(115, 'English', 'One', 100, 45, 2064, 'COMPULSORY'),
(121, 'English', 'One', 100, 40, 2073, 'COMPULSORY'),
(122, 'Nepali', 'One', 100, 45, 2073, 'COMPULSORY'),
(123, 'Mathematics', 'One', 100, 45, 2073, 'COMPULSORY'),
(124, 'Science', 'One', 100, 40, 2073, 'COMPULSORY'),
(125, 'Social Studies', 'One', 100, 40, 2073, 'COMPULSORY'),
(126, 'Computer', 'One', 50, 20, 2073, 'OPTIONAL'),
(127, 'Moral Science', 'One', 100, 40, 2073, 'OPTIONAL'),
(128, 'Literature', 'One', 100, 40, 2073, 'OPTIONAL'),
(129, 'Computer', 'Two', 50, 20, 2073, 'OPTIONAL'),
(130, 'English', 'Two', 100, 40, 2073, 'COMPULSORY'),
(131, 'Literature', 'Two', 100, 40, 2073, 'OPTIONAL'),
(132, 'Mathematics', 'Two', 100, 45, 2073, 'COMPULSORY'),
(133, 'Moral Science', 'Two', 100, 40, 2073, 'OPTIONAL'),
(134, 'Nepali', 'Two', 10, 45, 2073, 'COMPULSORY'),
(135, 'Science', 'Two', 100, 40, 2073, 'COMPULSORY'),
(136, 'Social Studies', 'Two', 100, 40, 2073, 'COMPULSORY'),
(137, 'Computer', 'Three', 50, 20, 2073, 'OPTIONAL'),
(138, 'English', 'Three', 100, 40, 2073, 'COMPULSORY'),
(139, 'Literature', 'Three', 50, 20, 2073, 'OPTIONAL'),
(140, 'Mathematics', 'Three', 100, 45, 2073, 'COMPULSORY'),
(141, 'Moral Science', 'Three', 100, 40, 2073, 'OPTIONAL'),
(142, 'Nepali', 'Three', 10, 45, 2073, 'COMPULSORY'),
(143, 'Science', 'Three', 100, 40, 2073, 'COMPULSORY'),
(144, 'Social Studies', 'Three', 100, 40, 2073, 'COMPULSORY'),
(145, 'Computer', 'Four', 50, 20, 2073, 'OPTIONAL'),
(146, 'English', 'Four', 100, 40, 2073, 'COMPULSORY'),
(147, 'Literature', 'Four', 50, 20, 2073, 'OPTIONAL'),
(148, 'Mathematics', 'Four', 100, 45, 2073, 'COMPULSORY'),
(149, 'Moral Science', 'Four', 40, 20, 2073, 'OPTIONAL'),
(150, 'Nepali', 'Four', 10, 45, 2073, 'COMPULSORY'),
(151, 'Science', 'Four', 100, 40, 2073, 'COMPULSORY'),
(152, 'Social Studies', 'Four', 100, 40, 2073, 'COMPULSORY'),
(153, 'Computer', 'Five', 50, 20, 2073, 'OPTIONAL'),
(154, 'English', 'Five', 100, 40, 2073, 'COMPULSORY'),
(155, 'Literature', 'Five', 50, 20, 2073, 'OPTIONAL'),
(156, 'Mathematics', 'Five', 100, 45, 2073, 'COMPULSORY'),
(157, 'Moral Science', 'Five', 40, 20, 2073, 'OPTIONAL'),
(158, 'Nepali', 'Five', 10, 45, 2073, 'COMPULSORY'),
(159, 'Science', 'Five', 100, 40, 2073, 'COMPULSORY'),
(160, 'Social Studies', 'Five', 100, 40, 2073, 'COMPULSORY'),
(161, 'Computer', 'Six', 50, 20, 2073, 'OPTIONAL'),
(162, 'English', 'Six', 100, 40, 2073, 'COMPULSORY'),
(163, 'Literature', 'Six', 50, 20, 2073, 'OPTIONAL'),
(164, 'Mathematics', 'Six', 100, 45, 2073, 'COMPULSORY'),
(165, 'Moral Science', 'Six', 40, 20, 2073, 'OPTIONAL'),
(166, 'Nepali', 'Six', 10, 45, 2073, 'COMPULSORY'),
(167, 'Science', 'Six', 100, 40, 2073, 'COMPULSORY'),
(168, 'Social Studies', 'Six', 100, 40, 2073, 'COMPULSORY'),
(169, 'Computer', 'Seven', 50, 20, 2073, 'OPTIONAL'),
(170, 'English', 'Seven', 100, 40, 2073, 'COMPULSORY'),
(171, 'Literature', 'Seven', 50, 20, 2073, 'OPTIONAL'),
(172, 'Mathematics', 'Seven', 100, 45, 2073, 'COMPULSORY'),
(173, 'Moral Science', 'Seven', 40, 20, 2073, 'OPTIONAL'),
(174, 'Nepali', 'Seven', 10, 45, 2073, 'COMPULSORY'),
(175, 'Science', 'Seven', 100, 40, 2073, 'COMPULSORY'),
(176, 'Social Studies', 'Seven', 100, 40, 2073, 'COMPULSORY'),
(177, 'Computer', 'Eight', 50, 20, 2073, 'OPTIONAL'),
(178, 'English', 'Eight', 100, 40, 2073, 'COMPULSORY'),
(179, 'Literature', 'Eight', 50, 20, 2073, 'OPTIONAL'),
(180, 'Mathematics', 'Eight', 100, 45, 2073, 'COMPULSORY'),
(181, 'Moral Science', 'Eight', 40, 20, 2073, 'OPTIONAL'),
(182, 'Nepali', 'Eight', 100, 45, 2073, 'COMPULSORY'),
(183, 'Science', 'Eight', 100, 40, 2073, 'COMPULSORY'),
(184, 'Social Studies', 'Eight', 100, 40, 2073, 'COMPULSORY'),
(185, 'Computer', 'Nine', 50, 20, 2073, 'OPTIONAL'),
(186, 'English', 'Nine', 100, 40, 2073, 'COMPULSORY'),
(187, 'Literature', 'Nine', 50, 20, 2073, 'OPTIONAL'),
(188, 'Mathematics', 'Nine', 100, 45, 2073, 'COMPULSORY'),
(189, 'Moral Science', 'Nine', 100, 40, 2073, 'OPTIONAL'),
(190, 'Nepali', 'Nine', 10, 45, 2073, 'COMPULSORY'),
(191, 'Science', 'Nine', 100, 40, 2073, 'COMPULSORY'),
(192, 'Social Studies', 'Nine', 100, 40, 2073, 'COMPULSORY'),
(194, 'Sanskrit', 'Two', 50, 30, 2073, 'COMPULSORY'),
(195, 'Computer', 'Twelve', 50, 20, 2073, 'OPTIONAL'),
(196, 'English', 'Twelve', 100, 40, 2073, 'COMPULSORY'),
(197, 'Literature', 'Twelve', 100, 40, 2073, 'OPTIONAL'),
(198, 'Mathematics', 'Twelve', 100, 45, 2073, 'COMPULSORY'),
(199, 'Moral Science', 'Twelve', 100, 40, 2073, 'OPTIONAL'),
(200, 'Nepali', 'Twelve', 100, 45, 2073, 'COMPULSORY'),
(201, 'Science', 'Twelve', 100, 40, 2073, 'COMPULSORY'),
(203, 'Computer', 'One', 50, 20, 2074, 'OPTIONAL'),
(204, 'English', 'One', 100, 40, 2074, 'COMPULSORY'),
(205, 'Literature', 'One', 100, 40, 2074, 'OPTIONAL'),
(206, 'Mathematics', 'One', 100, 40, 2074, 'COMPULSORY'),
(207, 'Moral Science', 'One', 100, 40, 2074, 'OPTIONAL'),
(208, 'Nepali', 'One', 100, 45, 2074, 'COMPULSORY'),
(209, 'Science', 'One', 100, 40, 2074, 'COMPULSORY'),
(210, 'Social Studies', 'One', 100, 40, 2074, 'COMPULSORY'),
(211, 'Computer', 'Two', 50, 20, 2074, 'OPTIONAL'),
(212, 'English', 'Two', 100, 40, 2074, 'COMPULSORY'),
(213, 'Literature', 'Two', 100, 40, 2074, 'OPTIONAL'),
(214, 'Mathematics', 'Two', 100, 45, 2074, 'COMPULSORY'),
(215, 'Moral Science', 'Two', 100, 40, 2074, 'OPTIONAL'),
(216, 'Nepali', 'Two', 10, 45, 2074, 'COMPULSORY'),
(217, 'Sanskrit', 'Two', 50, 30, 2074, 'COMPULSORY'),
(218, 'Science', 'Two', 100, 40, 2074, 'COMPULSORY'),
(219, 'Social Studies', 'Two', 100, 40, 2074, 'COMPULSORY'),
(220, 'Computer', 'Three', 50, 20, 2074, 'OPTIONAL'),
(221, 'English', 'Three', 100, 40, 2074, 'COMPULSORY'),
(222, 'Literature', 'Three', 50, 20, 2074, 'OPTIONAL'),
(223, 'Mathematics', 'Three', 100, 45, 2074, 'COMPULSORY'),
(224, 'Moral Science', 'Three', 100, 40, 2074, 'OPTIONAL'),
(225, 'Nepali', 'Three', 10, 45, 2074, 'COMPULSORY'),
(226, 'Science', 'Three', 100, 40, 2074, 'COMPULSORY'),
(227, 'Social Studies', 'Three', 100, 40, 2074, 'COMPULSORY'),
(230, 'Computer', 'Four', 50, 20, 2074, 'OPTIONAL'),
(231, 'English', 'Four', 100, 40, 2074, 'COMPULSORY'),
(232, 'Literature', 'Four', 50, 20, 2074, 'OPTIONAL'),
(233, 'Mathematics', 'Four', 100, 45, 2074, 'COMPULSORY'),
(234, 'Moral Science', 'Four', 40, 20, 2074, 'OPTIONAL'),
(235, 'Nepali', 'Four', 10, 45, 2074, 'COMPULSORY'),
(236, 'Science', 'Four', 100, 40, 2074, 'COMPULSORY'),
(247, 'Computer', 'One', 50, 20, 2075, 'COMPULSORY'),
(248, 'English', 'One', 100, 40, 2075, 'COMPULSORY'),
(249, 'Literature', 'One', 50, 20, 2075, 'COMPULSORY'),
(250, 'Mathematics', 'One', 100, 40, 2075, 'COMPULSORY'),
(252, 'Nepali', 'One', 100, 40, 2075, 'COMPULSORY'),
(253, 'Science', 'One', 100, 40, 2075, 'COMPULSORY'),
(254, 'Social Studies', 'One', 100, 40, 2075, 'COMPULSORY'),
(255, 'Computer', 'Two', 50, 20, 2075, 'COMPULSORY'),
(256, 'English', 'Two', 100, 40, 2075, 'COMPULSORY'),
(257, 'Literature', 'Two', 50, 20, 2075, 'COMPULSORY'),
(260, 'Nepali', 'Two', 100, 40, 2075, 'COMPULSORY'),
(261, 'Sanskrit', 'Two', 50, 20, 2075, 'COMPULSORY'),
(262, 'Science', 'Two', 100, 40, 2075, 'COMPULSORY'),
(263, 'Social Studies', 'Two', 100, 40, 2075, 'COMPULSORY'),
(264, 'Computer', 'Three', 50, 20, 2075, 'COMPULSORY'),
(265, 'English', 'Three', 100, 40, 2075, 'COMPULSORY'),
(266, 'Literature', 'Three', 50, 20, 2075, 'COMPULSORY'),
(267, 'Mathematics', 'Three', 100, 40, 2075, 'COMPULSORY'),
(269, 'Nepali', 'Three', 100, 40, 2075, 'COMPULSORY'),
(270, 'Science', 'Three', 100, 40, 2075, 'COMPULSORY'),
(271, 'Social Studies', 'Three', 100, 40, 2075, 'COMPULSORY'),
(272, 'Computer', 'Four', 50, 20, 2075, 'COMPULSORY'),
(273, 'English', 'Four', 100, 40, 2075, 'COMPULSORY'),
(274, 'Literature', 'Four', 50, 20, 2075, 'COMPULSORY'),
(275, 'Mathematics', 'Four', 100, 40, 2075, 'COMPULSORY'),
(277, 'Nepali', 'Four', 100, 40, 2075, 'COMPULSORY'),
(278, 'Science', 'Four', 100, 40, 2075, 'COMPULSORY'),
(279, 'Social Studies', 'Four', 100, 40, 2075, 'COMPULSORY'),
(280, 'Computer', 'Five', 50, 20, 2075, 'COMPULSORY'),
(281, 'English', 'Five', 100, 40, 2075, 'COMPULSORY'),
(282, 'Literature', 'Five', 50, 20, 2075, 'COMPULSORY'),
(283, 'Mathematics', 'Five', 100, 40, 2075, 'COMPULSORY'),
(285, 'Nepali', 'Five', 100, 40, 2075, 'COMPULSORY'),
(286, 'Science', 'Five', 100, 40, 2075, 'COMPULSORY'),
(287, 'Social Studies', 'Five', 100, 40, 2075, 'COMPULSORY'),
(288, 'Computer', 'Six', 50, 20, 2075, 'COMPULSORY'),
(289, 'English', 'Six', 100, 40, 2075, 'COMPULSORY'),
(290, 'Literature', 'Six', 50, 20, 2075, 'COMPULSORY'),
(291, 'Mathematics', 'Six', 100, 40, 2075, 'COMPULSORY'),
(293, 'Nepali', 'Six', 100, 40, 2075, 'COMPULSORY'),
(294, 'Science', 'Six', 100, 40, 2075, 'COMPULSORY'),
(295, 'Social Studies', 'Six', 100, 40, 2075, 'COMPULSORY'),
(296, 'Computer', 'Seven', 50, 20, 2075, 'COMPULSORY'),
(297, 'English', 'Seven', 100, 40, 2075, 'COMPULSORY'),
(298, 'Literature', 'Seven', 50, 20, 2075, 'COMPULSORY'),
(299, 'Mathematics', 'Seven', 100, 40, 2075, 'COMPULSORY'),
(301, 'Nepali', 'Seven', 100, 40, 2075, 'COMPULSORY'),
(302, 'Science', 'Seven', 100, 40, 2075, 'COMPULSORY'),
(303, 'Social Studies', 'Seven', 100, 40, 2075, 'COMPULSORY'),
(304, 'Computer', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(305, 'English', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(306, 'Literature', 'Eight', 50, 20, 2075, 'COMPULSORY'),
(307, 'Compulsory Mathematics', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(309, 'Nepali', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(310, 'Science', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(311, 'Social Studies', 'Eight', 100, 40, 2075, 'COMPULSORY'),
(312, 'Computer', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(313, 'English', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(314, 'EPH', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(315, 'Comp. Maths', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(317, 'Nepali', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(318, 'Science', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(319, 'Social Studies', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(320, 'Opt. Maths', 'Nine', 100, 40, 2075, 'COMPULSORY'),
(321, 'Computer', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(322, 'Optional Mathematics', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(323, 'E.P.H.', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(324, 'Social Studies', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(325, 'Science', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(326, 'Compulsory Mathematics', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(327, 'Nepali', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(328, 'English', 'Ten', 100, 40, 2075, 'COMPULSORY'),
(329, 'P.B.T.', 'Eight', 50, 20, 2075, 'COMPULSORY'),
(330, 'Optional Mathematics', 'Eight', 50, 20, 2075, 'COMPULSORY'),
(333, 'P.B.T.', 'Seven', 50, 20, 2075, 'COMPULSORY'),
(334, 'Sanskrit', 'Seven', 50, 20, 2075, 'COMPULSORY'),
(335, 'Chinese', 'Seven', 50, 20, 2075, 'COMPULSORY'),
(337, 'P.B.T.', 'Six', 50, 20, 2075, 'COMPULSORY'),
(338, 'Sanskrit', 'Six', 50, 20, 2075, 'COMPULSORY'),
(341, 'Chinese', 'Six', 50, 20, 2075, 'COMPULSORY'),
(342, 'Sanskrit', 'Five', 50, 20, 2075, 'COMPULSORY'),
(343, 'Chinese', 'Five', 50, 20, 2075, 'COMPULSORY'),
(344, 'Sanskrit', 'Four', 50, 20, 2075, 'COMPULSORY'),
(345, 'Chinese', 'Four', 50, 20, 2075, 'COMPULSORY'),
(346, 'Sanskrit', 'Three', 50, 20, 2075, 'COMPULSORY'),
(348, 'Chinese', 'Three', 50, 20, 2075, 'COMPULSORY'),
(349, 'Mathematics', 'Two', 100, 40, 2075, 'COMPULSORY'),
(350, 'E.P.H.', 'Eight', 50, 20, 2075, 'COMPULSORY');

-- --------------------------------------------------------

--
-- Table structure for table `subject_comment`
--

CREATE TABLE `subject_comment` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `comments` longtext,
  `date` date DEFAULT NULL,
  `student_id` bigint(20) DEFAULT NULL,
  `subject_id` bigint(20) DEFAULT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `is_public` tinyint(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject_evaluation`
--

CREATE TABLE `subject_evaluation` (
  `st_evaluation_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_id` int(11) NOT NULL,
  `evaluation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `exam_id` int(11) NOT NULL,
  `remarks` text,
  `subject_id` int(11) NOT NULL,
  `user_id` varchar(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subject_evaluation_option`
--

CREATE TABLE `subject_evaluation_option` (
  `evaluation_option_id` int(11) NOT NULL,
  `evaluation_option_name` varchar(100) NOT NULL,
  `evaluation_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_evaluation_option`
--

INSERT INTO `subject_evaluation_option` (`evaluation_option_id`, `evaluation_option_name`, `evaluation_type_id`) VALUES
(1, 'Very good', 1),
(2, 'Good, but needs improvement', 1),
(3, 'Needs very hard work', 1),
(4, 'Very good', 2),
(5, 'Good, but needs improvement', 2),
(6, 'Poor base', 2),
(7, 'Efficient', 3),
(8, 'Has some difficulty', 3),
(9, 'Has poor comprehension', 3),
(10, 'Active', 4),
(11, 'Satisfactory', 4),
(12, 'Passive', 4);

-- --------------------------------------------------------

--
-- Table structure for table `subject_evaluation_type`
--

CREATE TABLE `subject_evaluation_type` (
  `evaluation_type_id` int(11) NOT NULL,
  `evaluation_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_evaluation_type`
--

INSERT INTO `subject_evaluation_type` (`evaluation_type_id`, `evaluation_type_name`) VALUES
(1, 'Overall Performance'),
(2, 'Base'),
(3, 'Comprehension'),
(4, 'Participation in class'),
(5, 'overal');

-- --------------------------------------------------------

--
-- Table structure for table `subject_remarks`
--

CREATE TABLE `subject_remarks` (
  `subject_remarks_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `remarks` text NOT NULL,
  `evaluation_date` date NOT NULL,
  `user_id` varchar(36) DEFAULT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_remarks`
--

INSERT INTO `subject_remarks` (`subject_remarks_id`, `student_id`, `remarks`, `evaluation_date`, `user_id`, `subject_id`) VALUES
(1, 184, 'Very good, keep it up.', '2008-07-30', '5', 93),
(2, 184, 'Try to keep up.', '2008-07-30', '5', 92),
(3, 152, 'An excellent student for the most part.', '2009-02-04', '5', 93),
(4, 401, 'dsfa sdf asd f', '2009-05-05', '24', 108);

-- --------------------------------------------------------

--
-- Table structure for table `sub_topic`
--

CREATE TABLE `sub_topic` (
  `sub_topic_id` int(11) NOT NULL,
  `sub_topic_name` varchar(100) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `covered` char(4) DEFAULT 'NO',
  `assigned_session` int(11) DEFAULT NULL,
  `completed_session` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_topic_activity`
--

CREATE TABLE `sub_topic_activity` (
  `sub_topic_activity_id` bigint(20) NOT NULL,
  `sub_topic_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_comment`
--

CREATE TABLE `terminal_comment` (
  `terminal_comment_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `section_id` int(11) NOT NULL,
  `terminal_id` int(11) NOT NULL,
  `comment` text,
  `user_id` varchar(33) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_result`
--

CREATE TABLE `terminal_result` (
  `terminal_result_id` bigint(20) NOT NULL,
  `grade` varchar(32) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `terminal_id` int(11) NOT NULL,
  `terminal_marks` double DEFAULT NULL,
  `full_marks` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `theme_option`
--

CREATE TABLE `theme_option` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `moto` text NOT NULL,
  `logo` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `pbo` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pan` varchar(255) NOT NULL,
  `bill_tax` varchar(10) NOT NULL,
  `tax_id` varchar(255) NOT NULL,
  `scholar_id` varchar(255) NOT NULL,
  `final_upscale_marking` tinyint(1) NOT NULL,
  `assessment_module` int(11) NOT NULL,
  `marksheet_restrict` varchar(255) NOT NULL,
  `marksheet_post` varchar(30) NOT NULL,
  `marksheet_post_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `theme_option`
--

INSERT INTO `theme_option` (`id`, `title`, `moto`, `logo`, `theme`, `email`, `fax`, `tel`, `pbo`, `address`, `pan`, `bill_tax`, `tax_id`, `scholar_id`, `final_upscale_marking`, `assessment_module`, `marksheet_restrict`, `marksheet_post`, `marksheet_post_name`) VALUES
(1, 'Anar', '', 'logo.png', 'blue', 'info@anar.edu.np', '', '01-4821723, 4812920', '', 'Saraswotinagar – 6 ,Kapan.', '300432019', '0.01', '', '', 1, 1, 'Contact Administration For Information.', 'Vice Principal', 'Hari P. Dahal');

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `bus_id` int(11) NOT NULL,
  `bus_name` varchar(50) NOT NULL,
  `bus_route` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`bus_id`, `bus_name`, `bus_route`) VALUES
(13, 'Bus 1', 'Kalanki-Kathmandu'),
(14, 'Bus 2', 'Kirtipur-Kathmandu'),
(15, 'Bus 3', 'Baneshow-Chabahil'),
(16, 'Bus 4', 'Chabahil');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `FNAME` varchar(32) NOT NULL,
  `LNAME` varchar(32) DEFAULT NULL,
  `USER_PASSWORD` varchar(32) NOT NULL,
  `USER_NAME` varchar(32) NOT NULL,
  `ACC_STATUS` enum('ON','OFF') DEFAULT 'ON',
  `VISITS` int(11) DEFAULT NULL,
  `LAST_VISIT` varchar(64) DEFAULT NULL,
  `ROLE_ID` int(11) DEFAULT NULL,
  `PROFILE_ID` int(12) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `FNAME`, `LNAME`, `USER_PASSWORD`, `USER_NAME`, `ACC_STATUS`, `VISITS`, `LAST_VISIT`, `ROLE_ID`, `PROFILE_ID`, `CREATED_AT`) VALUES
(12, 'Lokesh', 'Maharjan', '27fd55c7fb6af0e30a1dc0bedce11972', 'lokeshm', 'ON', 208, '2018-05-10 03:38:25', 1, NULL, '2018-05-06 04:37:02'),
(20, 'Satish', 'Maharjan', '92928c915a9a5964718afd88ce8eaf69', 'satishm', 'ON', 193, '2018-05-16 12:44:08', 1, NULL, '2018-05-06 04:37:02'),
(40, 'satish', 'ma', '0c7540eb7e65b553ec1ba6b20de79608', 'satis', 'ON', 40, '2018-05-02 11:32:04', 2, 11, '2018-05-06 04:37:02'),
(320, 'Subas ', 'Neupane', '3789e7a35364d4d4f6067a13d9abc412', 'subas', 'ON', 20, '2018-05-15 01:57:38', 3, 3, '2018-05-06 04:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `log_date` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `uri` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`log_date`, `ip_address`, `username`, `uri`, `id`) VALUES
('2018-05-16 12:44:08pm', '::1', 'satishm', 'localhost/scratch/pages/home', 1),
('2018-05-16 12:44:13pm', '::1', 'satishm', 'localhost/scratch/pages/profile/student/manage', 2),
('2018-05-16 12:44:22pm', '::1', 'satishm', 'localhost/scratch/pages/profile/student/manage', 3),
('2018-05-16 12:44:32pm', '::1', 'satishm', 'localhost/scratch/pages/home', 4),
('2018-05-16 12:45:35pm', '::1', 'satishm', 'localhost/scratch/pages/reports/class_reports/gender_distribution', 5),
('2018-05-16 02:33:42pm', '::1', 'satishm', 'localhost/scratch/pages/general_content/transportation', 6),
('2018-05-16 02:34:37pm', '::1', 'satishm', 'localhost/scratch/pages/reports/class_reports/gender_distribution', 7),
('2018-05-16 02:34:41pm', '::1', 'satishm', 'localhost/scratch/pages/home', 8),
('2018-05-16 02:34:45pm', '::1', 'satishm', 'localhost/scratch/theme_option/site_info', 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_standards`
--
ALTER TABLE `activity_standards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appraisal`
--
ALTER TABLE `appraisal`
  ADD PRIMARY KEY (`appraisal_id`);

--
-- Indexes for table `appraisal_fields`
--
ALTER TABLE `appraisal_fields`
  ADD PRIMARY KEY (`field_id`),
  ADD KEY `FK_appraisal_fields` (`head_id`);

--
-- Indexes for table `appraisal_grade`
--
ALTER TABLE `appraisal_grade`
  ADD PRIMARY KEY (`grade_name`);

--
-- Indexes for table `appraisal_heads`
--
ALTER TABLE `appraisal_heads`
  ADD PRIMARY KEY (`head_id`);

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`assessment_id`),
  ADD UNIQUE KEY `unique records` (`section_id`,`subject_id`,`numeric_value`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`),
  ADD UNIQUE KEY `batch_name` (`batch_name`),
  ADD KEY `batch_name_2` (`batch_name`);

--
-- Indexes for table `blocked_ip`
--
ALTER TABLE `blocked_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bug`
--
ALTER TABLE `bug`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_stop`
--
ALTER TABLE `bus_stop`
  ADD PRIMARY KEY (`stop_id`),
  ADD KEY `FK_bus_stop` (`type_id`);

--
-- Indexes for table `class_attendance`
--
ALTER TABLE `class_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_days`
--
ALTER TABLE `class_days`
  ADD PRIMARY KEY (`class_days_id`),
  ADD UNIQUE KEY `unique_record` (`subject_id`,`section_id`);

--
-- Indexes for table `class_routine`
--
ALTER TABLE `class_routine`
  ADD PRIMARY KEY (`routing_id`),
  ADD UNIQUE KEY `section_id_2` (`section_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`club_id`);

--
-- Indexes for table `club_type`
--
ALTER TABLE `club_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ct_evaluation_option`
--
ALTER TABLE `ct_evaluation_option`
  ADD PRIMARY KEY (`evaluation_option_id`);

--
-- Indexes for table `ct_evaluation_type`
--
ALTER TABLE `ct_evaluation_type`
  ADD PRIMARY KEY (`evaluation_type_id`);

--
-- Indexes for table `ct_parent_evaluation_option`
--
ALTER TABLE `ct_parent_evaluation_option`
  ADD PRIMARY KEY (`evaluation_option_id`);

--
-- Indexes for table `ct_parent_evaluation_type`
--
ALTER TABLE `ct_parent_evaluation_type`
  ADD PRIMARY KEY (`evaluation_type_id`);

--
-- Indexes for table `ct_parent_remarks`
--
ALTER TABLE `ct_parent_remarks`
  ADD PRIMARY KEY (`ct_parent_remarks_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`),
  ADD KEY `FK_department` (`head_id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `FK_doctor` (`student_id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD PRIMARY KEY (`employee_leave_id`),
  ADD KEY `FK_employee_leave` (`employee_id`);

--
-- Indexes for table `employee_type`
--
ALTER TABLE `employee_type`
  ADD PRIMARY KEY (`employee_type_id`);

--
-- Indexes for table `evaluation_option`
--
ALTER TABLE `evaluation_option`
  ADD PRIMARY KEY (`evaluation_option_id`);

--
-- Indexes for table `evaluation_type`
--
ALTER TABLE `evaluation_type`
  ADD PRIMARY KEY (`evaluation_type_id`);

--
-- Indexes for table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`exam_id`),
  ADD UNIQUE KEY `unique_record` (`section_id`,`subject_id`,`numeric_value`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `exam_grades`
--
ALTER TABLE `exam_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty_comment`
--
ALTER TABLE `faculty_comment`
  ADD PRIMARY KEY (`fac_cmt_id`);

--
-- Indexes for table `final_result`
--
ALTER TABLE `final_result`
  ADD PRIMARY KEY (`final_result_id`),
  ADD UNIQUE KEY `unique_records` (`class_days_id`,`student_id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `grade_name` (`grade_name`);

--
-- Indexes for table `house`
--
ALTER TABLE `house`
  ADD PRIMARY KEY (`house_id`);

--
-- Indexes for table `illness`
--
ALTER TABLE `illness`
  ADD PRIMARY KEY (`illness_id`);

--
-- Indexes for table `lession_plan`
--
ALTER TABLE `lession_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_days_id` (`class_days_id`);

--
-- Indexes for table `lesson_activity`
--
ALTER TABLE `lesson_activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `marksheet_restrict`
--
ALTER TABLE `marksheet_restrict`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `occupation`
--
ALTER TABLE `occupation`
  ADD PRIMARY KEY (`occupation_id`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`org_id`);

--
-- Indexes for table `parentfeedback`
--
ALTER TABLE `parentfeedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `parent_evaluation`
--
ALTER TABLE `parent_evaluation`
  ADD PRIMARY KEY (`parent_evaluation_id`),
  ADD KEY `FK_parent_evaluation_student` (`student_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ROLE_ID`),
  ADD UNIQUE KEY `UNQ_ROLES` (`ROLE_NAME`);

--
-- Indexes for table `scholarship`
--
ALTER TABLE `scholarship`
  ADD PRIMARY KEY (`scholarship_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD UNIQUE KEY `uniqueSection` (`batch`,`grade`,`section_name`),
  ADD KEY `batch` (`batch`),
  ADD KEY `grade` (`grade`),
  ADD KEY `class_teacher_id` (`class_teacher_id`);

--
-- Indexes for table `sibling`
--
ALTER TABLE `sibling`
  ADD PRIMARY KEY (`sibling_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_achievement`
--
ALTER TABLE `student_achievement`
  ADD PRIMARY KEY (`st_achievement_id`);

--
-- Indexes for table `student_allergy`
--
ALTER TABLE `student_allergy`
  ADD PRIMARY KEY (`st_allergy_id`),
  ADD KEY `FK_student_allergy_student` (`student_id`);

--
-- Indexes for table `student_category`
--
ALTER TABLE `student_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `student_club`
--
ALTER TABLE `student_club`
  ADD PRIMARY KEY (`st_club_id`,`active`);

--
-- Indexes for table `student_condition`
--
ALTER TABLE `student_condition`
  ADD PRIMARY KEY (`st_condition_id`);

--
-- Indexes for table `student_designation`
--
ALTER TABLE `student_designation`
  ADD PRIMARY KEY (`st_designation_id`);

--
-- Indexes for table `student_evaluation`
--
ALTER TABLE `student_evaluation`
  ADD PRIMARY KEY (`st_evaluation_id`);

--
-- Indexes for table `student_game`
--
ALTER TABLE `student_game`
  ADD PRIMARY KEY (`st_game_id`);

--
-- Indexes for table `student_hobby`
--
ALTER TABLE `student_hobby`
  ADD PRIMARY KEY (`st_hobby_id`);

--
-- Indexes for table `student_medical`
--
ALTER TABLE `student_medical`
  ADD PRIMARY KEY (`st_illness_id`);

--
-- Indexes for table `student_medication`
--
ALTER TABLE `student_medication`
  ADD PRIMARY KEY (`st_medication_id`);

--
-- Indexes for table `student_optional`
--
ALTER TABLE `student_optional`
  ADD PRIMARY KEY (`st_opt_id`);

--
-- Indexes for table `student_status`
--
ALTER TABLE `student_status`
  ADD PRIMARY KEY (`student_status_id`);

--
-- Indexes for table `student_summary`
--
ALTER TABLE `student_summary`
  ADD PRIMARY KEY (`summary_id`);

--
-- Indexes for table `st_comment`
--
ALTER TABLE `st_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `st_marks`
--
ALTER TABLE `st_marks`
  ADD PRIMARY KEY (`stmarks_id`),
  ADD UNIQUE KEY `unique_row` (`student_id`,`subject_id`,`exam_id`) USING BTREE,
  ADD KEY `FK_st_marks_student` (`student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `unique_records` (`grade`,`added_batch`,`subject_name`);

--
-- Indexes for table `subject_comment`
--
ALTER TABLE `subject_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `subject_evaluation`
--
ALTER TABLE `subject_evaluation`
  ADD PRIMARY KEY (`st_evaluation_id`);

--
-- Indexes for table `subject_evaluation_option`
--
ALTER TABLE `subject_evaluation_option`
  ADD PRIMARY KEY (`evaluation_option_id`);

--
-- Indexes for table `subject_evaluation_type`
--
ALTER TABLE `subject_evaluation_type`
  ADD PRIMARY KEY (`evaluation_type_id`);

--
-- Indexes for table `subject_remarks`
--
ALTER TABLE `subject_remarks`
  ADD PRIMARY KEY (`subject_remarks_id`);

--
-- Indexes for table `sub_topic`
--
ALTER TABLE `sub_topic`
  ADD PRIMARY KEY (`sub_topic_id`);

--
-- Indexes for table `sub_topic_activity`
--
ALTER TABLE `sub_topic_activity`
  ADD PRIMARY KEY (`sub_topic_activity_id`);

--
-- Indexes for table `terminal_comment`
--
ALTER TABLE `terminal_comment`
  ADD PRIMARY KEY (`terminal_comment_id`),
  ADD KEY `FK_terminal_comment_student` (`student_id`);

--
-- Indexes for table `terminal_result`
--
ALTER TABLE `terminal_result`
  ADD PRIMARY KEY (`terminal_result_id`),
  ADD UNIQUE KEY `unique records` (`grade`,`student_id`,`terminal_id`);

--
-- Indexes for table `theme_option`
--
ALTER TABLE `theme_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`bus_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`),
  ADD UNIQUE KEY `USER_NAME` (`USER_NAME`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_standards`
--
ALTER TABLE `activity_standards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `appraisal`
--
ALTER TABLE `appraisal`
  MODIFY `appraisal_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `appraisal_fields`
--
ALTER TABLE `appraisal_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `appraisal_heads`
--
ALTER TABLE `appraisal_heads`
  MODIFY `head_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `assessment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `batch`
--
ALTER TABLE `batch`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `blocked_ip`
--
ALTER TABLE `blocked_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bug`
--
ALTER TABLE `bug`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bus_stop`
--
ALTER TABLE `bus_stop`
  MODIFY `stop_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_attendance`
--
ALTER TABLE `class_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_days`
--
ALTER TABLE `class_days`
  MODIFY `class_days_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_routine`
--
ALTER TABLE `class_routine`
  MODIFY `routing_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `club_type`
--
ALTER TABLE `club_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ct_evaluation_option`
--
ALTER TABLE `ct_evaluation_option`
  MODIFY `evaluation_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `ct_evaluation_type`
--
ALTER TABLE `ct_evaluation_type`
  MODIFY `evaluation_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ct_parent_evaluation_option`
--
ALTER TABLE `ct_parent_evaluation_option`
  MODIFY `evaluation_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `ct_parent_evaluation_type`
--
ALTER TABLE `ct_parent_evaluation_type`
  MODIFY `evaluation_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ct_parent_remarks`
--
ALTER TABLE `ct_parent_remarks`
  MODIFY `ct_parent_remarks_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `district_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `employee_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_leave`
--
ALTER TABLE `employee_leave`
  MODIFY `employee_leave_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_type`
--
ALTER TABLE `employee_type`
  MODIFY `employee_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `evaluation_option`
--
ALTER TABLE `evaluation_option`
  MODIFY `evaluation_option_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `evaluation_type`
--
ALTER TABLE `evaluation_type`
  MODIFY `evaluation_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exam`
--
ALTER TABLE `exam`
  MODIFY `exam_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `exam_grades`
--
ALTER TABLE `exam_grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `faculty_comment`
--
ALTER TABLE `faculty_comment`
  MODIFY `fac_cmt_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `final_result`
--
ALTER TABLE `final_result`
  MODIFY `final_result_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `house`
--
ALTER TABLE `house`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `illness`
--
ALTER TABLE `illness`
  MODIFY `illness_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lession_plan`
--
ALTER TABLE `lession_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lesson_activity`
--
ALTER TABLE `lesson_activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `marksheet_restrict`
--
ALTER TABLE `marksheet_restrict`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `menu_links`
--
ALTER TABLE `menu_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `occupation`
--
ALTER TABLE `occupation`
  MODIFY `occupation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;
--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `org_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `parentfeedback`
--
ALTER TABLE `parentfeedback`
  MODIFY `feedback_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parent_evaluation`
--
ALTER TABLE `parent_evaluation`
  MODIFY `parent_evaluation_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `ROLE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `scholarship`
--
ALTER TABLE `scholarship`
  MODIFY `scholarship_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sibling`
--
ALTER TABLE `sibling`
  MODIFY `sibling_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_achievement`
--
ALTER TABLE `student_achievement`
  MODIFY `st_achievement_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `student_allergy`
--
ALTER TABLE `student_allergy`
  MODIFY `st_allergy_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_category`
--
ALTER TABLE `student_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `student_club`
--
ALTER TABLE `student_club`
  MODIFY `st_club_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `student_condition`
--
ALTER TABLE `student_condition`
  MODIFY `st_condition_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_designation`
--
ALTER TABLE `student_designation`
  MODIFY `st_designation_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_evaluation`
--
ALTER TABLE `student_evaluation`
  MODIFY `st_evaluation_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_game`
--
ALTER TABLE `student_game`
  MODIFY `st_game_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_hobby`
--
ALTER TABLE `student_hobby`
  MODIFY `st_hobby_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_medical`
--
ALTER TABLE `student_medical`
  MODIFY `st_illness_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_medication`
--
ALTER TABLE `student_medication`
  MODIFY `st_medication_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_optional`
--
ALTER TABLE `student_optional`
  MODIFY `st_opt_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_status`
--
ALTER TABLE `student_status`
  MODIFY `student_status_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_summary`
--
ALTER TABLE `student_summary`
  MODIFY `summary_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `st_comment`
--
ALTER TABLE `st_comment`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `st_marks`
--
ALTER TABLE `st_marks`
  MODIFY `stmarks_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;
--
-- AUTO_INCREMENT for table `subject_comment`
--
ALTER TABLE `subject_comment`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject_evaluation`
--
ALTER TABLE `subject_evaluation`
  MODIFY `st_evaluation_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject_evaluation_option`
--
ALTER TABLE `subject_evaluation_option`
  MODIFY `evaluation_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `subject_evaluation_type`
--
ALTER TABLE `subject_evaluation_type`
  MODIFY `evaluation_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `subject_remarks`
--
ALTER TABLE `subject_remarks`
  MODIFY `subject_remarks_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `sub_topic`
--
ALTER TABLE `sub_topic`
  MODIFY `sub_topic_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sub_topic_activity`
--
ALTER TABLE `sub_topic_activity`
  MODIFY `sub_topic_activity_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terminal_comment`
--
ALTER TABLE `terminal_comment`
  MODIFY `terminal_comment_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terminal_result`
--
ALTER TABLE `terminal_result`
  MODIFY `terminal_result_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `theme_option`
--
ALTER TABLE `theme_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `bus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;
--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appraisal_fields`
--
ALTER TABLE `appraisal_fields`
  ADD CONSTRAINT `FK_appraisal_fields` FOREIGN KEY (`head_id`) REFERENCES `appraisal_heads` (`head_id`) ON DELETE CASCADE;

--
-- Constraints for table `bus_stop`
--
ALTER TABLE `bus_stop`
  ADD CONSTRAINT `FK_bus_stop` FOREIGN KEY (`type_id`) REFERENCES `item_type` (`type_id`) ON DELETE SET NULL;

--
-- Constraints for table `class_routine`
--
ALTER TABLE `class_routine`
  ADD CONSTRAINT `class_routine_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `FK_department` FOREIGN KEY (`head_id`) REFERENCES `employee` (`employee_id`) ON DELETE SET NULL;

--
-- Constraints for table `employee_leave`
--
ALTER TABLE `employee_leave`
  ADD CONSTRAINT `FK_employee_leave` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
