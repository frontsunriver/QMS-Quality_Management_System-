var oTable, oTable1, pIndex, switchActive, variants, oldData, billActived;

$(function(){
	// $('#product_variants').multiselect();

	var orderDate = $('#scheduled_date').AnyTime_picker({
		format: "%Y-%m-%d %H:%i:%s"
	});

	var expiredDate = $('#expired_date').AnyTime_picker({
		format: "%Y-%m-%d"
	});

	switchActive = $(".switch").bootstrapSwitch();

	if ($('#scheduled_date').val() == '')
		orderDate.AnyTime_setCurrent(new Date()).blur();

	if ($('#expired_date').val() == '')
		expiredDate.AnyTime_setCurrent(new Date()).blur();

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
	if (confirmed == 1)
		oTable = $('#material_consume').DataTable({
			columnDefs: [{
				orderable: false,
				targets: [0, 1, 2]
			}]
		});
	else if (confirmed == 0)
		oTable = $('#material_consume').DataTable({
			columnDefs: [{
				orderable: false,
				targets: [0, 1]
			}]
		});

	oTable1 = $('#consumed_material').DataTable({
		columnDefs: [{
			orderable: false,
			targets: [0, 1, 2]
		}]
	});

	pIndex = oTable.data().length;

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
		errorPlacement: function(error, element) {
			if (element.attr('name') == 'manuorder[product_id]')
				error.insertAfter(element.next());
			else
				error.insertAfter(element);
		},
		validClass: "validation-valid-label",
		rules: {
			'manuorder[manuorder_num]': { required: true }
			, 'manuorder[quantity]': { required: true }
		}
	});

	$("#waste_form").validate({
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
			'waste[quantity]': { required: true, number: true }
			, 'waste[reason]': { required: true }
		},
		success: function(label) {
			label.addClass("validation-valid-label").text("Success.");
		},
		submitHandler: function (form) {
			var params = {};
			for (i = 0; i < form.length; i ++) {
				if (form[i].name != '') {
					params[form[i].name] = form[i].value;
				}
			}

			$.post(base_url + 'manufacture/manuorder/waste/' + manuorder_id, params, function(resp){
				if (resp.success) {
					// new PNotify({
					// 	title: 'Success',
					// 	text: 'Successfully wasted.',
					// 	icon: 'icon-checkmark3',
					// 	type: 'success'
					// });

					// form.reset();

					// $('#modal_waste').modal('hide');

					location.reload();
				} else {
					new PNotify({
						title: 'Error',
						text: 'Failure wasted.',
						icon: 'icon-blocked',
						type: 'error'
					});
				}
			});
		}
	});

	$('.src_doc_input').on('change', function(){
		var file = $(this)[0];
		var filename = file.value.toString();
		var ext = filename.substr(filename.lastIndexOf('.') + 1);

		if (ext != 'pdf') {
			new PNotify({
				title: 'Error',
				text: 'Please input the pdf file !!!',
				icon: 'icon-checkmark3',
				type: 'error'
			});
			$(this).val('');
		} else {
			var workorder_id = $(this).attr('workorder');

			var formData = new FormData();
			formData.append('userfile', $(this)[0].files[0]);

			var ajaxAction = new XMLHttpRequest();
			ajaxAction.open('POST', base_url + 'manufacture/workorder/upload/' + workorder_id);

			ajaxAction.onload = function() {
				var E = ajaxAction.responseText;
				if (E != 'error') {
					new PNotify({
						title: 'Success',
						text: 'Successfully uploaded !!!',
						icon: 'icon-checkmark3',
						type: 'success'
					});

					if ($('#src_doc_' + workorder_id)[0] == null)
						$('<a id="src_doc_' + workorder_id + '" href="' + base_url + 'uploads/src_doc/' + E + '" target="_blank"><i class="icon-file-pdf" style="cursor: pointer; color: cornflowerblue;"></i></a>').insertBefore('#src_doc_input_' + workorder_id);
					else
						$('#src_doc_' + workorder_id).attr('href', base_url + 'uploads/src_doc/' + E);
				} else
					new PNotify({
						title: 'Filed',
						text: 'Upload failed !!!',
						icon: 'icon-checkmark3',
						type: 'error'
					});
			}

			ajaxAction.send(formData);
		}
	});

	onChangeActive();

	// Initialize Product Variants
	$('[data-plugin-selectTwo]').each(function() {
		var $this = $( this ),
			opts = {};

		var pluginOptions = $this.data('plugin-options');
		if (pluginOptions)
			opts = pluginOptions;

		$this.themePluginSelect2(opts);
	});
});

