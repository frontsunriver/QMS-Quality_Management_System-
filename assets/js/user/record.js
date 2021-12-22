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
    var table = $('.datatable-record').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "aoColumns": [
                    {
                        "sTitle" : "NO", "mData": "","sWidth": 100,
                        mRender: function (data, type, row, pos) {
                            var info = table.page.info();
                            return Number(info.page) * Number(info.length) + Number(pos.row) + 1;
                        }
                    },
                    { "sTitle" : "name", "mData": "name", "sWidth": 100 },
                    { "sTitle" : "Description", "mData": "description", "sWidth": 200 },
                    //{ "sTitle" : "Number", "mData": "number", "sWidth": 200 },
                    { "sTitle" : "Active Date", "mData": "version_date", "sWidth": 180},
                    { "sTitle" : "Review Date", "mData": "revision_date", "sWidth": 180},
                    { "sTitle" : "File", "mData": "file_path", "sWidth": 180,
                        mRender: function (data, type, row) {
                            if (row.file_path != null && row.file_path != ''){
                                return  '<a href="'+base_url+'uploads/Doc/'+row.file_path+'" target="download"><i class="icon-download " aria-hidden="true"></i>Download</a>';
                            }else{
                                return '';
                            }
                        }
                    },
                    { "sTitle" : "Text", "mData": "content", "sWidth": 150,
                        mRender: function (data, type, row) {
                            if (row.file_path != null && row.file_path != ''){
                                return '';
                            }else{
                                return  '<a class="btn btn-primary btn-sm" style="color: white;" title="Detail">Detail</a>';
                            }
                        }
                    },
                    {
                        "sTitle" : "Actions", "mData": "",
                        mRender: function (data, type, row) {
                            if(userType == 'consultant') {
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Control">Control</a></li>' +
                                    '</ul>';    
                            }else {
                                return  '<ul class="icons-list">' +
                                    '<li><a href="#" class="btn btn-primary btn-sm" style="color: white;" title="Control">Control</a></li>' +
                                    '</ul>';
                            }
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
        "sAjaxSource": 'record_read',
        "sAjaxDataProp": "record",
        scrollX: false,
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

    $('.datatable-record tbody').on('click', 'a[title="Edit"]', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#info_form')[0].reset();
        $('#info_form input[name="id"]').val(data.id);
        $('#info_form input[name="name"]').val(data.name);
        $('#info_form input[name="version_date"]').val(data.version_date);
        $('#info_form input[name="revision_date"]').val(data.revision_date);
        $('#info_form textarea[name="description"]').val(data.description);
        $('#info_form input[name="number"]').val(data.number);
        file_path = data.file_path;
        $('#modal_save').modal('show');
    });
    $('.datatable-record tbody').on('click', 'a[title="Detail"]', function () {
        var data = table.row($(this).parents('tr')).data();
        $("#edit_id").val(data.id);
        editor.setData(data.content);
        //if (CKEDITOR.instances['content']){
        //    //CKEDITOR.instances['content'].destroy();
        //    CKEDITOR.instances['content'].refresh();
        //}
        //$("#content").html(data.content);
        //CKEDITOR.replace('content',
        //    {
        //        fullPage : true,
        //        // extraPlugins : 'docprops'
        //    });
        $("#modal_content").modal();
    });

    $('.datatable-record tbody').on('click', 'a[title="Delete"]', function () {
        var tr = $(this).parents('tr');
        var data = table.row(tr).data();
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'ids' : data.id
                };
                $.post('record_delete', params, function(data, status){
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
            var file = $('input[name="file_name"]')[0].files[0];
            var A = new FormData();
            for (i=0; i<form.length; i++) {
                if (form[i].name != '') {
                    if(form[i].name == "share"){
                        A.append(form[i].name, $(form[i]).is(':checked') ? 1 : 0);
                    } else{
                        A.append(form[i].name, form[i].value);
                    }
                }
            }
            if (file) {
                A.append("file", file);
            }
            var C = new XMLHttpRequest();
            C.open("POST", 'record_save');
            C.onload = function() {
                var E;
                E = C.responseText;
                $('#modal_save').modal('hide');
                if (JSON.parse(E)['success'] > 0) {
                    new PNotify({
                        title: 'Success',
                        text: 'Successfully Saved.',
                        icon: 'icon-checkmark3',
                        type: 'success'
                    });
                    form.reset();
                    oTable.api().ajax.url(oTable.fnSettings().sAjaxSource).load();

                    if (!file && file_path == "") {
                        $('#edit_id').val(JSON.parse(E)['success']);
                        editor.setData("");
                        $('#modal_content').modal();
                    }
                } else if (E == "FAILED") {
                    new PNotify({
                        title: 'Error',
                        text: 'Failed.',
                        icon: 'icon-blocked',
                        type: 'error'
                    });
                }
                return;
            };
            C.send(A);
        }
    });

    $('#addbtn').click(function () {
        $('#info_form')[0].reset();
        $('#info_form input[name="id"]').val(0);
    });

});
