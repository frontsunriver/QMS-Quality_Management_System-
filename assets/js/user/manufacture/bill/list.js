var oTable;

$(function(){
	var table = $('.datatable-bill').DataTable({
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
			"sTitle" : "Product", "mData": "product_name", "sWidth": "20%"
		}, {
			"sTitle" : "Reference", "mData": "reference", "sWidth": "25%"
		}, {
			"sTitle" : "Product Variant", "mData": "variant", "sWidth": "25%"
		}, {
			"sTitle" : "Quantity", "mData": "quantity", "sWidth": "12%"
		}, {
			"sTitle" : "Actions", "mData": "",
			mRender: function (data, type, row) {
				return  '<ul class="icons-list">' +
					'<li><a class="text-primary-600" href="' + base_url + 'manufacture/bill/create/' + row.id + '" title="Edit"><i class="icon-pencil7"></i></a></li>' +
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
		"sAjaxSource": 'bill/read',
		"sAjaxDataProp": "bill",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[1, "asc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [0, 5]
		}],
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

function onDelete(id) {
	 bootbox.confirm("Do you really delete this category?", function(result){
	 	if (result) {
	 		$.post(base_url + 'manufacture/bill/delete/' + id, {}, function(resp, status){
				if (resp.success) {
				new PNotify({
					title: 'Success',
					text: 'Successfully Removed.',
					icon: 'icon-checkmark3',
					type: 'success'
				});
				oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
				} else {
				new PNotify({
					title: 'Error',
					text: 'Failed remove.',
					icon: 'icon-blocked',
					type: 'error'
				});
				}
			});
	 	}
	 });
}