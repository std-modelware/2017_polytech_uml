<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/12/18
 * Time: 12:10 AM
 */

class Administrator {

	private $utils;
	private $goodinfo;

	public function __construct($utils){
		$this->utils = $utils;
		$this->goodinfo = array('00000', null, null);
	}

	public function addDiscipline($name){
		$stmt = $this->utils->execStatement('INSERT INTO disciplines(name) VALUES (?)', array($name));
		return $stmt->errorInfo();
	}

	public function addGroup($number, $start_date){
		$stmt = $this->utils->execStatement('INSERT INTO groups(number, start_date) VALUES (?, ?)', array($number, $start_date));
		return $stmt->errorInfo();	
	}

	private function addSemesters($names){
		$ids = array();
		foreach ($names as $name){
			$stmt = $this->utils->execStatement('INSERT INTO semesters(name) VALUES (?)', array($name));
			if ($stmt->errorInfo()[0] != '00000') {
				return array($stmt->errorInfo());
			}

			$stmt = $this->utils->execStatement('SELECT id FROM semesters WHERE name = ?', array($name));
			if ($stmt->errorInfo()[0] != '00000') {
				return array($stmt->errorInfo());
			}

			$res = $stmt->fetchAll(PDO::FETCH_NUM);
			$ids[] = intval($res[0][0]);
		}		
		return array($this->goodinfo, array_combine($names, $ids));
	}

	private function linkSemAndDisc($semId, $discId){
		$stmt = $this->utils->execStatement('INSERT INTO semesters_disciplines(semesters_id, disciplines_id) VALUES (?, ?)', array($semId, $discId));
		return $stmt->errorInfo();	
	}

	private function linkCurAndSem($curId, $semId){
		$stmt = $this->utils->execStatement('INSERT INTO curriculums_semesters(curriculums_id, semesters_id) VALUES (?, ?)', array($curId, $semId));
		return $stmt->errorInfo();	
	}

	public function makeCurriculum($name, $sems, $discIds) {
		$table = "disciplines";		
		$info = $this->utils->checkIdsInTable($table, $discIds);
		if (!$info) {
			return array('23000', '1452', 'There are not all ids in ' . $table);
		} else {
			$stmt = $this->utils->execStatement('INSERT INTO curriculums(name) VALUES (?)', array($name));
			if ($stmt->errorInfo()[0] != '00000') {
				return $stmt->errorInfo();
			}

			$stmt = $this->utils->execStatement('SELECT id FROM curriculums WHERE name = ?', array($name));
			if ($stmt->errorInfo()[0] != '00000') {
				return $stmt->errorInfo();
			}

			$res = $stmt->fetchAll(PDO::FETCH_NUM);
			$id = intval($res[0][0]);

			$semNames = array();
			foreach ($sems as $sem) {
				$semNames[] = $name . '_sem_' . $sem;
			}

			$tmp = $this->addSemesters(array_unique($semNames));
			if ($tmp[0][0] != '00000') {
				return $tmp[0];
			} else {
				$uniqueSems = $tmp[1];
				foreach ($uniqueSems as $semId) {
					$info = $this->linkCurAndSem($id, $semId);
					if ($info[0] != '00000') {
						return $info;
					}
				}

				$semIds = $semNames;
				foreach ($semIds as $key => $value) {
					if (isset($uniqueSems[$value])) {
						$semIds[$key] = $uniqueSems[$value];
					}
				}
				for ($i = 0; $i < count($semIds); $i++) {
					$info = $this->linkSemAndDisc($semIds[$i], $discIds[$i]);
					if ($info[0] != '00000') {
						return $info;
					}
				}

				return $this->goodinfo;
			}
		}
	}

	public function linkGroupAndCur($groupId, $curId) {
		$stmt = $this->utils->execStatement('INSERT INTO groups_curriculums(groups_id, curriculums_id) VALUES (?, ?)', array($groupId, $curId));
		return $stmt->errorInfo();
	}

