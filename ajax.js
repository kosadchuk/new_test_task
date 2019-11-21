'use strict';

$(document).ready(function() {
	let selectForm = $('#selectForm');

	$('select').css("width", "150px");

	selectForm.submit(function(e) {
		e.preventDefault();

		$.ajax({type: 'post', url: 'save_data.php',
				data: $(this).serialize(),
			success: function (response) {
				console.log(response);
			},
			error: function() {
				alert("Error");
			}
		});
	});

	$('#callCenter').change(function() {

		$('#desk').html('');
		$('#team').html('');
		$('#sales').html('');

		$.ajax({type: 'GET', url: 'select_form.php',
				data: {
					action: 'getDesk',
					id: $('#callCenter').val()
			},
			success: function (response) {
				let data = JSON.parse(response);
				appendOptions(data['desks'], $('#desk'));
				appendOptions(data['teams'], $('#team'));
				appendOptions(data['sales'], $('#sales'));
			},
			error: function() {
				alert("Error");
			}
		});
	});

	$('#desk').change(function() {

		$('#team').html('');
		$('#sales').html('');

		$.ajax({type: 'GET', url: 'select_form.php',
				data: {
					action: 'getTeam',
					id: $('#desk').val()
			},
			success: function (response) {
				let data = JSON.parse(response);
				appendOptions(data['teams'], $('#team'));
				appendOptions(data['sales'], $('#sales'));
			},
			error: function() {
				alert("Error");
			}
		});
	});

	$('#team').change(function() {

		$('#sales').html('');

		$.ajax({type: 'GET', url: 'select_form.php',
				data: {
					action: 'getSales',
					id: $('#team').val()
			},
			success: function (response) {
				let data = JSON.parse(response);
				appendOptions(data['sales'], $('#sales'));
			},
			error: function() {
				alert("Error");
			}
		});
	});

	function appendOptions(data, elem) {
		$.each(data, function(key, value) {
			elem.append($('<option>', {value: key, text: value}));
		});
	}

});