<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/12/18
 * Time: 6:59 AM
 */

class Utils {

	private $conn;
	private $goodinfo;

	public function __construct($conn) {
		$this->conn = $conn;
		$this->goodinfo = array('00000', null, null);
	}

	public function execStatement($query, $params) {
		$stmt = $this->conn->prepare($query);
		$stmt->execute($params);
		return $stmt;
	}

	public function checkIdsInTable($table, $ids) {
		if (gettype($ids) != 'array') {
			$ids = array($ids);
		}
		foreach ($ids as $id) {
			$stmt = $this->execStatement('SELECT id FROM ' . $table . ' WHERE id = ?', array($id));
			if ($stmt->errorInfo()[0] != '00000') {
				return false;
			}
			$res = $stmt->fetchAll(PDO::FETCH_NUM);
			if (count($res[0]) == 0) {
				return false;
			}
		}
		return true;
	}

	public function sendResponse($info) {
		if ($info[0] == '00000') {
			$res = array('result_code' => 0);
		} else {
			$res = array('result_code' => $info[1] . ' (' . $info[0] . ')', 'message' => $info[2]);
		}	
		$json = json_encode($res);
		header('Content-Type: application/json');
		echo $json;
		return $json;
	}

	private function table($arr) {
		$keys = array_keys($arr[0]);
		echo '<table><tr>';
		foreach ($keys as $k) {
			echo '<th>' . $k . '</th>';
		}
		echo '</tr>';
		foreach ($arr as $row) {
			echo '<tr>';
			foreach ($row as $e) {
				echo '<td>' . $e . '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
	}

	public function printTable($name){
		$stmt = $this->execStatement('SELECT * FROM ' . $name, array());
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->table($res);
	}

	public function printCurriculum($id) {
		$stmt = $this->execStatement('SELECT curriculums.name AS "cur", semesters.name AS "sem", disciplines.name AS "disc"
		FROM semesters_disciplines
		JOIN semesters ON semesters_disciplines.semesters_id = semesters.id
		JOIN curriculums_semesters on semesters_disciplines.semesters_id = curriculums_semesters.semesters_id
		JOIN curriculums on curriculums_semesters.curriculums_id = curriculums.id
		JOIN disciplines ON semesters_disciplines.disciplines_id = disciplines.id
		WHERE curriculums.id = ?', array($id));
		$res= $stmt->fetchAll(PDO::FETCH_ASSOC);
		$this->table($res);
	}

	public function fillRoles($roles){
		foreach ($roles as $role) {
			$this->execStatement('INSERT INTO roles(role) VALUES (?)', array($role));
		}
	}
}
?>
