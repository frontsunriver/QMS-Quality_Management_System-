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
                    /*{
                        "sTitle" : "#", "mData": "id","sWidth": 30,
                        mRender: function (data, type, row, pos) {
                            var info = table.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    }, */
                    { "sTitle" : "Monitoring Area", "mData": "area", "sWidth": 200,
                        mRender: function (data, type, row) {
                            var area = '<textarea class="form-control" name="monitoring_area[]" readonly="">' + data + '</textarea>';
                            return area;
                        }
                    },
                    { "sTitle" : "Monitoring Criteria", "mData": "criteria", "sWidth": 200,
                        mRender: function (data, type, row) {
                            var criteria = '<textarea class="form-control" name="monitoring_criteria[]" readonly="">' + data + '</textarea>';
                            return criteria;
                        }
                    },
                    /*{ "sTitle" : "Registration Date", "mData": "reg_date", "sWidth": 100,
                        mRender: function (data, type, row) {
                            var date = data.split(' ')[0];
                            return date;
                        }
                    },*/
                    { "sTitle" : "Verify", "mData": "verify", "sWidth": "10%",
                        mRender: function (data, type, row, pos){
                            var indexcount = Number(pos.row);
                            return "<input type = 'checkbox' name='verify" + indexcount + "' id='verify" + indexcount + "' data-id='" + indexcount + "' onclick='javascript:click_check_verify(" + indexcount + ")' class = 'form-control' required >";
                        }
                    },
                    { "sTitle" : "Nonconformity", "mData": "nonconformity", "sWidth": 40,
                        mRender: function (data, type, row, pos){
                            var indexcount = Number(pos.row);
                            return "<input type = 'checkbox' name='nonconformity" + indexcount + "' id='nonconformity" + indexcount + "' data-id='" + indexcount + "' onclick='javascript:click_check_nonconformity(" + indexcount + ")' class = 'form-control' >";
                        }
                    },
                    { "sTitle" : "Description", "mData": "id", "sWidth": 250,
                        mRender: function (data, type, row, pos){
                            var indexcount = Number(pos.row);
                            return '<textarea class="form-control" name="description[]" id="description' + indexcount + '" readonly required></textarea>';
                        }
                    },
                    {
                        "sTitle" : "Actions", "mData": "", "sWidth": 200,
                        mRender: function (data, type, row) {
                        return  '<ul class="icons-list">' +
                            (ismanager ? '<li><a href="#" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>' : '')+
                            '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                            '</ul>';
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
        paging:false,
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
        $('#form_monitoring input[name="id"]').val('0');
        $('#form_monitoring textarea[name="area"]').val('');
        $('#form_monitoring textarea[name="criteria"]').val('');
        //$('#form_monitoring textarea[name="description"]').val('');
    });
    $('.datatable-monitoring tbody').on('click', 'a[title="Edit"]', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#form_monitoring input[name="id"]').val(data.id);
        $('#form_monitoring textarea[name="area"]').val(data.area);
        $('#form_monitoring textarea[name="criteria"]').val(data.criteria);
        //$('#form_monitoring textarea[name="description"]').val(data.description);

        $('#modal_monitoring').modal('show');
    });

    $('.datatable-monitoring tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post(base_url+'delete_monitoring', params, function(data, status){
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
                    if (form[i].name == 'monitor_status'){
                        if (form[i].checked == true){
                            params[form[i].name] = form[i].value;
                            if (form[i].value == 1){
                                if ($("#description").val() == ""){
                                    new PNotify({
                                        title: 'Notice',
                                        text: "You must enter description.",
                                        icon: 'icon-blocked',
                                        type: 'warning'
                                    });
                                    return;
                                }
                            }
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

function click_check_verify(id){

    var checked = $('#verify' + id).prop("checked");
    $('#nonconformity' + id).prop("checked", (checked ? "" : "checked"));
    change_description_status(id);
}

function click_check_nonconformity(id){

    var checked = $('#nonconformity' + id).prop("checked");
    $('#verify' + id ).prop("checked", (checked ? "" : "checked"));
    change_description_status(id);
}

function change_description_status(id){
    var checked = $('#nonconformity' + id ).prop("checked");
    $('#description' + id).prop("readonly", "");
    $('#description' + id).prop("disabled", (checked ? "" : "disabled"));
    $('input[name="verify' + id + '"').prop("required", "");
}