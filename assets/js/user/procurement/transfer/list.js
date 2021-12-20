var oTable;

$(function(){
	var table = $('.datatable-transfer').DataTable({
		"bServerSide" : true,
		"bProcessing" : true,
		"aoColumns" : [{
			"sTitle" : "No",
			"mData" : "",
			"sWidth": "5%",
			mRender: function (data, type, row, pos) {
				var info = table.page.info();
				return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
			}
		}, {
			"sTitle" : "Reference", "mData": "reference"
		}, {
			"sTitle" : "Purchase Number", "mData": "purchase_num"
		}, {
			"sTitle" : "Order Date", "mData": "order_date"
		}, {
			"sTitle" : "Warehouse", "mData": "warehouse_name"
		}, {
			"sTitle" : "Status", "mData": "",
			mRender: function(data, type, row) {
				if (row.state == 1)
					return '<label class="label label-danger" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onView(' + row.id + ')">Awaiting Operation</label>';
				else if (row.state == 2)
					return '<label class="label label-success" style="margin-bottom: 0px; cursor: pointer;" onclick="javascript:onView(' + row.id + ')">Done</label>';
			}
		}, {
			"sTitle" : "Actions", "mData": "", "sWidth": "7%",
			mRender: function (data, type, row) {
				return  '<ul class="icons-list">' +
					'<li><a class="text-primary-600" href="#" onclick="javascript:onView(' + row.id + ')" title="View"><i class="icon-pencil7"></i></a></li>' +
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
		"sAjaxSource": 'transfer/read',
		"sAjaxDataProp": "transfer",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[1, "desc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [5]
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

function onView(id) {
	location.href = base_url + 'procurement/transfer/view/' + id;
}