function onSave() {
	$('#create_form').submit();
}

function onConfirmProduction(id) {
	if (oTable.data().length == 0)
		new PNotify({
			title: 'Warning',
			text: 'Not materials to consume !!!\nPlease Add an item.',
			icon: 'icon-checkmark3',
			type: 'warning'
		});
	else {
		bootbox.confirm("Do you really confirm this manufacturing order?", function(result){
			if (result) {
				location.href = base_url + 'manufacture/manuorder/confirm/' + id;	
			}
		});
	}
}

function onTransfer(product_id, variant, quantity, lot_code) {
	$('#modal_transfer #product_select').val(product_id);
	$('#modal_transfer #product_hidden').val(product_id);
	$('#modal_transfer #variant').val(variant);
	$('#modal_transfer #product_quantity').val(quantity);
	$('#modal_transfer #lot_code').val(lot_code);

	$('#modal_transfer').modal();
}

function onAddItem() {
	var row = new Array();

	row[0] = '<select class="form-control form-control-sm col-lg-12" name="material[' + pIndex + '][material_id]">'
		+ material_options
		+ '</select>';

	row[1] = '<input type="number" class="form-control form-control-sm col-lg-12" name="material[' + pIndex + '][quantity]" value="1">';
	row[2] = '<ul class="icons-list">'
		+ '<li><a class="text-danger-600" href="#" onclick="javascript:onDeleteItem(this)" title="Delete"><i class="icon-trash"></i></a></li>'
		+ '</ul>';

	if (confirmed == 1)
		row[2] = '';

	oTable.row.add(row);
	oTable.draw();

	pIndex ++;
}

function onCheckAvailability(id) {
	$.post(base_url + 'manufacture/manuorder/check_availability/' + id, {}, function(resp) {
		if (resp.success)
			location.href = base_url + 'manufacture/manuorder/create/' + id;
		else {
			new PNotify({
				title: 'Error',
				text: resp.result,
				icon: 'icon-checkmark3',
				type: 'error'
			});
		}
	});
}

function onProduce(id) {
	$.post(base_url + 'manufacture/manuorder/produce/' + id, {}, function(resp) {
		if (resp.success)
			location.reload();
	});
}

function onWaste() {
	$('#modal_waste').modal();
}

function onChangeActive(){
	if (confirmed)
		return;

	if (switchActive[0].checked) {
		// oldData = oTable.data();

		$('#product').prop('disabled', true);
		$('#addBtn').css('display', 'none');
		$('#product_hidden').prop('disabled', false);
		$('#bill').prop('disabled', false);
		$('#quantity').prop('readonly', true);

		var bill_id = $('#bill').val();
		onChangeBillMaterial(bill_id);
	} else {
		$('#product').prop('disabled', false);
		$('#addBtn').css('display', 'block');
		$('#product_hidden').prop('disabled', true);
		$('#bill').prop('disabled', true);
		$('#quantity').prop('readonly', false);
	}
}

function onChangeBillMaterial(bill_id) {
	oTable.clear();
	oTable.draw();

	var arr = bill_id.split('@');

	$.post(base_url + 'common/bill/get/' + arr[0], {}, function(resp){
		// $('#product').val(resp.product_id);
		// $('#product_hidden').val(resp.product_id);
		$('#product_hidden').val(arr[1] + '@' + arr[2]);
		$('#quantity').val(resp.quantity);

		for (var i = 0; i < resp.materials.length; i ++) {
			var row = new Array();

			row[0] = '<select id="material' + pIndex + '" class="form-control form-control-sm col-lg-12" disabled>'
				+ material_options
				+ '</select><input type="hidden" name="material[' + pIndex + '][material_id]" value="' + resp.materials[i].material_id + '" />';

			row[1] = '<input type="number" class="form-control form-control-sm col-lg-12" name="material[' + pIndex + '][quantity]" value="' + resp.materials[i].qty + '" readonly>';
			row[2] = '<ul class="icons-list">'
				+ '<li><a class="text-danger-600" href="#" onclick="javascript:onDeleteItem(this)" title="Delete"><i class="icon-trash"></i></a></li>'
				+ '</ul>';

			if (confirmed == 1)
				row[2] = '';

			oTable.row.add(row);
			oTable.draw();

			$('select#material' + pIndex).val(resp.materials[i].material_id);

			pIndex ++;
		}
	});
}

function onChangeMaterial(material_id) {
	$('#modal_waste input[name="waste[quantity]"]').attr('max', limit_qty[material_id]);
}

function onDeleteItem(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
}