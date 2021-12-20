var oTable;

$(function(){
	var table = $('.datatable-workcenter').DataTable({
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
		"sAjaxSource": 'workcenter/read',
		"sAjaxDataProp": "workcenter",
		scrollX: true,
		scrollCollapse: true,
		"order": [
			[1, "asc"]
		],
		columnDefs: [{
			orderable: false,
			targets: [4]
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

function onCreate() {
	location.href = base_url + 'manufacture/workcenter/create';
}

function onEdit(id) {
	location.href = base_url + 'manufacture/workcenter/create/' + id;
}

function onDelete(id) {
	 bootbox.confirm("Do you really delete this workcenter?", function(result){
	 	if (result) {
	 		$.post(base_url + 'manufacture/workcenter/delete/' + id, {}, function(resp, status){
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