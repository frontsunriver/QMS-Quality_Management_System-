var oTable;
var selectedTab;

$(function(){
	var table = $('.datatable-material').DataTable({
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
			"sTitle" : "Material Name", "mData": "material_name", "sWidth": "18%"
		}, {
			"sTitle" : "Warehouse", "mData": "warehouse_name", "sWidth": "18%"
		}, {
			"sTitle" : "Remain Quantity", "mData": "remain_quantity", "sWidth": "15%"
		}, {
			"sTitle" : "Demand Quantity", "mData": "demand_quantity", "sWidth": "14%"
		}, {
			"sTitle" : "Frequency", "mData": "frequency", "sWidth": "12%"
		}, {
			"sTitle" : "Order Date", "mData": "order_date", "sWidth": "12%"
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
					'<li><button type="button" class="btn btn-xs bg-blue" onclick="javascript:onTransfer(' + row.id + ');">Transfer</button></li>' +
					'<li><button type="button" class="btn btn-xs bg-blue" onclick="javascript:onMakePurchaseOrder(' + row.id + ');">Make Purchase Order</button></li>' +
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
		"sAjaxSource": 'plan/read/material',
		"sAjaxDataProp": "material",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[6, "asc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [0, 3, 7, 8]
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

	$('#modal_save .modal-content').load(url, {type: 'material'}, function(){
		var orderDate = $('#order_date').AnyTime_noPicker().AnyTime_picker({
			format: "%Y-%m-%d"
		});

		if ($('#order_date').val() == '')
			orderDate.AnyTime_setCurrent(new Date()).blur();

		$('#add_form').validate({
			ignore: 'input[type=hidden]',
			errorClass: 'validation-error-label',
			successClass: 'validation-valid-label',
			highlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},
			unhighlight: function(element, errorClass) {
				$(element).removeClass(errorClass);
			},
			validClass: "validation-valid-label",
			rules: {
				'plan[demand_quantity]': { required: true }
			}
		});

		$('#modal_save').modal();
	});
}


function onClose(id) {
	bootbox.confirm("Do you really close this plan?", function(result){
		if (result) {
			$.post(base_url + 'manufacture/plan/close/' + id, {type: 'material'}, function(resp, status){
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

function onMakePurchaseOrder(id) {
	location.href = base_url + 'manufacture/purchaseorder/create?plan_id=' + id;
}

function onTransfer(id) {

}