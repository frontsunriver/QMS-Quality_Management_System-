var oTable;

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
			targets: [0, 1, 2, 3]
		}]
	});

	$('.anytime').daterangepicker({ 
        singleDatePicker: true,
        locale: {
	        format: 'YYYY-MM-DD'
	    }
    });
});

function onDone(id) {
	var expireds = [];
	for (var i = 0; i < $('.anytime').length; i ++)
		expireds[$('.anytime').get(i).id.replace('datepicker', '')] = $('.anytime').get(i).value;

	$.post(base_url + 'warehouse/transfer/done/' + id, {expireds: expireds}, function(resp) {
		if (resp.success)
			location.href = base_url + resp.result;
	});
}