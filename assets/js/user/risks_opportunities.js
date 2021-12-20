$(function() {


    // Table setup
    // ------------------------------
    var type = $('#type').val();
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

    var oTable;
    // Generate content for a column
    var table = $('.datatable-risks-opportunities').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "aoColumns": [
                    {
                        "sTitle" : "NO", "mData": "","sWidth": 30,
                        mRender: function (data, type, row, pos) {
                            var info = table.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    },
                    { "sTitle" : "Likelihood", "mData": "name", "sWidth": 120 },
                    { "sTitle" : "Risk", "mData": "risk", "sWidth": 120 },
                    { "sTitle" : "Opportunity", "mData": "opportunity", "sWidth": 350 },
                    {
                        "sTitle" : "Actions", "mData": "",
                        mRender: function (data, type, row) {
                            return  '<ul class="icons-list">' +
                                        '<li><a href="#" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>' +
                                        '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                                    '</ul>';
                        }
                    }
        ],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "type", "value": type});
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
        "bAutoWidth": false,
        "sAjaxSource": 'risks_opportunities_read',
        "sAjaxDataProp": "risks_opportunities",
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
            oTable = this;
        }
    });

    $('.datatable-risks-opportunities tbody').on('click', 'a[title="Edit"]', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#info_form')[0].reset();
        $('#info_form input[name="id"]').val(data.id);
        $('#info_form input[name="name"]').val(data.name);
        $('#info_form input[name="risk"]').val(data.risk);
        $('#info_form input[name="opportunity"]').val(data.opportunity);
        $('#modal_save').modal('show');
    });

    $('.datatable-risks-opportunities tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post('risks_opportunities_delete', params, function(data, status){
                    if (JSON.parse(data)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Removed.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                        // oTable.fnDeleteRow(tr);
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



    // Setup validation
    // ------------------------------

    // Initialize

    var validator1 = $("#info_form").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'validation-error-label',
        successClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        validClass: "validation-valid-label",
        success: function(label) {
            label.addClass("validation-valid-label").text("Success.")
        },
        submitHandler: function (form) {
            var params={};
            for (i=0; i<form.length; i++) {
                if (form[i].name != '') {
                    params[form[i].name] = form[i].value;
                }
            }
            $.post('risks_opportunities_save', params, function(data, status){
                if (data.success) {
                    new PNotify({
                        title: 'Success',
                        text: 'Successfully Saved.',
                        icon: 'icon-checkmark3',
                        type: 'success'
                    });
                    form.reset();
                    oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                    $('#modal_save').modal('hide');
                } else {
                    new PNotify({
                        title: 'Error',
                        text: data.message,
                        icon: 'icon-blocked',
                        type: 'error'
                    });
                }
            });
        }
    });

    $('#addbtn').click(function () {
        $('#info_form')[0].reset();
        $('#info_form input[name="id"]').val(0);
    });

});