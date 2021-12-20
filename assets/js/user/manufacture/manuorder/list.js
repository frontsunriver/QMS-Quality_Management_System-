var oTable;

$(function(){
	var table = $('.datatable-manuorder').DataTable({
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
			"sTitle" : "Reference", "mData": "manuorder_num", "sWidth": "10%"
		}, {
			"sTitle" : "Lot Code", "mData": "lot_code", "sWidth": "7%"
		}, {
			"sTitle" : "Scheduled Date", "mData": "scheduled_date", "sWidth": "10%"
		}, {
			"sTitle" : "Product", "mData": "product_name", "sWidth": "10%"
		}, {
			"sTitle" : "Product Quantity", "mData": "quantity", "sWidth": "10%"
		}, {
			"sTitle" : "Routing", "mData": "routing_name", "sWidth": "8%"
		}, {
			"sTitle" : "Total Hours", "mData": "total_hours", "sWidth": "7%",
			mRender: function(data, type, row) {
				var mm = data % 60;
				var hh = (data - mm) / 60;

				if (hh < 10)
					hh = '0' + hh;
				if (mm < 10)
					mm = '0' + mm;

				return hh + ':' + mm;
			}
		}, {
			"sTitle" : "Total Cycles", "mData": "total_cycles", "sWidth": "10%"
		}, {
			"sTitle" : "Scr Doc", "mData": "src_doc", "sWidth": "10%",
			mRender: function(data, type, row) {
				if (data != null && data != '')
					return '<a href="' + base_url + 'uploads/src_doc/' + data + '" target="_blank"><i class="icon-file-pdf" style="cursor: pointer; color: cornflowerblue;"></i></a>';
				return '';
			}
		}, {
			sTitle : 'Quality Check', mData: 'state', sWidth: '6%', sClass: 'text-center',
			mRender: function(data, type, row) {
				if (data == 0)
					return '';
				else if (data == 1)
					return '<label class="label label-warning">Not Determine</label>';
				else if (data == -2)
					return '<label class="label label-danger">Fail</label>';
				else
					return '<label class="label label-success">Success</label>';
			}
		}, {
			"sTitle" : "Status", "mData": "state", "sWidth": "6%",
			mRender: function(data, type, row) {
				if (data == 0)
					return '<label class="label label-danger" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">New</label>';
				else if (data == 1)
					return '<label class="label label-warning" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">Awaiting Raw Materials</label>';
				else if (data == 2)
					return '<label class="label label-info" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">Ready to Produce</label>';
				else if (data == 3)
					return '<label class="label label-primary" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">Production Started</label>';
				else if (data == 4)
					return '<label class="label label-success" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">Done</label>';
				else if (data == 5)
					return '<label class="label label-success" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onEdit(' + row.id + ')">Transfer</label>';
			}
		}, {
			"sTitle" : "Actions", "mData": "state",
			mRender: function (data, type, row) {
				if (data < 3)
					return '<ul class="icons-list">' +
						'<li><a class="text-primary-600" href="#" onclick="javascript:onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
						'<li><a class="text-danger-600" href="#" onclick="javascript:onDelete(' + row.id + ')" title="Delete"><i class="icon-trash"></i></a></li>' +
						'</ul>';
				return '<ul class="icons-list">' +
					'<li><a class="text-primary-600" href="#" onclick="javascript:onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
					'</ul>';;
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
		"sAjaxSource": 'manuorder/read',
		"sAjaxDataProp": "manuorder",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[2, "desc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [0, 6, 7, 10]
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

function onEdit(id) {
	location.href = base_url + 'manufacture/manuorder/create/' + id;
}

function onDelete(id) {
	bootbox.confirm("Do you really delete this manufacturing order?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/manuorder/delete/' + id, {}, function(resp, status){
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