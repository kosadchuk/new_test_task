<?php require_once 'select_form.php' ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"
	        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	        crossorigin="anonymous"></script>
	<script src="ajax.js"></script>
	<title>Document</title>
</head>
<body>
	<form action="select_form.php" method="post" id="selectForm">
		<label>Center:
			<select id="callCenter" name="callCenter">
					<option disabled selected>Choose call center</option>
					<?php foreach($centers as $key => $center): ?>
						<option value="<?= $key ?>"><?= $center; ?></option>
					<?php endforeach; ?>
			</select>
		</label><br/>
		<label>Desk:
			<select id="desk" name="desk"></select>
		</label><br/>
		<label>Team:
			<select id="team" name="team"></select>
		</label><br/>
		<label>Sales:
			<select id="sales" name="user"></select>
		</label><br/>
		<input type="submit" value="Save" name="submit">
	</form>
</body>
</html>