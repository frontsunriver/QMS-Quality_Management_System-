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
			targets: [0, 1, 2, 3, 4, 5, 6, 7]
		}]
	});

	pIndex = oTable.data().length;
});

function onCreate() {

}

function onBack() {
	history.back();
}

function onAddProduct() {
	var row = new Array();

	row[0] = '<select class="form-control form-control-sm" id="product' + pIndex + '" name="product[' + pIndex + '][product_id]">' + products + '</select>';
	row[1] = '<input type="text" class="form-control form-control-sm col-lg-12" name="product[' + pIndex + '][description]" value="">';
	row[2] = '<input type="number" class="form-control form-control-sm" name="product[' + pIndex + '][quantity]" value="1">';
	row[3] = '<input type="number" class="form-control form-control-sm" name="product[' + pIndex + '][unit_price]" value="1">';
	row[4] = '<input type="number" class="form-control form-control-sm format-tax" name="product[' + pIndex + '][tax]" value="15">';
	row[5] = '<input type="number" class="form-control form-control-sm format-tax" name="product[' + pIndex + '][discount]" value="10">';
	row[6] = '';
	row[7] = '<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteProduct(this);"></i></li></ul>';

	oTable.row.add(row);
	oTable.draw();

	pIndex ++;
}

function onCalcTotal() {
	var trs = $('.datatable-basic tbody tr');

	var untaxes = 0, taxes = 0;
	for (var i = 0; i < trs.length; i ++) {
		if (!$($(trs[i]).children()[0]).hasClass('dataTables_empty')) {
			
		}
	}
}

function onDeleteProduct(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
	onCalcTotal();
}