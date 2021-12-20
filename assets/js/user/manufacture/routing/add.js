var oTable, pIndex;

$(function(){
	// Success
	$(".switch").bootstrapSwitch();

	//datatable
	$.extend( $.fn.dataTable.defaults, {
		autoWidth: false,
		dom: '<"datatable-scroll"t>',
		drawCallback: function () {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
		},
		preDrawCallback: function() {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
		}
	});
	// Basic datatable
	oTable = $('.datatable-basic').DataTable({
		columnDefs: [{
			orderable: false,
			targets: [1, 2, 3, 4, 5]
		}]
	});

	pIndex = oTable.data().length;

	$("#add_form").validate({
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
			'routing[name]': { required: true }
			, 'routing[code]': { required: true }
		}
	});

	$("#add_item_form").validate({
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
			'name': { required: true }
			, 'sequence': { required: true }
			, 'number_of_cycles': { required: true }
			, 'number_of_hours': { required: true }
		},
		submitHandler: function (form) {
			workcenter = $(form).find('select[name="workcenter"]').val();

			var row = new Array();
			row[0] = '<label>' + $(form).find('input[name="sequence"]').val() + '</label>'
				+ '<input type="hidden" class="form-control form-control-sm col-lg-12 no-border" name="operation[' + pIndex + '][sequence]" value="' + $(form).find('input[name="sequence"]').val() + '">';
			row[1] = '<label>' + $(form).find('input[name="name"]').val() + '</label>'
				+ '<input type="hidden" class="form-control form-control-sm col-lg-12 no-border" name="operation[' + pIndex + '][name]" value="' + $(form).find('input[name="name"]').val() + '">';
			row[2] = '<label>' + $(form).find('option[value="' + workcenter + '"]').text() + '</label>'
				+ '<input type="hidden" name="operation[' + pIndex + '][workcenter_id]" value="' + $(form).find('select[name="workcenter"]').val() + '">'
				+ '<input type="hidden" name="operation[' + pIndex + '][description]" value="' + $(form).find('textarea').val() + '">';
			row[3] = '<label>' + $(form).find('input[name="number_of_cycles"]').val() + '</label>'
				+ '<input type="hidden" class="form-control form-control-sm col-lg-12 no-border" name="operation[' + pIndex + '][number_of_cycles]" value="' + $(form).find('input[name="number_of_cycles"]').val() + '">';
			row[4] = '<label>' + $(form).find('input[name="number_of_hours"]').val() + '</label>'
				+ '<input type="hidden" class="form-control form-control-sm col-lg-12 no-border" name="operation[' + pIndex + '][number_of_hours]" value="' + $(form).find('input[name="number_of_hours"]').val() + '">';
			row[5] = '<ul class="icons-list">'
				+ '<li class="text-danger-600"><i class="icon-trash" onclick="javascript:onDeleteItem(this);"></i></li>'				
				+ '</ul>';

			oTable.row.add(row);
			oTable.draw();

			pIndex ++;

			$("#modal_item").modal('hide');
		}
	});

	// Time picker
    $('#number_of_hours').AnyTime_picker({
        format: "%H:%i"
    });
});

function onAddItem() {
	onReset();

	$("#modal_item").modal('show');
}

function onEditItem(obj) {
	var tr = $(obj).closest('tr');

	$('#modal_item input[name="name"]').val(tr.find('td:eq(1) input').val());
	$('#modal_item input[name="sequence"]').val(tr.find('td:eq(0) input').val());
	$('#modal_item input[name="number_of_cycles"]').val(tr.find('td:eq(3) input').val());
	$('#modal_item select[name="work_center"]').val(tr.find('td:eq(2) input:eq(0)').val());
	$('#modal_item input[name="number_of_hours"]').val(tr.find('td:eq(4) input').val());
	$('#modal_item textarea[name="description"]').val(tr.find('td:eq(2) input:eq(1)').val());

	$("#modal_item").modal('show');
}

function onDeleteItem(obj) {
	$(obj).closest('tr').remove();

	if ($("#tab1 tbody").html().trim() == '') {
		oTable.clear();
		oTable.draw();
	}
}

function onReset() {
	$('#modal_item input[name="name"]').val('');
	$('#modal_item input[name="sequence"]').val('0');
	$('#modal_item input[name="number_of_cycles"]').val('1');
	$('#modal_item select[name="work_center"] option:eq(0)').prop('selected', true);
	$('#modal_item input[name="number_of_hours"]').val('00:00');
	$('#modal_item textarea[name="description"]').val('');
}

function onSave() {
	$("#add_form").submit();
}