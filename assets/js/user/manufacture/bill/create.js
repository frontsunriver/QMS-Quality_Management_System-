var oTable, pIndex;

$(function(){
	// Success
	$(".control-success").uniform({
		radioClass: 'choice',
		wrapperClass: 'border-success-600 text-success-800'
	});
    
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
			targets: [0, 1, 2, 3]
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
			'bill[product_id]': { required: true }
			, 'bill[quantity]': { required: true }
			, 'bill[reference]': { required: true }
		}
	});

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

function onCreate() {
	var active = $(".bootstrap-switch-id-active").hasClass('bootstrap-switch-on') ? 1 : 0;
	$('input[name="bill[active]"]').val(active);

	$("#create_form").submit();
}

function onAddLine() {
	var row = new Array();
	row[0] = '<select class="form-control form-control-sm col-lg-8" name="material[' + pIndex + '][material_id]" onchange="javascript:onChangeMaterial(this);">' + material_select + '</select>';
	row[1] = '<label>' + quantity + '</label>';
	row[2] = '<input type="number" class="form-control form-control-sm col-lg-8" name="material[' + pIndex + '][apply_on_variants]" value="1" onchange="javascript:onChangeQuantity(this)">';
	row[3] = '<ul class="icons-list"><li class="text-danger-600"><i class="icon-trash" onclick="javascript:onDeleteMaterial(this);"></i></li></ul>';

	oTable.row.add(row);
	oTable.draw();

	pIndex ++;
}

function onChangeMaterial(obj) {
	var material_id = $(obj).val();
	$.post(base_url + 'manufacture/bill/get_material_quantity/' + material_id, {}, function(resp){
		$(obj).parent().next().find('label').text(resp);
		$(obj).parent().next().next().find('input').val(1);
	});
}

function onChangeQuantity(obj) {
	var value = $(obj).val();
	var qty = parseInt($(obj).parent().prev().find('label').text());
	if (qty < parseInt(value)) {

		$(obj).val(qty);
	}
}

function onDeleteMaterial(obj) {
	$(obj).closest('tr').remove();

	if ($("#tab1 tbody").html().trim() == '') {
		oTable.clear();
		oTable.draw();
	}
}