var oTable;

$(function(){
	var table = $('.datatable-shiporder').DataTable({
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
			"sTitle" : "Reference", "mData": "reference", "sWidth": "15%"
		}, {
			"sTitle" : "Destination Location", "mData": "warehouse_name", "sWidth": "15%"
		}, {
			"sTitle" : "Partner", "mData": "customer_name", "sWidth": "15%"
		}, {
			"sTitle" : "Scheduled Date", "mData": "create_at", "sWidth": "15%"
		}, {
			"sTitle" : "Source Document", "mData": "src_doc", "sWidth": "15%"
		}, {
			"sTitle" : "Status", "mData": "state", "sWidth": "10%",
			mRender: function(data, type, row) {
				if (data == 0)
					return '<label class="label label-danger" style="margin-bottom: 0px; cursor: pointer;">Waiting Another Operation</label>';
				else if (data == 1)
					return '<label class="label label-warning" style="margin-bottom: 0px;"></label>';
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
		"sAjaxSource": 'shiporder/read',
		"sAjaxDataProp": "shiporder",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[2, "desc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [0]
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