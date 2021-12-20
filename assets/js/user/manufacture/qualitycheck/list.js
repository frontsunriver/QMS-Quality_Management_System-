$(function(){
	var table = $('.datatable-qualitycheck').DataTable({
		"bServerSide" : true,
		"bProcessing" : true,
		"aoColumns" : [{
			"sTitle" : "No",
			"mData" : "",
			"sWidth": "6%",
			mRender: function (data, type, row, pos) {
				var info = table.page.info();
				return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
			}
		}, {
			"sTitle" : "Title", "mData": "title", "sWidth": "10%"
		}, {
			"sTitle" : "Product", "mData": "product_name", "sWidth": "10%"
		}, {
			"sTitle" : "Product Variant", "mData": "variant", "sWidth": "10%"
		}/*, {
			"sTitle" : "Operation", "mData": "operation_name", "sWidth": "10%"
		}*/, {
			"sTitle" : "Workcenter", "mData": "workcenter_name", "sWidth": "10%"
		}, {
			"sTitle" : "Content Type", "mData": "content_type",
			mRender: function(data, type, row) {
				if (data == 1)
					return 'All Operations';
			}
		}, {
			"sTitle" : "Test Type", "mData": "test_type",
			mRender: function(data, type, row) {
				if (data == 1)
					return 'Pass - Fail';
				else if (data == 2)
					return 'Measure';
			}
		}, {
			"sTitle" : "Responsible", "mData": "responsible_name", "sWidth": "10%"
		}, {
			"sTitle" : "Actions", "mData": "state",
			mRender: function (data, type, row) {
				return '<ul class="icons-list">' +
					'<li><a class="text-primary-600" href="' + base_url + 'manufacture/qualitycheck/create/' + row.id + '" title="Edit"><i class="icon-pencil7"></i></a></li>' +
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
		"sAjaxSource": 'qualitycheck/read',
		"sAjaxDataProp": "qualitycheck",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[2, "desc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [0, 8]
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
});

function onDelete(id) {
	bootbox.confirm("Do you really delete this quality check?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/qualitycheck/delete/' + id, {}, function(resp, status){
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