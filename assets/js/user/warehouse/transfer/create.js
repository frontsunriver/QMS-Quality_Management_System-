function onChangeType(type) {
	if (type == 'material')
		$('#good_label').text('Material:');
	
	if (type == 'product')
		$('#good_label').text('Product:');

	$.post(base_url + 'common/' + type + '/all', {}, function(resp){
		$('#good_select').html('');
		for (var i = 0; i < resp.length; i ++)
			$('#good_select').append('<option value="' + resp[i].id + '">' + resp[i].name + '</option>');
	});
}

function onChangeGood(good_id) {
	
}