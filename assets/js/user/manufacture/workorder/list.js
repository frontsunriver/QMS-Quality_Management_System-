var oTable;

$(function(){
	var table = $('.datatable-workorder').DataTable({
		"bServerSide" : true,
		"bProcessing" : true,
		"aoColumns" : [{
			"sTitle" : "No",
			"mData" : "",
			"sWidth": "80",
			mRender: function (data, type, row, pos) {
				var info = table.page.info();
				return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
			}
		}, {
			"sTitle" : "Manufacturing Order", "mData": "manuorder_num", "sWidth": "180"
		}, {
			"sTitle" : "Scheduled Date", "mData": "scheduled_date", "sWidth": "160"
		}, {
			"sTitle" : "Product", "mData": "product_name", "sWidth": "100"
		}, {
			sTitle : 'Variant', mData: 'variant', sWidth: '100'
		}, {
			"sTitle" : "Qty", "mData": "quantity", "sWidth": "80"
		}, {
			"sTitle" : "Unit of Measure", "mData": "", "sWidth": "150",
			mRender: function(data, type, row) {
				return 'Unit($)';
			}
		}, {
			"sTitle" : "Work Order", "mData": "routing_name", "sWidth": "130"
		}, {
			"sTitle" : "Work Center", "mData": "workcenter_name", "sWidth": "150"
		}, {
			"sTitle" : "Number of Cycles", "mData": "number_of_cycles", "sWidth": "150"
		}, {
			"sTitle" : "Number of Hours", "mData": "number_of_hours", "sWidth": "150"
		}, {
			sTitle : 'Quality Check', mData: 'state', sWidth: '140', sClass: 'text-center',
			mRender: function(data, type, row) {
				if (data == 0)
					return '';
				else if (data == 1)
					return '<label class="label label-warning cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Not Determine</label>';
				else if (data == -2)
					return '<label class="label label-danger cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Fail</label>';
				else
					return '<label class="label label-success cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Success</label>';
			}
		}, {
			"sTitle" : "Status", "mData": "state", "sWidth": "100",
			mRender: function(data, type, row) {
				if (data == 0)
					return '<label class="label label-warning cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Ready to Produce</label>';
				else if (data == 1)
					return '<label class="label label-primary cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Produced</label>';
				else if (data == 2)
					return '<label class="label label-info cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Quality Pass</label>';
				else if (data == -2) {
					if (row.role == 'monitor')
						return '<button type="button" class="btn btn-primary btn-xs" onclick="javascript:onConduct(' + row.id + ');">Manage</button>';
					else
						return '<label class="label label-danger cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Fail</label>';
				} else if (data == 3)
					return '<label class="label label-success cursor_pointer" onclick="javascript:onDetail(' + row.id + ');">Done</label>';
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
		"sAjaxSource": 'workorder/read',
		"sAjaxDataProp": "workorder",
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

function onDetail(id) {
	location.href = base_url + 'manufacture/workorder/view/' + id;
}

function onConduct(id) {
	location.href = base_url + 'manufacture/workorder/conduct/' + id;
}

function onDelete(id) {
	 bootbox.confirm("Do you really delete this category?", function(result){
	 	if (result) {
	 		
	 	}
	 });
}