<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?=base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/core/app.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/datatables_basic.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>

    <style type="text/css">
        .cstlist {
            background-color:#26a69a;
            color: #fff;
        }
        #DataTables_Table_0_length{
            display: none!important;
        }
        td,th{
            border: 1px solid #babbbb !important;
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
                        <h4>

                            <?php
                            if ($this->session->userdata('consultant_id')) {
                                $consultant_id= $this->session->userdata('consultant_id');
                                $user_type= $this->session->userdata('user_type');
                                $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

                                $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

                                if ($logo1->logo=='1') {
                                    $logo=$dlogo;
                                }else{
                                    $logo=$logo1->logo;
                                }
                            }
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;"><span class="text-semibold"><?=$title?></span>

                            <div class="pull-right">
                                <a data-toggle="modal" data-target="#modal_theme_primary"  class="btn btn-primary"><i class="icon-envelope "  aria-hidden="true"></i> Create New One</a>

                            </div>


                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i class="icon-home2 position-left"></i>Home</a></li>
                        <li>Inbox</li>
                        <li><a href="#"><?=$title?></a></li>

                    </ul>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">


                <!-- Basic datatable -->
                <div class="panel panel-flat" id="ptn" style="overflow:auto;">
                    <table class="table  table-bordered datatable-basic">

                        <thead>

                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Title</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Action </th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $count=1;
                        foreach ($individual_message as $messages) {
                            if ($messages->from_role=='consultant') {
                                if ($user_type == "consultant"){
                                    $from_users=$this->session->userdata('username');
                                }else{
                                    $from_users=@$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->username;
                                }
                            }else{
                                $from_users=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$messages->from_user'")->row()->employee_name;
                            }
                            if ($messages->to_role=='consultant' || $messages->to_user=='0') {
                                if ($user_type =="consultant"){
                                    $tousers=$this->session->userdata('username');
                                }else{
                                    $consultant_id= $this->session->userdata('consultant_id1');
                                    $from_users=@$this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->username;
                                }
                            }else{
                                $tousers=@$this->db->query("SELECT * FROM `employees` WHERE `employee_id`='$messages->to_user'")->row()->employee_name;
                            }
                            ?>

                            <tr>
                                <td><?=$count?></td>
                                <td><?=$messages->date_time?></td>
                                <td><?=$messages->title?></td>
                                <td><?=$from_users?></td>
                                <td><?=$tousers?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php/Consultant/show_individual_message/<?=$messages->id?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                            <?php $count++; } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /basic datatable -->

                <!-- Footer -->

                <!-- /footer -->

            </div>
            <!-- /content area -->
        </div>
        <!-- /main content -->
    </div>
    <!-- /page content -->
</div>
<script type="text/javascript">
    function mails(val){

        $("#mails").prop("href","mailto:"+val);


    }
</script>
<script type="text/javascript">
    $('body').on('click','.delete' ,function(e){
        var id = $(this).attr('id');
        var dialog = bootbox.dialog({
            title: 'Confirmation',
            message: "<h4>Are You Sure ?</h4>",
            size: 'small',
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function(){
                        dialog.modal('hide');
                    }
                },

                ok: {
                    label: "OK",
                    className: 'btn-success',
                    callback: function(){
                        window.location.href="<?php echo base_url();?>index.php/Employee/delete_standaloneform/"+id;
                    }
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function edit(val){
        $('#modal_theme_primary1').modal('show');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Employee/findcust",
            data:{ 'id' : val},
            success: function(data) {
                var datas = $.parseJSON(data)
                $("#name").val(datas.name);
                $("#address").val(datas.address);
                $("#city").val(datas.city);
                $("#state").val(datas.state);
                $("#cust_id").val(datas.id);
            }
        });
    }
</script>
<!-- /page container -->

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

<!-- Primary modal -->
<div id="modal_theme_primary" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-envelope  role-right"></i>  Send Message</h6>

            </div>
            <div class="modal-body">
                <form action="<?php echo base_url();?>index.php/Consultant/mails_to_indi" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Title: </label>
                                <input type="text" name="title" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>To: </label>
                                <select class="form-control" name="to_user">
                                    <option value="owner">Consultant Owner</option>
                                    <?php
                                    foreach ($employees as $employee) { ?>
                                        <option value="<?=$employee->employee_id?>"><?=$employee->employee_name?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Message: </label>
                                <textarea class="form-control" name="message"></textarea>
                            </div>
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="icon-reply role-right"></i> Send</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->
</body>



</html>
