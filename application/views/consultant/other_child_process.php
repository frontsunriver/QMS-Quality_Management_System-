<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Process</title>
<!--    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
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
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/bootbox.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->

    <script type="text/javascript">
        $(function() {
            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    orderable: false,
                    width: '150px'
                }],
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
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

            // Basic datatable
            $('.datatable-basic').DataTable({
                order: [1,"desc"]
            });

            // Alternative pagination
            $('.datatable-pagination').DataTable({
                pagingType: "simple",
                language: {
                    paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
                }
            });

            // Datatable with saving state
            $('.datatable-save-state').DataTable({
                stateSave: true
            });

            // Scrollable datatable
            $('.datatable-scroll-y').DataTable({
                autoWidth: true,
                scrollY: 300
            });

            // External table additions
            // ------------------------------

            // Enable Select2 select for the length option
//            $('.dataTables_length select').select2({
//                minimumResultsForSearch: Infinity,
//                width: 'auto'
//            });
        });
    </script>
    <style>
        th{
            text-align: center;
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
                            <span class="text-semibold">Process</span>
                            <div class="pull-right">
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i
                                    class="icon-home2 role-left"></i>Home</a></li>

                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <form id="get_process_list" action = "<?php echo  base_url(); ?>index.php/Consultant/get_other_child_process" method="post">
                <input type="hidden" id="outsource_id" name="outsource_id" value="<?=$outsource_id?>">
            </form>
            <!-- /page header -->

            <!-- Content area -->
            <div class="content">
                <!-- Basic datatable -->
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">Input Step</span>
                        </div>
                        <div class="col-md-12">
                            <?php if ($user_type == "consultant"): ?>
                                <a onclick="add('input')" style="float: right;margin-right: 10px;" class="btn btn-primary">New</a>
                            <?php endif;?>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-input">
                        <thead>
                        <tr>
                            <th >No</th>
                            <th >Process Step</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th >Potential Haz <?=$row?></th>
                            <?php endforeach; ?>
                            <th style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($processes as $row): ?>
                            <?php if ($row->flag == "input"): ?>
                                <?php $count = 1;?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$row->process_step?></td>
                                    <?php foreach ($assess_type as $item): ?>
                                        <td>
                                            <?php
                                                switch ($item){
                                                    case 'Food':
                                                        echo $row->food;
                                                        break;
                                                    case 'Environmental':
                                                        echo $row->environmental;
                                                        break;
                                                    case 'TACCP':
                                                        echo $row->TACCP;
                                                        break;
                                                    case 'Quality':
                                                        echo $row->quality;
                                                        break;
                                                    case 'Safety':
                                                        echo $row->safety;
                                                        break;
                                                    case 'VACCP':
                                                        echo $row->VACCP;
                                                        break;
                                                }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>

                                    <td>
                                        <ul class="icons-list">
                                            <?php if ($user_type != "monitor"):?>
                                                <li><a href="#" onclick="edit(<?=$row->id?>,'input')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                                <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                            <?php endif;?>
                                            <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>" class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php $count++;?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">Activity</span>
                        </div>
                        <div class="col-md-12">
                            <?php if ($user_type == "consultant"): ?>
                                <a onclick="add('activity')" style="float: right;margin-right: 10px;" class="btn btn-primary">New</a>
                            <?php endif;?>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-activity">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Process Step</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th>Potential Haz <?=$row?></th>
                            <?php endforeach; ?>
                            <th style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($processes as $row): ?>
                            <?php if ($row->flag == "activity"): ?>
                                <?php $count = 0;?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$row->process_step?></td>
                                    <?php foreach ($assess_type as $item): ?>
                                        <td>
                                            <?php
                                            switch ($item){
                                                case 'Food':
                                                    echo $row->food;
                                                    break;
                                                case 'Environmental':
                                                    echo $row->environmental;
                                                    break;
                                                case 'TACCP':
                                                    echo $row->TACCP;
                                                    break;
                                                case 'Quality':
                                                    echo $row->quality;
                                                    break;
                                                case 'Safety':
                                                    echo $row->safety;
                                                    break;
                                                case 'VACCP':
                                                    echo $row->VACCP;
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <ul class="icons-list">
                                            <?php if ($user_type != "monitor"):?>
                                                <li><a href="#" onclick="edit(<?=$row->id?>,'activity')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                                <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                            <?php endif;?>
                                            <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>" class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php $count++;?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">Output</span>
                        </div>
                        <div class="col-md-12">
                            <?php if ($user_type == "consultant"): ?>
                                <a onclick="add('output')" style="float: right;margin-right: 10px;" class="btn btn-primary">New</a>
                            <?php endif?>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-output">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Process Step</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th>Potential Haz <?=$row?></th>
                            <?php endforeach; ?>
                            <th style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($processes as $row): ?>
                            <?php if ($row->flag == "output"): ?>
                                <?php $count = 1;?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$row->process_step?></td>
                                    <?php foreach ($assess_type as $item): ?>
                                        <td>
                                            <?php
                                            switch ($item){
                                                case 'Food':
                                                    echo $row->food;
                                                    break;
                                                case 'Environmental':
                                                    echo $row->environmental;
                                                    break;
                                                case 'TACCP':
                                                    echo $row->TACCP;
                                                    break;
                                                case 'Quality':
                                                    echo $row->quality;
                                                    break;
                                                case 'Safety':
                                                    echo $row->safety;
                                                    break;
                                                case 'VACCP':
                                                    echo $row->VACCP;
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <ul class="icons-list">
                                            <?php if ($user_type != "monitor"):?>
                                                <li><a href="#" onclick="edit(<?=$row->id?>,'output')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                                <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                            <?php endif;?>
                                            <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>" class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php $count++;?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel panel-flat">
                    <div class="row" style="padding-top: 10px;">
                        <div class="col-md-12" style="padding-left: 4%;">
                            <span style="font-size: 23px;">Resource</span>
                        </div>
                        <div class="col-md-12">
                            <?php if ($user_type == "consultant"): ?>
                                <a onclick="add('resource')" style="float: right;margin-right: 10px;" class="btn btn-primary">New</a>
                            <?php endif;?>
                        </div>
                    </div>
                    <table class="table datatable-basic table-bordered datatable-resource">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Process Step</th>
                            <?php foreach ($assess_type as $row): ?>
                                <th>Potential Haz <?=$row?></th>
                            <?php endforeach; ?>
                            <th style="padding-left: 100px;padding-right: 100px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($processes as $row): ?>
                            <?php if ($row->flag == "resource"): ?>
                                <?php $count = 1;?>
                                <tr>
                                    <td><?=$count?></td>
                                    <td><?=$row->process_step?></td>
                                    <?php foreach ($assess_type as $item): ?>
                                        <td>
                                            <?php
                                            switch ($item){
                                                case 'Food':
                                                    echo $row->food;
                                                    break;
                                                case 'Environmental':
                                                    echo $row->environmental;
                                                    break;
                                                case 'TACCP':
                                                    echo $row->TACCP;
                                                    break;
                                                case 'Quality':
                                                    echo $row->quality;
                                                    break;
                                                case 'Safety':
                                                    echo $row->safety;
                                                    break;
                                                case 'VACCP':
                                                    echo $row->VACCP;
                                                    break;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>
                                        <ul class="icons-list">
                                            <?php if ($user_type != "monitor"):?>
                                                <li><a href="#" onclick="edit(<?=$row->id?>,'resource')" type="button" title="Edit" class="btn btn-primary btn-sm" style="color: white;">Edit</a></li>
                                                <li><a href="#" onclick="delete_process(<?=$row->id?>)" class="btn btn-primary btn-sm" style="color: white;" title="Delete">Delete</a></li>
                                            <?php endif;?>
                                            <li><a href = "<?php echo  base_url(); ?>index.php/Consultant/control_list/<?=$row->id?>" class="btn btn-primary btn-sm" style="color: white;" title="Controls">Controls</a></li>
                                        </ul>
                                    </td>
                                </tr>
                                <?php $count++;?>
                            <?php endif;?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <a type="button" class="btn btn-primary" style="margin: 10px;margin-bottom: 0px;width: 100px;" onclick="window.history.back()">Back</a>
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
<div id="modal_process" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Process Info</h5>
            </div>

            <form id="form_process" action = "<?php echo  base_url(); ?>index.php/Consultant/add_other_child_process" method="post">
                <input type="hidden" name="id">
                <input type="hidden" name="outsource_id" value="<?=$outsource_id?>">
                <input type="hidden" name="flag">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3" style="padding-top: 10px;">
                                    <label>Process Step</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="col-md-8">
                                        <select class="form-control" name="process_step" id="process_step" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <a data-toggle="modal" data-target="#process_steps" class="btn btn-primary">MANAGE</a>
                                    </div>
                            </div>
                            <?php foreach ($assess_type as $row): ?>
                                <div class="col-sm-12" style="margin-top: 10px;">
                                    <div class="col-sm-3" style="padding-top: 10px;">
                                        <label><?=$row?></label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="<?=$row?>" name="<?=$row?>" class="form-control" required>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.datatable-scroll').attr('style','overflow-x:scroll;');
    });
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    var user_type = "<?=$user_type?>";
    function add(flag){
        $('#form_process')[0].reset();
        $('#form_process input[name="id"]').val('0');
        $('#form_process input[name="flag"]').val(flag);
        $('#form_process select[name="process_step"]').val('');
        $('#form_process input[name="Food"]').val('');
        $('#form_process input[name="Environmental"]').val('');
        $('#form_process input[name="TACCP"]').val('');
        $('#form_process input[name="Quality"]').val('');
        $('#form_process input[name="Safety"]').val('');
        $('#form_process input[name="VACCP"]').val('');
        $('#modal_process').modal();
    }
    function change(id,type,flag){
        var value = $("#"+id+"-"+type+"-"+flag).val();
        $.ajax({
            type: 'POST',
            url: base_url+'change_process_rating',
            data : {
                id:id,
                type:type,
                value:value,
                flag:flag,
            },
            success : function(data) {
                data = JSON.parse(data);
                $("#"+id+"-"+type+"-value").html(data['value']);
            }
        });
    }
    function edit(val,type){
        $.ajax({
            type: "POST",
            url: "<?php echo  base_url(); ?>index.php/Consultant/find_process",
            data:{ 'id' : val,'type':type},
            success: function(data) {
                var datas = $.parseJSON(data);
                $('#form_process input[name="id"]').val(val);
                $('#form_process input[name="flag"]').val(type);
                $('#form_process select[name="process_step"]').val(datas.process_step);
                $('#form_process input[name="Food"]').val(datas.food);
                $('#form_process input[name="Environmental"]').val(datas.environmental);
                $('#form_process input[name="TACCP"]').val(datas.TACCP);
                $('#form_process input[name="Quality"]').val(datas.quality);
                $('#form_process input[name="Safety"]').val(datas.safety);
                $('#form_process input[name="VACCP"]').val(datas.VACCP);
                $('#modal_process').modal();
            }
        });
    }
    function get_process_list(flag){
        $('#get_process_list').submit();
    }
    function delete_process(id){
        bootbox.confirm("Are you sure?", function(result) {
            if (result) {
                var params = {
                    'id' : id
                };
                $.post('<?php echo  base_url(); ?>index.php/Consultant/delete_process', params, function(data, status){
                    if (JSON.parse(data)['success'] > 0) {
                        new PNotify({
                            title: 'Success',
                            text: 'Successfully Removed.',
                            icon: 'icon-checkmark3',
                            type: 'success'
                        });
                        $('#get_process_list').submit();
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
    }
</script>

</body>
<?php $this->load->view('consultant/manage/process_step'); ?>
</html>
