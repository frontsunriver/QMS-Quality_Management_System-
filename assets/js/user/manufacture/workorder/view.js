$(function(){
	$('.modal-basic').magnificPopup({
		type: 'inline',
		preloader: false,
		modal: true
	});

	$(document).on('click', '.modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
});

function onStart(id) {
	bootbox.confirm("Do you really start this work order?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/workorder/start/' + id, {number_of_cycles: number_of_cycles, number_of_hours: number_of_hours}, function(resp) {
				if (resp.success) {
					location.reload();
				}
			});
		}
	});
}

function onQualityCheck(id) {
	$.post(base_url + 'manufacture/qualitycheck/get', {workorder_id: id}, function(resp){
		if (resp.length == 0)
			new PNotify({
				title: 'Error',
				text: 'Please create the quality check and retry it.',
				icon: 'icon-blocked',
				type: 'error'
			});
		else {
			if (resp.test_type == 1) {
				$('#qualitycheck_passfail_modal #qualitycheck_id').val(resp.id);
				$('#qualitycheck_passfail_modal #test_type').val(resp.test_type);

				$(resp.note).insertAfter('#qualitycheck_passfail_modal .modal-text h4');
				$('#qualitycheck_btn').attr('href', '#qualitycheck_passfail_modal');
			} else if (resp.test_type == 2) {
				$('#qualitycheck_measure_modal #qualitycheck_id').val(resp.id);
				$('#qualitycheck_measure_modal #test_type').val(resp.test_type);

				$(resp.note).insertAfter('#qualitycheck_measure_modal .modal-text h4');
				$('#qualitycheck_btn').attr('href', '#qualitycheck_measure_modal');
				$('#tolerance_from').val(resp.tolerance_from);
				$('#tolerance_to').val(resp.tolerance_to);
			}

			$('#qualitycheck_btn').click();
		}
	});
}

function onPassFail(value) {
	$('#qualitycheck_passfail_modal #check_value').val(value);
	$('#qualitycheck_passfail_modal form').submit();
}

function onFinish(id) {
	bootbox.confirm("Do you really finish this work order?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/workorder/finish/' + id, function(resp) {
				if (resp.success)
					location.reload();
			});
		}
	});
}