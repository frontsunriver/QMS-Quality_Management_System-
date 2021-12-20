var oTable, selectedTab;

$(function(){
	var table = $('.datatable-product').DataTable({
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
			"sTitle" : "Product Name", "mData": "product_name", "sWidth": "12%"
		}, {
			sTitle : 'Variant', mData: 'variant', sWidth: '12%'
		}, {
			"sTitle" : "Work Center", "mData": "workcenter_name", "sWidth": "14%"
		}, {
			"sTitle" : "Frequency", "mData": "frequency", "sWidth": "13%"
		}, {
			"sTitle" : "Production Manager", "mData": "responsible_name", "sWidth": "16%"
		}, {
			"sTitle" : "Order Date", "mData": "order_date", "sWidth": "12%"
		}, {
			"sTitle" : "Start Date", "mData": "start_date", "sWidth": "12%"
		}, {
			sTitle : 'Quality Check', mData: 'quality_check', sWidth: '6%', sClass: 'text-center',
			mRender: function(data, type, row) {
				if (data == -1)
					return '<label class="label label-default">None</label>';
				else if (data == -2)
					return '<label class="label label-danger">Fail</label>';
				else if (data == 0)
					return '<label class="label label-warning">Not Created</label>';
				else if (data == 1)
					return '<label class="label label-info">Checking</label>';
			}
		}, {
			"sTitle" : "Status", "mData": "state", "sWidth": "12%",
			mRender: function(data, type, row) {
				if (data < 0)
					return 'PAST DUE ' + (0 - data) + ' days';
				else
					return 'DUE ' + data + ' days';
			}
		}, {
			"sTitle" : "Actions", "mData": "",
			mRender: function (data, type, row) {
				return  '<ul class="icons-list">' +
					'<li><button type="button" class="btn btn-xs bg-blue" onclick="javascript:onManufacturingOrder(' + row.id + ');" ' + (row.active == 0 ? 'disabled' : '') + '>Manufacturing Order</button></li>' +
					'<li><button type="button" class="btn btn-xs bg-blue" onclick="javascript:onClose(' + row.id + ');">Close</button></li>' +
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
		"sAjaxSource": 'plan/read/product',
		"sAjaxDataProp": "product",
		scrollX: true,
		scrollCollapse: true,
		order: [
			[5, 'asc']
		],
		columnDefs: [{
			orderable: false,
			targets: [0, 7, 8, 9, 10]
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

	$('.nav-tabs > li').click(function(){
		var href = $(this).children(0).attr('href');
		selectedTab = href == '#tab1' ? 0 : 1;
	});
});

function onAdd(id) {
	var url = base_url + 'manufacture/plan/add';
	if (id != -1)
		url += '/' + id;

	$('#modal_save .modal-content').load(url, {type: 'product'}, function(){
		var orderDate = $('#order_date').AnyTime_noPicker().AnyTime_picker({
			format: "%Y-%m-%d"
		});

		if ($('#order_date').val() == '')
			orderDate.AnyTime_setCurrent(new Date()).blur();

		$('#modal_save').modal();
	});
}

function onManufacturingOrder(id) {
	location.href = base_url + 'manufacture/manuorder/create?plan_id=' + id;
}

function onClose(id) {
	bootbox.confirm("Do you really close this plan?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/plan/close/' + id, {type: 'product'}, function(resp, status){
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