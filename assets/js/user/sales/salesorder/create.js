var oTable, pIndex, products;

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
			targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
		validClass: "validation-valid-label",
		rules: {
			'salesorder[salesorder_num]': { required: true }
			, 'salesorder[payment_terms]': { required: true }
			, 'salesorder[shipping_policy]': { required: true }
			, 'salesorder[sales_team]': { required: true }
			, 'salesorder[customer_reference]': { required: true }
		}
	});

	$('[data-plugin-selectTwo]').each(function() {
		var $this = $( this ),
			opts = {};

		var pluginOptions = $this.data('plugin-options');
		if (pluginOptions)
			opts = pluginOptions;

		$this.themePluginSelect2(opts);
	});

	onChangeWarehouse($('#warehouse_select').val());

	onCalcTotal();
});

function onCreate() {
	$('#create_form').submit();
}

function onBack() {
	location.href = base_url + 'sales/salesorder';
}

function onDelivery(salesorder_id) {
	$.post(base_url + 'sales/salesorder/delivery/' + salesorder_id, {}, function(resp){
		if (resp.success)
			location.href = base_url + 'sales/shiporder/create/-1?salesorder_id=' + salesorder_id;
		else
			new PNotify({
				title: 'Error',
				text: resp.result,
				icon: 'icon-blocked',
				type: 'error'
			});
	});
	// location.href = base_url + 'sales/shiporder/create/-1?salesorder_id=' + $salesorder_id;
}

function onChangeWarehouse(warehouse_id) {
	var selects = $('#tab1 tbody select');
	for (var i = 0; i < selects.length; i ++) {
		var iPos = selects.get(i).id.split('product')[1];
		onChangeProductItem(iPos);
	}
}

function onAddProduct() {
	var row = new Array();

	row[0] = '<select class="form-control form-control-sm" id="product' + pIndex + '" name="product[' + pIndex + '][product_id]" onchange="javascript:onChangeProductItem(' + pIndex + ');" data-plugin-options=\'{ "placeholder": "Select a State", "allowClear": true }\'>' + products + '</select>';
	row[1] = '<input type="text" class="form-control form-control-sm col-lg-12" name="product[' + pIndex + '][description]" value="">';
	row[2] = '<label id="available_qty' + pIndex + '"></label>';
	row[3] = '<input type="number" class="form-control form-control-sm" id="product_qty' + pIndex + '" name="product[' + pIndex + '][ordered_qty]" min="0" value="0" onchange="javascript:onCalcTotal();">';
	row[4] = '<input type="number" class="form-control form-control-sm" name="product[' + pIndex + '][unit_price]" value="1" onchange="javascript:onCalcTotal();">';
	row[5] = '<input type="number" class="form-control form-control-sm format-tax" name="product[' + pIndex + '][tax]" value="15" onchange="javascript:onCalcTotal();">';
	row[6] = '<input type="number" class="form-control form-control-sm" name="product[' + pIndex + '][discount]" value="10">';
	row[7] = '';
	row[8] = '<ul class="icons-list text-center"><li class="text-danger-400" style="margin-left: 0px;"><i class="icon-trash" onclick="javascript:onDeleteProduct(this);"></i></li></ul>';

	oTable.row.add(row);
	oTable.draw();

	$('#product' + pIndex).each(function() {
		var $this = $( this ),
			opts = {};

		var pluginOptions = $this.data('plugin-options');
		if (pluginOptions)
			opts = pluginOptions;

		$this.themePluginSelect2(opts);
	});

	onChangeProductItem(pIndex);

	pIndex ++;
}

function onChangeProductItem(iPos) {
	var arr = $('#product' + iPos).val().split('@');
	$.post(base_url + 'sales/salesorder/quantity', {
		warehouse_id: $('#warehouse_select').val(),
		product_id: arr[0],
		variant: arr.length == 2 ? arr[1] : ''
	}, function(resp){
		$('label#available_qty' + iPos).text(resp);
		// $('input#product_qty' + iPos).attr('max', resp);
	});
}

function onCalcTotal() {
	var trs = $('.datatable-basic tbody tr');

	var untaxes = 0, taxes = 0;
	for (var i = 0; i < trs.length; i ++) {
		if (!$($(trs[i]).children()[0]).hasClass('dataTables_empty')) {
			var quantity = parseFloat($($(trs[i]).children()[3]).find('input').val());
			var unit_price = parseFloat($($(trs[i]).children()[4]).find('input').val());

			// $($(trs[i]).children()[7]).text('$ ' + unit_price * quantity);

			var tax = parseFloat($(trs[i]).find('.format-tax').val());
			if (tax > 100) {
				tax = 100;
				$(trs[i]).find('.format-tax').val(100);
			}

			var untax = quantity * unit_price;
			var tax = parseFloat(quantity * unit_price * tax / 100);
			tax = parseFloat(tax.toPrecision(tax.toString().split('.')[0].length + 2));

			// untaxes += total;
			taxes += tax;
			untaxes += untax;

			$($(trs[i]).children()[7]).text(untax + tax);
		}
	}

	$('.subtotal_span').text(parseFloat(untaxes.toPrecision(untaxes.toString().split('.')[0].length + 2)));
	$('input[name="salesorder[untaxes]"]').val($('.subtotal_span').text());
	$('.taxable_span').text(parseFloat(taxes.toPrecision(taxes.toString().split('.')[0].length + 2)));
	$('input[name="salesorder[taxes]"]').val($('.taxable_span').text());

	var total = untaxes + taxes;
	$('.total_span').text(total.toPrecision(total.toString().split('.')[0].length + 2));
	$('input[name="salesorder[total]"]').val($('.total_span').text());
}

function onDeleteProduct(obj) {
	oTable.row($(obj).parents('tr')[0]).remove().draw();
	onCalcTotal();
}