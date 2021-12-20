$(function(){
	$('[data-plugin-selectTwo]').each(function() {
		var $this = $( this ),
			opts = {};

		var pluginOptions = $this.data('plugin-options');
		if (pluginOptions)
			opts = pluginOptions;

		$this.themePluginSelect2(opts);
	});

	CKEDITOR.replace('note', {
		"height":100,
		"language":'en',
		"toolbarGroups":[{
			"name":"forms"
		}, {
			"name":"editing",
			"groups":["find","selection","spellchecker"]
		}, {
			"name":"basicstyles",
			"groups":["basicstyles","colors","cleanup"]
		}, {
			"name":"paragraph",
			"groups":["list","indent","blocks","align","bidi"]
		}, {
			"name":"styles"
		}, {
			"name":"colors"
		}],
		"extraPlugins":"colorbutton,font,colordialog"
	});
	dosamigos.ckEditorWidget.registerOnChangeHandler('note');

	$('#create_form').validate({
		ignore: 'input[type=hidden]',
		errorClass: 'validation-error-label',
		successClass: 'validation-valid-label',
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		},
		unhighlight: function(element, errorClass) {
			$(element).removeClass(errorClass);
		},
		validClass: "validation-valid-label",
		rules: {
			'create[title]': { required: true },
			'create[norm]': { required: true },
			'create[norm_unit]': { required: true },
			'create[tolerance_from]': { required: true },
			'create[tolerance_to]': { required: true }
		}
	});

	onChangeTestType();

	onRefreshFrequency();
});

function onCreate() {
	$('#create_form').submit();
}

function onChangeProduct(product_id) {
	$.post(base_url + 'manufacture/qualitycheck/variants/' + product_id, {}, function(resp){
		$('#variant').html('');

		for (var i = 0; i < resp.length; i ++)
			$('#variant').append('<option value="' + resp[i] + '"' + '>' + resp[i] + '</option>');
	});
}

function onChangeTestType() {
	var value = $('#test_type').val();
	
	switch (value) {
	case '1':
		$('#measure_norm').addClass('hidden');
		$('#measure_tolerance').addClass('hidden');
		$('#measure_norm input').prop('disabled', true);
		$('#measure_norm select').prop('disabled', true);
		$('#measure_tolerance input').prop('disabled', true);
		break;
	case '2':
		$('#measure_norm').removeClass('hidden');
		$('#measure_tolerance').removeClass('hidden');
		$('#measure_norm input').prop('disabled', false);
		$('#measure_norm select').prop('disabled', false);
		$('#measure_tolerance input').prop('disabled', false);
		break;
	}
}

function onAddFrequency() {
	var new_frequency = $('#new_frequency').val();
	var new_day = $('#new_day').val();

	if (new_frequency.length == 0 )
		$('#frequency_err').html('* this field is required');
	else if (new_day < 1)
		$('#day_err').html('* this field is incorrect');
	else {
		$.post({
			url: base_url + 'manufacture/frequency/add',
			data: {
				'frequency_name': new_frequency,
				'days': new_day,
				'type': $('#frequency_type').val()
			},
			success: function(resp) {
				// $('#frequency').html(data);
				if (resp.success) {
					$('#new_frequency').val('');
					onRefreshFrequency();
				}
			}
		});
	}
}

function onRefreshFrequency() {
	$.post({
		url: base_url + 'manufacture/frequency/get',
		success: function(resp) {
			var freq_id = $('#frequency_select').val();

			$('#frequency_list').html('');
			$('#frequency_select').html('');

			for (var i = 0; i < resp.length; i ++) {
				var type = 'Minute';
				if (resp[i].type == '0')
					type = 'Day';
				else if (resp[i].type == '1')
					type = 'Hour';

				$('#frequency_list').append(
					'<tr>'
						+ '<td>' + (i + 1) + '</td>'
						+ '<td>' + resp[i].frequency_name + '</td>'
						+ '<td>' + resp[i].days + '</td>'
						+ '<td>' + type + '</td>'
						+ '<td class="center">'
							+ '<a onclick="javascript:onDeleteFrequency(\'' + resp[i].frequency_id + '\');">'
								+ '<i class="icon-trash text-danger-600"></i>'
							+ '</a>'
						+ '</td>'
					+ '<tr>');
				$('#frequency_select').append(
					'<option value="' + resp[i].frequency_id + '"' + (freq_id == resp[i].frequency_id ? 'selected' : '') + '>' + resp[i].frequency_name + '</option>'
				);
			}
		}
	});
}

function onDeleteFrequency(id) {
	$.post({
		url: base_url + 'manufacture/frequency/delete/' + id,
		success: function(resp) {
			if (resp.success)
				onRefreshFrequency();
		}
	});
}