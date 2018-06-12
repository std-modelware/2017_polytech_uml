<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/11/18
 * Time: 11:16 PM
 */

include_once 'classes/database.php';
include_once 'classes/utils.php';
include_once 'classes/logger.php';
include_once 'classes/administrator.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

$logfile = "log.txt";
$logger = new Logger($logfile);
$logger->log("req", json_encode($input));

$database = new Database('localhost', 'core','root', 'password');
$db = $database->getConnection();

$utils = new Utils($db);
$utils->fillRoles(array('administrator', 'student', 'teacher'));

$admin = new Administrator($utils);

if ($request[0] == 'dean' && $request[1] == 'admin') {
	switch ($request[2]) {
	    case 'add_discipline':
		$info = $admin->addDiscipline($input['name']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);		
		#$utils->printTable('disciplines');
		break;

	    case 'add_group':
		$info = $admin->addGroup($input['name'], $input['start_date']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);
		#$utils->printTable('groups');
		break;

	    case 'make_curriculum':
		$info = $admin->makeCurriculum($input['name'], $input['semesters'], $input['discipline_ids']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);
		#$utils->printCurriculum(1);
		break;

	    case 'link_group_curriculum':
		$info = $admin->linkGroupAndCur($input['group_id'], $input['curriculum_id']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);
		#$utils->printTable('groups_curriculums');
		break;

	    case 'add_student':
		$info = $admin->addStudent($input['name'], $input['group_id']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);	
		#echo 'TABLE ACCOUNTS<br>';
		#$utils->printTable('accounts');
		#echo '<br>TABLE STUDENTS<br>';
		#$utils->printTable('students');
		break;

	    case 'add_teacher':
		$info = $admin->addTeacher($input['name'], $input['discipline_ids']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);
		#echo 'TABLE ACCOUNTS<br>';
		#$utils->printTable('accounts');
		#echo '<br>TABLE TEACHERS<br>';
		#$utils->printTable('teachers');
		#echo '<br>TABLE DISCIPLINES_TEACHERS<br>';
		#$utils->printTable('disciplines_teachers');
		break;

	    case 'link_group_disc_teach':
		$info = $admin->linkGroupDiscpAndTeacher($input['group_id'], $input['discipline_id'], $input['teacher_id']);
		$json = $utils->sendResponse($info);
		$logger->log("res", $json);
		#$utils->printTable('currentdeals');
		break;
	}
}

?>
