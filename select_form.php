<?php

require_once 'Db_Class.php';

$db = new Db();
$centers = [];

$stmt = $db->dbExecute("SELECT * FROM cc_callcenters");
$centers = getResultArray('id', 'name', $stmt);


if (isset($_GET['action']) && !empty($_GET['action'])) {
	switch($_GET['action']) {
		case('getDesk'):
			echo json_encode(getDesk($_GET['id']));
			break;
		case('getTeam'):
			echo json_encode(getTeam($_GET['id']));
			break;
		case('getSales'):
			echo json_encode(getTeam($_GET['id']));
			break;
		default:
			echo json_encode(array('error' => 'Fail connection with Db'));
	}
}

function getDesk($centerId) {
	global $db;

	$sql = "SELECT * FROM cc_desks WHERE id_callcenter = :id_center";
	$stmt = $db->dbExecute($sql, array(':id_center' => $centerId));

	$result['desks'] = getResultArray('id', 'desk_name', $stmt);

	$res = array_merge($result, getTeam(array_key_first($result['desks'])));
	return $res;
}

function getTeam($deskId) {
	global $db;

	$sql = "SELECT * FROM cc_teams WHERE id_desk = :id_desk";
	$stmt = $db->dbExecute($sql, array(':id_desk' => $deskId));

	$result['teams'] = getResultArray('id', 'team_name', $stmt);
	$result['sales'] = getSales(array_key_first($result['teams']));
	return $result;
}

function getSales($teamId) {
	global $db;

	$sql = "SELECT * FROM cc_users WHERE team_id = :team_id";
	$stmt = $db->dbExecute($sql, array(':team_id' => $teamId));

	$result = getResultArray('user_id', 'stage_name', $stmt);
	return $result;
}

function getResultArray($id, $name, $stmt) {
	$array = [];

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$array[$row[$id]] = $row[$name];
	}
	return $array;
}
