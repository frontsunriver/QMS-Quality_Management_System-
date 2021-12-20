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
    var table = $('.datatable-monitoring').DataTable({
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
                    { "sTitle" : "Monitoring Area", "mData": "area", "sWidth": 200 },
                    { "sTitle" : "Monitoring Criteria", "mData": "criteria", "sWidth": 200 },
                    { "sTitle" : "Registration Date", "mData": "reg_date", "sWidth": 100,
                        mRender: function (data, type, row) {
                            var date = data.split(' ')[0];
                            return date;
                        }
                    },
                    { "sTitle" : "Checkbox to verify", "mData": "status", "sWidth": 70,
                        mRender: function (data, type, row){
                            if (row.status == 0){
                                return "<input type = 'checkbox' class = 'form-control' checked disabled>";
                            }else{
                                return "<input type = 'checkbox' class = 'form-control' disabled>";
                            }
                        }
                    },
                    { "sTitle" : "Checkbox if Nonconformity is Found", "mData": "status", "sWidth": 100,
                        mRender: function (data, type, row){
                            if (row.status == 1){
                                return "<input type = 'checkbox' class = 'form-control' checked disabled>";
                            }else{
                                return "<input type = 'checkbox' class = 'form-control' disabled>";
                            }
                        }
                    },
                    { "sTitle" : "Description", "mData": "description", "sWidth": 250 },
                    {
                        "sTitle" : "Actions", "mData": "status", "sWidth": 200,
                        mRender: function (data, type, row) {
                            if (row.status == 1){
                                return  '<ul class="icons-list">' +
                                    '<li><a href="'+base_url+'corrective_action_form/'+row.id+'" type="button" title="Load" class="btn btn-primary btn-sm" style="color: white;">Load</a></li>' +
                                    '</ul>';
                            }else{
                                return '';
                            }
                        }
                    }
        ],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "control_id", "value": control_id});
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
        "sAjaxSource": base_url+'monitoring_read',
        "sAjaxDataProp": "monitorings",
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
    $('#new_control').click(function () {
        $('#form_control input[name="id"]').val('0');
        $('#form_control input[name="name"]').val('');
        $('#form_control textarea[name="plan"]').val('');
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
    var validator = $("#form_monitoring").validate({
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
                    if (form[i].name == 'verify'){
                        if (form[i].checked == true){
                            params[form[i].name] = "1";
                        }else{
                            params[form[i].name] = "0";
                        }
                    }else if (form[i].name == 'nonconformity'){
                        if (form[i].checked == true){
                            params[form[i].name] = "1";
                        }else{
                            params[form[i].name] = "0";
                        }
                    }else{
                        params[form[i].name] = form[i].value;
                    }
                }
            }
            $.post(base_url+'add_monitoring', params, function(data, status){
                if (data.indexOf("success")>=0){
                    new PNotify({
                        title: 'Success',
                        text: 'Successfully Updated.',
                        icon: 'icon-checkmark3',
                        type: 'success'
                    });
                    form.reset();
                    oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
                }else{
                    new PNotify({
                        title: 'Error',
                        text: data,
                        icon: 'icon-blocked',
                        type: 'error'
                    });
                }
                $('#modal_monitoring').modal('hide');
            });
        }
    });
    
});
