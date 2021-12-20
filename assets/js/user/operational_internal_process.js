$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
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

    // Generate content for a column
    var table1 = $('.datatable-internal').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "aoColumns": [
                    {
                        "sTitle" : "#", "mData": "","sWidth": 30,
                        mRender: function (data, type, row, pos) {
                            var info = table1.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    }, 
                    { "sTitle" : "Name", "mData": "name", "sWidth": 200 },
                    { "sTitle" : "Description", "mData": "description", "sWidth": 400 },
                    { "sTitle" : "Process Owner", "mData": "process_owner_name", "sWidth": 200 },
                    {
                        "sTitle" : "Actions", "mData": "", "sWidth": 300,
                        mRender: function (data, type, row) {
                            if (user_type == "monitor"){
                                return  '<ul class="icons-list">' +
                                    '<li><a href="'+base_url+'select_sme/'+row.id+'" class="btn btn-primary btn-sm" style="color: white;" title="Analyse">Analyse</a></li>' +
                                    '</ul>';
                            }else{
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                                    '<li><a href="'+base_url+'select_sme/'+row.id+'" class="btn btn-primary btn-sm" style="color: white;" title="Analyse">Analyse</a></li>' +
                                    '</ul>';
                            }
                        }
                    }
        ],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "risk_id", "value": risk_id});
            aoData.push({"name": "flag", "value": '1'});
            return aoData;
        },
        "fnServerData": function (sSource, aoData, fnCallback){
            $.ajax({
                "dataType": "json",
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback
            });
        },
        "bAutoWidth": true,
        "sAjaxSource": base_url+'operational_process_read',
        "sAjaxDataProp": "processes",
        scrollX: true,
        scrollCollapse: true,
        "order": [
            [1, "asc"]
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ideferLoading": 1,
        "bDeferRender": true,
        buttons: {
            buttons: [
                {
                    extend: 'csv',
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    text: 'CSV',
                    className: 'btn btn-default'
                }, {
                    extend: 'colvis',
                    text: '<i class="icon-three-bars"></i> <span class="caret"></span>',
                    className: 'btn bg-blue btn-icon',
                }                
            ]
        },
        initComplete: function () {
            oTable1 = this;
        }
    });
    $('#new_internal_process').click(function () {
        $('#form_process')[0].reset();
        $('#form_process input[name="id"]').val('0');
        $('#form_process input[name="flag"]').val('1');
        $('#form_process input[name="name"]').val('');
        $('#form_process textarea[name="description"]').val('');
        $('#form_process select[name="process_owner"]').val('');
        $('#modal_process').modal('show');
    });

    $('.datatable-internal tbody').on('click', 'a[title="Edit"]', function () {
        var data = table1.row($(this).parents('tr')).data();
        $('#form_process')[0].reset();
        $('#form_process input[name="id"]').val(data.id);
        $('#form_process input[name="name"]').val(data.name);
        $('#form_process textarea[name="description"]').val(data.description);
        $('#form_process select[name="process_owner"]').val(data.process_owner);

        $('#modal_process').modal('show');
    });

    $('.datatable-internal tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table1.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post(base_url+'delete_operational_process', params, function(data, status){
                    if (JSON.parse(data)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Removed.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        oTable1.api().ajax.url(oTable1.fnSettings().sAjaxSource).load();
                        // oTable1.fnDeleteRow(tr);
                    } else {
                        new PNotify({
                            title: 'Error',
                            text: 'Failed.',
                            icon: 'icon-blocked',
                            type: 'error'
                        });
                    }
                });
            }
        });
    });

    // Adjust columns on window resize
    setTimeout(function() {
        $(window).on('resize', function () {
            table1.columns.adjust();
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
