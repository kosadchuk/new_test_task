'use strict';

$(document).ready(function() {
	let selectForm = $('#selectForm');
	let selectElems = $('.selectItem');

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

	selectElems.on('change', function() {
		$.ajax({type: 'GET', url: 'select_form.php',
				data: {
					action: this.id,
					value: this.value
				},
				success: function (response) {
					let data = JSON.parse(response);
					if (data['error']) {
						alert(data['error']);
					} else {
						$.each(data, function(key, value) {
							$('#'+key+'').html('');
							appendOptions(value, $('#'+key+''));
						});
					}
				},
				error: function () {
					alert('Error');
				}
		});
	});

	function appendOptions(data, elem) {
		$.each(data, function(key, value) {
			elem.append($('<option>', {value: key, text: value}));
		});
	}
});