	private function addAccount($type) {
		$stmt = $this->utils->execStatement('SELECT id FROM roles WHERE role = ?', array($type));
		if ($stmt->errorInfo()[0] != '00000') {
			return array($stmt->errorInfo());
		}

		$res = $stmt->fetchAll(PDO::FETCH_NUM);
		$roleId = intval($res[0][0]);

		$stmt = $this->utils->execStatement('SELECT login FROM accounts WHERE role_id = ?', array($roleId));
		if ($stmt->errorInfo()[0] != '00000') {
			return array($stmt->errorInfo());
		}

		$res= $stmt->fetchAll(PDO::FETCH_NUM);
		if (count($res) == 0) {
			$num = 1;
		} else {
			$num = count($res) + 1;
		}

		$login = $type . $num;
		$options = [
		    'cost' => 12,
		];
		$pass = password_hash($login, PASSWORD_BCRYPT, $options);

		$stmt = $this->utils->execStatement('INSERT INTO accounts(login, password, role_id) VALUES (?, ?, ?)', array($login, $pass, $roleId));
		if ($stmt->errorInfo()[0] != '00000') {
			return array($stmt->errorInfo());
		}

		$stmt = $this->utils->execStatement('SELECT id FROM accounts WHERE login = ?', array($login));
		if ($stmt->errorInfo()[0] != '00000') {
			return array($stmt->errorInfo());
		}

		$res= $stmt->fetchAll(PDO::FETCH_NUM);
		$accId = intval($res[0][0]);

		return array($this->goodinfo, $accId);
	}

	public function addStudent($name, $groupId) {
		$table = "groups";		
		$info = $this->utils->checkIdsInTable($table, $groupId);
		if (!$info) {
			return array('23000', '1452', 'There are not all ids in ' . $table);
		} else {
			$tmp = $this->addAccount('student');
			if ($tmp[0][0] != '00000') {
				return $tmp[0];
			} else {
				$accId = $tmp[1];
				$stmt = $this->utils->execStatement('INSERT INTO students(name, groups_id, accounts_id) VALUES (?, ?, ?)', array($name, $groupId, $accId));
				return $stmt->errorInfo();
			}
		}
	}

	public function addTeacher($name, $discIds) {
		$table = "disciplines";		
		$info = $this->utils->checkIdsInTable($table, $discIds);
		if (!$info) {
			return array('23000', '1452', 'There are not all ids in ' . $table);
		} else {
			$tmp = $this->addAccount('teacher');
			if ($tmp[0][0] != '00000') {
				return $tmp[0];
			} else {
				$accId = $tmp[1];
				$stmt = $this->utils->execStatement('INSERT INTO teachers(name, accounts_id) VALUES (?, ?)', array($name, $accId));
				if ($stmt->errorInfo()[0] != '00000') {
					return $stmt->errorInfo();
				}

				$stmt = $this->utils->execStatement('SELECT id FROM teachers WHERE accounts_id = ?', array($accId));
				if ($stmt->errorInfo()[0] != '00000') {
					return $stmt->errorInfo();
				}

				$res= $stmt->fetchAll(PDO::FETCH_NUM);
				$teachId = intval($res[0][0]);

				foreach ($discIds as $id) {
					$stmt = $this->utils->execStatement('INSERT INTO disciplines_teachers(disciplines_id, teachers_id) VALUES (?, ?)', array($id, $teachId));
					if ($stmt->errorInfo()[0] != '00000') {
						return $stmt->errorInfo();
					}
				}

				return $this->goodinfo;
			}
		}
	}

	public function  linkGroupDiscpAndTeacher($groupId, $discId, $teachId) {
		$stmt = $this->utils->execStatement('INSERT INTO currentdeals(groups_id, disciplines_id, teachers_id) VALUES (?, ?, ?)', array($groupId, $discId, $teachId));
		return $stmt->errorInfo();
	}

}
