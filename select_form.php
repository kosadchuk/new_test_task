<?php

require_once 'Db_Class.php';

$db = new Db();
$centers = [];

$stmt = $db->dbExecute("SELECT * FROM cc_callcenters");
$centers = getResultArray('id', 'name', $stmt);

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$func = 'action'.$_GET['action'];
	if (function_exists($func)) {
		echo json_encode($func($_GET['value']));
	} else {
		echo json_encode(array('error' => 'Failed connection with Db'));
	}
}

function actionCallCenter($centerId) {
	$stmt = getStmt('cc_desks', 'id_callcenter', $centerId);
	$result['desk'] = getResultArray('id', 'desk_name', $stmt);
	$res = array_merge($result, actionDesk(array_key_first($result['desk'])));
	return $res;
}

function actionDesk($deskId) {
	$stmt = getStmt('cc_teams', 'id_desk', $deskId);
	$result['team'] = getResultArray('id', 'team_name', $stmt);
	$res = array_merge($result, actionTeam(array_key_first($result['team'])));
	return $res;
}

function actionTeam($teamId) {
	$stmt = getStmt('cc_users', 'team_id', $teamId);
	$res['sales'] = getResultArray('user_id', 'stage_name', $stmt);
	return $res;
}

function getStmt($table, $param, $id) {
	global $db;
	$sql = 'SELECT * FROM '.$table.' WHERE '.$param.' = :'.$param.'';
	$stmt = $db->dbExecute($sql, array(':'.$param.'' => $id));
	return $stmt;
}

function getResultArray($id, $name, $stmt) {
	$array = [];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$array[$row[$id]] = $row[$name];
	}
	return $array;
}
