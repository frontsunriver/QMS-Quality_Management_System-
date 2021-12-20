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

function onCalcTotal() {
	var trs = $('.datatable-basic tbody tr');

	var untaxes = 0, taxes = 0;
	for (var i = 0; i < trs.length; i ++) {
		if (!$($(trs[i]).children()[0]).hasClass('dataTables_empty')) {
			
		}
	}
}