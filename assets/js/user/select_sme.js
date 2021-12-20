$(function() {

    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        colReorder: true,
        dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
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
    var table = $('.datatable-sme').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "aoColumns": [
                    {
                        "sTitle" : "#", "mData": "","sWidth": 50,
                        mRender: function (data, type, row, pos) {
                            var info = table.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    },
                    {
                        "sTitle" : "Check", "mData": "","sWidth": 100,
                        mRender: function (data, type, row) {
                            if (row.flag == 1){
                                return "<input type = 'checkbox' class='check_post' name = 'check_post' value='"+row.employee_id+"' checked>";
                            }else{
                                return "<input type = 'checkbox' class='check_post' name = 'check_post' value='"+row.employee_id+"'>";
                            }
                        }
                    },
                    { "sTitle" : "Name", "mData": "employee_name", "sWidth": 200 },
                    { "sTitle" : "Email", "mData": "employee_email", "sWidth": 200 }
        ],
        "fnServerParams": function (aoData) {
            aoData.push({"name": "process_id", "value": process_id});
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
        "sAjaxSource": base_url + 'select_sme_read',
        "sAjaxDataProp": "smes",
        scrollX: true,
        scrollCollapse: true,
        "order": [
            [1, "desc"]
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
    // Adjust columns on window resize
    setTimeout(function() {
        $(window).on('resize', function () {
            table.columns.adjust();
        });
    }, 100);

    // External table additions
    // ------------------------------

    // Launch Uniform styling for checkboxes
    $('.ColVis_Button').addClass('btn btn-primary btn-icon').on('click mouseover', function() {
        $('.ColVis_collection input').uniform();
    });    

    //var validator = $("#change_form").validate({
    //    ignore: 'input[type=hidden]', // ignore hidden fields
    //    errorClass: 'validation-error-label',
    //    successClass: 'validation-valid-label',
    //    highlight: function(element, errorClass) {
    //        $(element).removeClass(errorClass);
    //    },
    //    unhighlight: function(element, errorClass) {
    //        $(element).removeClass(errorClass);
    //    },
    //    validClass: "validation-valid-label",
    //    success: function(label) {
    //        label.addClass("validation-valid-label").text("Success.")
    //    },
    //    submitHandler: function (form) {
    //        var params={};
    //        var check_post = "";
    //        for (i=0; i<form.length; i++) {
    //            if (form[i].name != '') {
    //                if (form[i].name == 'check_post'){
    //                    if (form[i].checked == true){
    //                        check_post = check_post+","+form[i].value;
    //                    }
    //                }else{
    //                    params[form[i].name] = form[i].value;
    //                }
    //            }
    //        }
    //        params["check_post"] = check_post;
    //        $.post(base_url + 'add_select', params, function(data, status){
    //            if (data.success) {
    //                new PNotify({
    //                    title: 'Success',
    //                    text: 'Successfully Updated.',
    //                    icon: 'icon-checkmark3',
    //                    type: 'success'
    //                });
    //                form.reset();
    //                oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();
    //            } else {
    //                new PNotify({
    //                    title: 'Error',
    //                    text: data.message,
    //                    icon: 'icon-blocked',
    //                    type: 'error'
    //                });
    //            }
    //        });
    //    }
    //});
});
