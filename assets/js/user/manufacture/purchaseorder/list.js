var oTable;

$(function(){
	var table = $('.datatable-purchaseorder').DataTable({
		"bServerSide" : true,
		"bProcessing" : true,
		"aoColumns" : [{
			"sTitle" : "No",
			"mData" : "",
			"sWidth": "90",
			mRender: function (data, type, row, pos) {
				var info = table.page.info();
				return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
			}
		}, {
			"sTitle" : "Purchase Number", "mData": "purchase_num", "sWidth": "170"
		}, {
			"sTitle" : "Order Date", "mData": "order_date", "sWidth": ""
		}, {
			"sTitle" : "Warehouse", "mData": "warehouse_name", "sWidth": ""
		}, {
			"sTitle" : "Purchase Representative", "mData": "purchase_representative", "sWidth": ""
		}, {
			"sTitle" : "Description", "mData": "description",
			mRender: function(data, type, row) {
				return row.description == '' ? '' : row.description.substr(0, 30) + '...';
			}
		}, {
			"sTitle" : "Amount", "mData": "total"
		}, {
			"sTitle" : "State", "mData": "state",
			mRender: function(data, type, row) {
				if (row.state == 0)
					return '<label class="label label-danger" style="margin-bottom: 0px;">Purchase Order</label>';
				else
					return '<label class="label label-success" style="margin-bottom: 0px;">Done Order</label>';
			}
		}, {
			"sTitle" : "Actions", "mData": "",
			mRender: function (data, type, row) {
				if (row.state == 0)
					return  '<ul class="icons-list">' +
						'<li><a class="text-primary-600" href="#" onclick="javascript:onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
						// '<li><a class="text-danger-600" href="#" onclick="javascript:onDelete(' + row.id + ')" title="Delete"><i class="icon-trash"></i></a></li>' +
						'</ul>';
				else
					return  '<ul class="icons-list">' +
						'<li><a class="text-primary-600" href="#" onclick="javascript:onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
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
		"sAjaxSource": 'purchaseorder/read',
		"sAjaxDataProp": "purchase_order",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[1, "asc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [7]
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
	location.href = base_url + '/manufacture/purchaseorder/create/' + id;
}

function onDelete(id) {
	bootbox.confirm("Do you really delete this Purchase Order?", function(result){
		if (result) {
			$.post(base_url + '/manufacture/purchaseorder/delete/' + id, {}, function(resp, status){
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