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

    var oTable;

    // Generate content for a column
    var table = $('.datatable-risk').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "aoColumns": [
                    {
                        "sTitle" : "#", "mData": "","sWidth": 30,
                        mRender: function (data, type, row, pos) {
                            var info = table.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    }, 
                    { "sTitle" : "Hazard Source", "mData": "name", "sWidth": 180 },
                    { "sTitle" : "Assessment Type", "mData": "assess_type", "sWidth": 120 },
                    { "sTitle" : "Description", "mData": "description", "sWidth": 350 },
                    { "sTitle" : "Detail and Technical Data", "mData": "detail", "sWidth": 150 },
                    {
                        "sTitle" : "Risk Type", "mData": "risk_type", "sWidth": 100,
                        mRender: function (data, type, row) {
                            if (row.risk_type == 0) {
                                return "Strategic Risk";
                            }else if (row.risk_type == 1){
                                return "Operational Risk";
                            }else if (row.risk_type == 2){
                                return "Prerequisite Program(PRP)";
                            }else if (row.risk_type == 3){
                                return "FSSC Additional Requirement";
                            }
                        }
                    },
                    { "sTitle" : "Status", "mData": "status", "sWidth": 50,
                        mRender: function (data, type, row) {
                            if (row.status == 0) {
                                return "OPEN";
                            }else if (row.status == 1){
                                return "CLOSE";
                            }
                        }
                    },
                    {
                        "sTitle" : "Actions", "mData": "", "sWidth": 200,
                        mRender: function (data, type, row) {
                            if (user_type == "consultant" && row.status == 0){
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Close">Close</a></li>' +
                                    '</ul>';
                            }else if (user_type == "consultant" && row.status == 1){
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                                    '</ul>';
                            }else{
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" type="button" title="View" class="btn btn-primary btn-sm" style="color: white;">View</a></li>' +
                                    '</ul>';
                            }
                        }
                    }
        ],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "type", "value": type});
            aoData.push({"name": "status", "value": status});
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
        "sAjaxSource": 'risk_read',
        "sAjaxDataProp": "risks",
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: {
            leftColumns: 2
        },
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
                    className: 'btn btn-default',
                    exportOptions: {
                        columns: ':visible',
                        orthogonal: 'fullNotes'
                    }
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
    $('#type').on('change', function () {
        type = $('#type').val();
        oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
    });
    $('#status').on('change', function () {
        status = $('#status').val();
        oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
    });

    $('.datatable-risk tbody').on('click', 'a[title="Edit"]', function () {
        var data = table.row($(this).parents('tr')).data();
        //$('#form_edit')[0].reset();
        $('#form_edit input[name="id"]').val(data.id);
        $('#form_edit input[name="name"]').val(data.name);
        $('#form_edit textarea[name="description"]').html(data.description);
        $('#form_edit textarea[name="detail"]').html(data.detail);

        $('#modal_edit').modal('show');
    });
    $('.datatable-risk tbody').on('click', 'a[title="View"]', function () {
        var data = table.row($(this).parents('tr')).data();
        location.href = base_url+'rating_matrix/'+data.id;
    });

    $('.datatable-risk tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post('risk_delete', params, function(data, status){
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
    $('.datatable-risk tbody').on('click', 'a[title="Close"]', function () {
        var tr = $(this).parents('tr');
        var data = table.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post('risk_close', params, function(data, status){
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

    $('#new_risk').click(function () {
        //$('#form_user')[0].reset();
        $('#form_user img[name="user_icon"]').attr("src","");
        $('#form_user input[name="id"]').val('');
    });

    // Setup validation
    // ------------------------------

    // Initialize
    var validator = $("#form_risk").validate({
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
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            detail: {
                required: true
            }
        },
        submitHandler: function (form) {
            var params={};
            var check_post = "";
            for (i=0; i<form.length; i++) {
                if (form[i].name != '') {
                    if (form[i].name == 'assess_type'){
                        if (form[i].checked == true){
                            check_post = check_post+","+form[i].value;
                        }
                    }else if (form[i].name == 'risk_type'){
                        if (form[i].checked == true){
                            params["risk_type"] = form[i].value;
                        }
                    }else if (form[i].name == 'type_flag') {
                        if (form[i].checked == true) {
                            params["type_flag"] = form[i].value;
                        }
                    }else{
                        params[form[i].name] = form[i].value;
                    }
                }
            }
            params["assess_type"] = check_post;
            if (params["assess_type"] == '0' || params["assess_type"] == ''){
                new PNotify({
                    title: 'Error',
                    text: 'You must select assesment type.',
                    icon: 'icon-blocked',
                    type: 'error'
                });
                return;
            }else{
                $.post('add_risk', params, function(data, status){
                    $('#modal_risk').modal('hide');
                    var temp = JSON.parse(data);
                    var id = temp['id'];
                    location.href = 'rating_matrix/'+id;
                });
            }
        }
    });
    var validator1 = $("#form_edit").validate({
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
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            detail: {
                required: true
            }
        },
        submitHandler: function (form) {
            var params={};
            for (i=0; i<form.length; i++) {
                if (form[i].name != '') {
                    params[form[i].name] = form[i].value;
                }
            }
            $.post('edit_risk', params, function(data, status){
                if (data.indexOf("success") >= 0) {
                    form.reset();
                    oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                    $('#modal_edit').modal('hide');
                    location.href = 'rating_matrix/'+params['id'];
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
    
});
