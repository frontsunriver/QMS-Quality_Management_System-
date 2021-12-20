var oTable;

$(function() {
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        colReorder: true,
        dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Search Name:</span> _INPUT_',
            searchPlaceholder: 'Type to filter...',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });

    var table = $('.table-ship').DataTable({
        "bServerSide" : true,
        "bProcessing" : true,
        "aoColumns" :
        [
            {
            "sTitle" : "Reference","mData" : "no"
            },
            {
            "sTitle" : "Destination Location", "mData": "des_location"
            },
            {
            "sTitle" : "Partner", "mData": "partner"
            },
            {
            "sTitle" : "Scheduled Date", "mData": "scheduled_date"
            },
            {
            "sTitle" : "Status", "mData": "",
                mRender: function(data, type, row) {
                    return row.status === 0 ? 'Waiting Another Operation' : 'Cancelled';
                }
            },
            {
            "sTitle" : "Actions", "mData": "",
                mRender: function (data, type, row) {
                    if (row.status === 0)
                        return  '<ul class="icons-list">' +
                            '<li><a class="text-primary-600" href="#" onclick="onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
                            '<li><a class="text-danger-600" href="#" onclick="onDelete(' + row.id + ')" title="Delete"><i class="icon-trash"></i></a></li>' +
                            '</ul>';
                    else
                        return  '<ul class="icons-list">' +
                            '<li><a class="text-primary-600" href="#" onclick="onEdit(' + row.id + ')" title="Edit"><i class="icon-pencil7"></i></a></li>' +
                            '</ul>';
                }
            }
        ],
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
        "sAjaxSource": 'ship/read',
        "sAjaxDataProp": "ship_order",
        scrollX: true,
        scrollCollapse: true,
        "order": [
            [1, "asc"]
        ],
        columnDefs: [{
            orderable: false,
            targets: [5]
        }],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ideferLoading": 1,
        "bDeferRender": true,
        buttons: {
            buttons: []
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
    location.href = base_url + 'warehouse/ship/create';
}

function onEdit(id) {
    location.href = base_url + 'warehouse/ship/create/' + id;
}

function onDelete(id) {
    bootbox.confirm("Do you really delete this Ship Order?", function(result){
        if (result) {
            $.post(base_url + 'warehouse/ship/delete/' + id, {}, function(resp, status){
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