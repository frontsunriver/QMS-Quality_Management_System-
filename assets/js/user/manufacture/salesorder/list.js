var oTable;

$(function() {
    var table = $('.datatable-salesorder').DataTable({
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
            "sTitle" : "Order Number", "mData": "salesorder_num", "sWidth": "20%"
        }, {
            "sTitle" : "Customer", "mData": "customer_name", "sWidth": "20%"
        }, {
            "sTitle" : "Salesperson", "mData": "salesperson_email", "sWidth": "20%"
        }, {
            "sTitle" : "Total Price", "mData": "total", "sWidth": "15%"
        }, {
            "sTitle" : "Status", "mData": "state", "sWidth": "10%",
            mRender: function(data, type, row) {
                if (data == 0)
                    return '<label class="label label-danger" style="margin-bottom: 0px; cursor: pointer;" onclick="javascirpt:onEdit(' + row.id + ')">Sales Order</label>';
                return '<label class="label label-success" style="margin-bottom: 0px;">Sales Done</label>';
            }
        }, {
            "sTitle" : "Actions", "mData": "state",
            mRender: function (data, type, row) {
                return '<ul class="icons-list">' +
                    '<li><a class="text-primary-600" href="#" onclick="javascript:onDetail(' + row.id + ')" title="Detail"><i class="icon-pencil7"></i></a></li>' +
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
        "sAjaxSource": 'salesorder/read',
        "sAjaxDataProp": "salesorder",
        scrollX: true,
        scrollCollapse: true,
        "order": [
            [1, "desc"]
        ],
        columnDefs: [{
            orderable: false,
            targets: [0, 5, 6]
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

    $('[data-plugin-selectTwo]').each(function() {
        var $this = $( this ),
            opts = {};

        var pluginOptions = $this.data('plugin-options');
        if (pluginOptions)
            opts = pluginOptions;

        $this.themePluginSelect2(opts);
    });
});

function onDetail(id) {
    location.href = base_url + 'manufacture/salesorder/create/' + id;
}