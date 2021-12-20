/* Add here all your JS customizations */
$(function(){
	$(".nav-tabs > li").click(function(){
		$(".nav-tabs > li").removeClass("active");
		$(this).addClass("active");
	});

	$.extend( $.fn.dataTable.defaults, {
		autoWidth: false,
		colReorder: true,
		dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
		language: {
			search: '<span>Search Name:</span> _INPUT_',
			searchPlaceholder: 'Type to filter...',
			lengthMenu: '<span>Show:</span> _MENU_',
			paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
		},
		drawCallback: function () {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
		},
		preDrawCallback: function() {
			$(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
		}
	});

	if ($('input.cost-input').length > 0) {
		$('input.cost-input').formatter({
			pattern: '{{999}}.{{99}}'
		});
	}
});