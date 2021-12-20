<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jasny_bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/col_reorder.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/forms/validation/validate.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->
    <style type="text/css">
        td, th {text-align: center; word-break:keep-all!important;}

        .img-barcode{
            width: 100%;
            height: 120px;
        }

    </style>
</head>

<body class="navbar-top">
<!-- Main navbar -->
<?php $this->load->view('consultant/main_header.php'); ?>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <?php $this->load->view('consultant/sidebar'); ?>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header page-header-default">
                <div class="page-header-content">
                    <div class="page-title">
                        <h4><?php
                            if ($this->session->userdata('consultant_id')) {
                                $consultant_id = $this->session->userdata('consultant_id');
                                $audito1 = $this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

                                $dlogo = $this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

                                if ($audito1->logo == '1') {
                                    $audito = $dlogo;
                                } else {
                                    $audito = $audito1->logo;
                                }
                            }
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?= $audito ?>" style="height:50px;">
                            <span class="text-semibold"><?= $title ?></span>
                            <div class="pull-right">
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i
                                    class="icon-home2 role-left"></i>Home</a></li>
                        <li><a href="#"><?= $title ?></a></li>

                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?=$title?></h5>
                    </div>
                    <div>
                        <button type="button" id="addbtn" class="btn btn-primary pull-right" style="margin-right: 20px;" data-toggle="modal" data-target="#modal_save">
                            ADD</button>
                    </div>

                    <table class="table datatable-customer">
                    </table>
                </div>
                <!-- /basic datatable -->

                <!-- User form modal -->

                <div id="modal_save" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Material Info</h5>
                            </div>
                            <form id="info_form">
                                <input type="hidden" name="id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Name</label>
                                                <input type="text" placeholder="" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>UPC Number</label>
                                                <input type="text" placeholder="" name="upc" class="form-control" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Amount</label>
                                                <input type="text" placeholder="" name="size" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Barcode Information</label>
                                                <input type="text" placeholder="" name="barcode_info" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="scandiv">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a id="btn_scan" class="btn btn-primary form-control" href="javascript:scan()" required>Scan Barcode</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <img class="form-control img-barcode" id="barcode_image" name = "barcode_image" alt = "Bar code Image">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



                <div id="modal_value" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">URL</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="url">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /basic datatable -->

                <!-- Footer -->
                <?php $this->load->view('consultant/footer'); ?>
                <!-- /footer -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<!-- /page container -->

<script type="text/javascript">
    var func_timeout;
    var base_url = "<?=base_url()?>";

    function cancelscan(){
        if (func_timeout) clearInterval(func_timeout);
    }

    function start_scan(id){
        cancelscan();
        func_timeout = setInterval(get_image, 5000);
    }
    function scan(){
        var id = $('input[name="id"]').val();
        $('#url').val("<?php echo  $_SERVER["HTTP_HOST"]."".base_url(); ?>index.php/welcome/upload_barcode/material/" + id);
        $('#modal_value').modal();
        start_scan(id);
    }
    $(function(){
        $('#modal_save').on('hidden.bs.modal', function () {
            cancelscan();
        });
    });

    function get_image(){
        var material_id = $('input[name="id"]').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/consultant/get_barcode_image",
            data:{
                'id' : material_id,
                'type':'material',
            },
            success: function(data) {
                data = JSON.parse(data);
                $("#barcode_image").attr("src","<?php echo base_url(); ?>uploads/file/"+data.barcode_image);
            }
        });
    }

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
        var table = $('.datatable-customer').DataTable({
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
                { "sTitle" : "Name", "mData": "name", "sWidth": 300 },
                { "sTitle" : "UPC Number", "mData": "upc", "sWidth": 100 },
                { "sTitle" : "Amount", "mData": "size", "sWidth": 100 },
                { "sTitle" : "Barcode", "mData": "barcode_info", "sWidth": 100 },
                { "sTitle" : "", "mData": "barcode_image", "sWidth": 100, "visible" : false},
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
            "sAjaxSource": 'material_read',
            "sAjaxDataProp": "material",
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

        $('.datatable-customer tbody').on('click', 'a[title="Edit"]', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#info_form')[0].reset();
            $('#info_form input[name="id"]').val(data.id);
            $('#info_form input[name="name"]').val(data.name);
            $('#info_form input[name="upc"]').val(data.upc);
            $('#info_form input[name="barcode_info"]').val(data.barcode_info);
            $('#info_form input[name="size"]').val(data.size);
            $('#info_form input[name="packaging_type"]').val(data.packaging_type);
            $("#barcode_image").attr("src",base_url + "/uploads/file/"+data.barcode_image);
            $('#scandiv').removeClass('hidden');
            $('#modal_save').modal('show');
        });

        $('.datatable-customer tbody').on('click', 'a[title="Delete"]', function () {
            var tr = $(this).parents('tr');
            var data = table.row(tr).data();
            bootbox.confirm("Are you sure?", function(result) {
                if (result) {
                    var params = {
                        'id' : data.id
                    };
                    $.post('delete_material', params, function(data, status){
                        if (status == "success") {
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
            rules: {
                email: {
                    email: true,
                    required: true
                }
            },
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
                $.post('edit_material', params, function(data, status){
                    if (data != "") {
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
            $('#scandiv').addClass('hidden');
            $("#barcode_image").attr("");
        });

    });

</script>
</body>
</html>
