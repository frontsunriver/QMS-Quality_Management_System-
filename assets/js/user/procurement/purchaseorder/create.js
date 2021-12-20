var oTable, pIndex;

$(function(){
	var orderDate = $('#order_date').AnyTime_picker();
	if ($('#order_date').val() == '')
		orderDate.AnyTime_setCurrent(new Date()).blur();

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
			targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
		}]
	});

	pIndex = oTable.data().length;

	$("#create_form").validate({
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
			'order[purchase_num]': { required: true }
		}
	});

	var anytimes = $('.anytime');
	for (var i = 0; i < anytimes.length; i ++)
		$(anytimes[i]).AnyTime_picker();

	onCalcTotal();
});

function onSave() {
	$("#create_form").submit();
}

function onDownloadPDF(id) {
	location.href = base_url + 'procurement/purchaseorder/pdf/' + id;
}

function onConfirmOrder(id) {
	bootbox.confirm("Do you really confirm this purchase order?", function(result){
		if (result) {
			location.href = base_url + 'procurement/purchaseorder/confirm/' + id;
		}
	});
}

function onAddLine() {
	if (materials == '') {
		new PNotify({
			title: 'Error',
			text: 'No materials. Please add material !!!',
			icon: 'icon-checkmark3',
			type: 'error'
		});
		return;
	}

	var row = new Array();
	row[0] = '<select class="form-control form-control-sm" id="material' + pIndex + '" name="material[' + pIndex + '][material_id]" onchange="javascript:onChangeMaterial(this);">' + materials + '</select>';
	row[1] = '<select class="form-control form-control-sm" id="material' + pIndex + '" name="material[' + pIndex + '][supplier_id]">' + supplier + '</select>';
	row[2] = '<input type="text" class="form-control form-control-sm" name="material[' + pIndex + '][trace_code]" value="">';
	row[3] = '<input type="text" class="form-control form-control-sm col-lg-12" id="anytime' + pIndex + '" name="material[' + pIndex + '][scheduled_date]" value="" style="background-color: white;">';
	row[4] = '<input type="number" class="form-control form-control-sm format-unit-price" name="material[' + pIndex + '][quantity]" value="1" onchange="javascript:onCalcTotal();">';
	row[5] = '<input type="number" class="form-control form-control-sm format-unit-price" name="material[' + pIndex + '][unit_price]" value="10" onchange="javascript:onCalcTotal();">';
	row[6] = '<input type="number" class="form-control form-control-sm format-tax" name="material[' + pIndex + '][tax]" value="15" onchange="javascript:onCalcTotal();">';
	row[7] = '';
	row[8] = '<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteMaterial(this);"></i></li></ul>';

	oTable.row.add(row);
	oTable.draw();

	$('#anytime' + pIndex).AnyTime_picker().AnyTime_setCurrent(new Date()).blur();
	$('#material' + pIndex).val(material_id);

	pIndex ++;

	onChangeMaterial($('.datatable-basic tbody tr:last').find('select'));
}

function onDeleteMaterial(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
	onCalcTotal();
}

function onChangeMaterial(obj) {
	var value = $(obj).val();
	$.post(base_url + 'procurement/purchaseorder/get/' + value, {}, function(resp) {
		var tr = $(obj).parent().parent();
		$(tr).children()[1].children[0].value = resp.supplier_id;
		$(tr).children()[2].children[0].value = resp.upc;
		//$($(tr).children()[1]).val(resp.supplier_id);
		// $($(tr).children()[3]).text(resp.quantity);

		onCalcTotal($('.datatable-basic tbody tr:last .format-unit-price'));
	});
}

function onCalcTotal() {
	var trs = $('.datatable-basic tbody tr');

	var untaxes = 0, taxes = 0;
	for (var i = 0; i < trs.length; i ++) {
		if (!$($(trs[i]).children()[0]).hasClass('dataTables_empty')) {
			var quantity = parseFloat($($(trs[i]).children()[4]).find('input').val());
			var unit_price = parseFloat($($(trs[i]).children()[5]).find('input').val());

			$($(trs[i]).children()[7]).text('$ ' + unit_price * quantity);

			var tax = parseFloat($(trs[i]).find('.format-tax').val());
			if (tax > 100) {
				tax = 100;
				$(trs[i]).find('.format-tax').val(100);
			}
			var total = parseFloat($($(trs[i]).children()[7]).text().split(' ')[1]);

			untaxes += total;
			taxes += (total * tax) / 100;
		}
	}

	var buf = untaxes + '';
	var precision = buf.split('.')[0].length + 2;
	$('.subtotal_span').text(untaxes.toPrecision(precision));
	$('input[name="order[untaxes]"]').val(untaxes.toPrecision(precision));
	buf = taxes + '';
	precision = buf.split('.')[0].length + 2;
	$('.taxable_span').text(taxes.toPrecision(precision));
	$('input[name="order[taxes]"]').val(taxes.toPrecision(precision));
	buf = (taxes + untaxes) + '';
	precision = buf.split('.')[0].length + 2;
	$('.total_span').text((untaxes + taxes).toPrecision(precision));
	$('input[name="order[total]"]').val((untaxes + taxes).toPrecision(precision));
}