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
			targets: [0, 1, 2, 3,]
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
			'shiporder[shiporder_num]': { required: true }
			, 'shiporder[payment_terms]': { required: true }
			, 'shiporder[shipping_policy]': { required: true }
			, 'shiporder[sales_team]': { required: true }
			, 'shiporder[customer_reference]': { required: true }
		}
	});
});

function onSave() {
	$('#create_form').submit();
}