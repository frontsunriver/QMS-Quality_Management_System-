var oTable, pIndex;

$(function(){

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
			targets: [1, 2, 3, 4]
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
			'order[shiporder_num]': { required: true }
			, 'order[opt_type]': { required: true }
		}
	});

});

function onSave() {
	$("#create_form").submit();
}

function onBack() {
	history.back();
}

function onDownloadPDF(id) {
	location.href = base_url + 'procurement/purchaseorder/pdf/' + id;
}

function onConfirmOrder(id) {
	bootbox.confirm("Do you really confirm this purchase order?", function(result){
		if (result) {
			location.href = base_url + 'warehouse/ship/confirm/' + id;
		}
	});
}

function onAddLine(obj) {
	var row = new Array();
	row[0] = '<select class="form-control form-control-sm" name="operation[' + pIndex + '][product_id]" onchage="javascript:onChangeProduct(this);">' + product_options + '</select>';
	// row[0] = '<input type="text" class="form-control form-control-sm" name="products[' + pIndex + '][product]" value="" style="background-color: white;">';
	row[1] = '<input type="number" class="form-control form-control-sm format-unit-price" name="products[' + pIndex + '][demand]" value="" style="background-color: white;">';
	row[2] = '<input type="number" class="form-control form-control-sm format-unit-price" name="products[' + pIndex + '][reserved]" value="" style="background-color: white;">';
	row[3] = '';
	row[4] = '<ul class="icons-list text-left"><li class="text-danger-400"><i class="icon-trash" onclick="onDeleteAddItem(this);"></i></li></ul>';

	oTable.row.add(row);
	oTable.draw();
	pIndex ++;

}

function onChangeProduct(obj) {
	var product_id = $(obj).val();
	$.post(base_url())
}

function onDeleteAddItem(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
}