var oTable;

$(function(){
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

	var table = $('.datatable-work').DataTable({
		"bServerSide" : true,
		"bProcessing" : true,
		"aoColumns" : [{
			"sTitle" : "No",
			"mData" : "",
			"sWidth": "8%",
			mRender: function (data, type, row, pos) {
				var info = table.page.info();
				return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
			}
		}, {
			"sTitle" : "Code", "mData": "code", "sWidth": "18%"
		}, {
			"sTitle" : "Name", "mData": "name", "sWidth": "25%"
		}, {
			"sTitle" : "Resource Type", "mData": "resource_type", "sWidth": "28%"
		}, {
			"sTitle" : "Actions", "mData": "",
			mRender: function (data, type, row) {
				return  '<ul class="icons-list">' +
					'<li><a class="text-primary-600" href="#" onclick="javascript:onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
					'<li><a class="text-danger-600" href="#" onclick="javascript:onDelete(' + row.id + ')" title="Delete"><i class="icon-trash"></i></a></li>' +
					'</ul>';
			}
		}],
		"fnServerData": function (sSource, aoData, fnCallback){
			$.ajax({
				"dataType": "json",
				"type": "POST",
				"url": sSource,
				"data": aoData,
				"success": fnCallback
			});
		},
		"bAutoWidth": false,
		"sAjaxSource": 'work/read',
		"sAjaxDataProp": "work",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[1, "asc"]
		],
		lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"ideferLoading": 1,
		"bDeferRender": true,
		buttons: {
			buttons: [{
				extend: 'csv',
				"oSelectorOpts": { filter: 'applied', order: 'current' },
				text: 'CSV',
				className: 'btn btn-default'
			}, {
				extend: 'colvis',
				text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
				className: 'btn bg-blue btn-icon',
			}]
		},
		initComplete: function () {
			oTable = this;
		}
	});

	// Adjust columns on window resize
	setTimeout(function() {
		$(window).on('resize', function () {
			table.columns.adjust();
		});
	}, 100);

	// External table additions
    // ------------------------------
	$('.bootstrap-select').selectpicker();
	// Launch Uniform styling for checkboxes
	$('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
		$('.ColVis_collection input').uniform();
	});
});

function onCreate() {
	location.href = base_url + 'manufacture/work/create';
}

function onEdit(id) {
}

function onDelete(id) {
	 bootbox.confirm("Do you really delete this category?", function(result){
	 	if (result) {
	 		
	 	}
	 });
}