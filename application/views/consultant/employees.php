<!DOCTYPE html>
<!--suppress SqlDialectInspection -->
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
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/pages/form_bootstrap_select.js"></script>
    <!-- /core JS files -->

    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/styling/uniform.min.js"></script>
    <script type="text/javascript" src="<?=base_url(); ?>assets/js/plugins/forms/styling/switch.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/forms/selects/select2.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/forms/selects/bootstrap_select.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/app.js"></script>
    <!-- <script type="text/javascript" src="<?=base_url(); ?>assets/js/pages/datatables_basic.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
    <script type="text/javascript">
        $(function() {
            // Style checkboxes and radios
            $('.styled').uniform();
        });

        function filterUserType() {
            document.employee_form.submit();
        }

        function setFocusEnd(id){
            var node=document.getElementById(id);
            pos=node.value.length;
            node.focus();
            if(!node){
                return false;
            }else if(node.createTextRange){
                var textRange = node.createTextRange();
                textRange.collapse(true);
                textRange.moveEnd(pos);
                textRange.moveStart(pos);
                textRange.select();
                return true;
            }else if(node.setSelectionRange){
                node.setSelectionRange(pos,pos);
                return true;
            }
            return false;
        }
    </script>
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
                                $consultant_id= $this->session->userdata('consultant_id');
                                $logo1=$this->db->query("select * from `consultant` where `consultant_id`='$consultant_id'")->row();

                                $dlogo=$this->db->query("select * from `default_setting` where `id`='1'")->row()->logo;

                                if ($logo1->logo=='1') {
                                    $logo=$dlogo;
                                }else{
                                    $logo=$logo1->logo;
                                }
                            }
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?=$logo?>" style="height:50px;">
                            <span class="text-semibold"><?=$title?></span>
                            <div class="pull-right">
                                <?php
                                $consultant_id=$this->session->userdata('consultant_id');
                                $d1 = 0; $d2 = 0;
                                $plan_ids1= @$this->db->query("select * from consultant where `consultant_id`='$consultant_id' ")->row()->plan_id;
                                if (is_array( $plan_ids1 ) && count($plan_ids1)>0) {
                                    $d1= @$this->db->query("select * from plan where `plan_id`='$plan_ids1'")->row()->no_of_user;
                                }
                                $d2=@$this->db->query("select * from plan order by no_of_user DESC")->row()->plan_id;
                                ?>
                                <?php if ($d1!=$d2 &&  $d2>$d1) { ?>
                                    <a href="<?php echo base_url(); ?>index.php/Auth/update_process" class="btn bg-brown"> <i class="icon-wrench" title="Main pages"></i>  <span> Upgrade Plan</span></a>
                                <?php } ?>

                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_theme_primary">New Employee <i class="icon-user role-right"></i></button>
                            </div>
                        </h4>
                    </div>
                </div>

                <div class="breadcrumb-line">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/Welcome/consultantdashboard"><i class="icon-home2 role-left"></i>Home</a></li>
                        <li>Manage</li>
                        <li><a href="#"><?=$title?></a></li>
                    </ul>

                    <ul class="breadcrumb-elements">

                    </ul>
                </div>
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                <?php if($this->session->flashdata('message')=='failed') { ?>
                    <div class="alert alert-warning alert-styled-left alert-arrow-right alpha-teal alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Oppps!</span> You have Maximum Limit reached .
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('message')=='success_del') { ?>
                    <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Employee Successfully Deleted..
                    </div>
                <?php   } ?>
                <?php if($this->session->flashdata('message')=='update_success') { ?>
                    <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Employee Successfully Updated..
                    </div>
                <?php   } ?>
                <?php if($this->session->flashdata('message')=='error') { ?>
                    <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Oppps!</span> Something Went Wrong Please try again.
                    </div>
                <?php   } ?>
                <?php if($this->session->flashdata('message')=='live_err') { ?>
                    <div class="alert alert-styled-right alert-styled-custom alert-arrow-right alpha-teal alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">Oppps!</span> Access denied. Already exist.
                    </div>
                <?php   } ?>
                <?php if($this->session->flashdata('phone_response')) { ?>
                    <div class="alert alert-danger alert-styled-right alert-arrow-right alert-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        <?= $this->session->flashdata('phone_response')['message'] ?>
                    </div>
                <?php   } ?>

                <div class="panel panel-body border-top-danger text-center">
                    <h6 class="no-margin text-semibold">Account Status</h6>
                    <div class="pace-demo" style="padding-bottom: 30px;">
                        <div class="theme_bar_sm"><div class="pace_progress" data-progress-text="60%" data-progress="60" style="width:<?=$reached?>%;"> <?=$total_account?>/<?=$limit?></div></div>
                    </div>
                </div>

                <form class="form-horizontal" method="post" action="<?php echo  base_url(); ?>index.php/Consultant/employees" enctype="multipart/form-data" name="employee_form">
                <div class="panel panel-body  text-left" style="padding-bottom: 0px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" placeholder="Search By Full Name" class="form-control" name="search_name" id="search_name" value="<?=$search_name?>">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-left: 10px;">
                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-primary btn-sm pull-right">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>

                <!-- Basic datatable -->
                <div class="panel panel-flat" style="overflow: auto">
                    <table class="table datatable-basic">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width:15%">User Type</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $count=1;
                        foreach ($employees as $employee) { ?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$employee->employee_name?></td>
                                <td><?=$employee->employee_email?></td>
                                <td><?=$employee->role?></td>
                                <td style="width:15%"><?=$employee->type_name?></td>
                                <td><?=$employee->username?></td>
                                <td><?=$employee->password?></td>
                                <td>
                                    <ul class="icons-list">
                                        <li class="text-primary-600" onclick="edit(<?=$employee->employee_id?>);"><a href="#"><i class="icon-pencil7"></i></a></li>
                                        <li class="text-danger-600"><a href="#" id="<?=$employee->employee_id?>" class="delete" ><i class="icon-trash"></i></a></li>
                                    </ul>
                                </td>

                            </tr>
                            <?php $count++; } ?>
                        </tbody>
                    </table>
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

<!-- Primary modal -->
<div id="modal_theme_primary1" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-user role-right"></i> Edit Employee</h6>
            </div>
            <form action="<?php echo base_url();?>index.php/Consultant/edit_employee" method="post" name="edit_employee">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Full Name: </label>
                                <input type="text" placeholder="Your Full Name" class="form-control" name="edit_name" id="edit_name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="edit_name_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Email: </label>
                                <input type="email" placeholder="Your Email" class="form-control" name="edit_email" id="edit_email" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="edit_email_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Phone: </label>
                                <input type="text" placeholder="+12345678910" class="form-control" name="edit_phone" id="edit_phone" required>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile text-muted"></i>
                                </div>
                                <span id="edit_email_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Role: </label>
                                <input type="text" placeholder="You Role" class="form-control" name="edit_role" id="edit_role" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="edit_role_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Username: </label>
                                <input type="text" placeholder="Your username" class="form-control" name="edit_username" id="edit_username" required>
                                <input type="hidden" name="old_username" id="old_username">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="edit_username_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Password: </label>
                                <input type="password" placeholder="Your password" class="form-control" name="edit_password" id="edit_password">
                                <div class="form-control-feedback">
                                    <i class="icon-lock text-muted"></i>
                                </div>
                                <span id="edit_password_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback" style="margin-left: 15px;" id="checked_div">
<!--                                <label class="checkbox" style="padding-left: 30px;">-->
<!--                                    <input type="checkbox" class="styled permisions" name="edit_executive" id="edit_executive" value="1">-->
<!--                                    Executive-->
<!--                                </label>-->
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_process_owner_sme" id="edit_process_owner_sme" value="2">
                                    Process Owner/SME
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_employee" id="edit_employee" value="3">
                                    Risk Monitor
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_pm_mo_sv" id="edit_pm_mo_sv" value="4">
                                    Production Manager/Monitor/Supervisor
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_procurement" id="edit_procurement" value="5">
                                    Procurement
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_warehousing" id="edit_warehousing" value="6">
                                    Warehousing
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_sales" id="edit_sales" value="7">
                                    Sales
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="edit_manufacturing" id="edit_manufacturing" value="8">
                                    Manufacturing
                                </label>
                            </div>
                            <span id="edit_type_err" style="color:red;"></span>
                        </div>
                    </div>
                    <input type="hidden" name="employee_id" id="employee_id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirm_edit_data();"><i class="icon-plus2 role-right"></i> Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /primary modal -->
<script type="text/javascript">
    $(document).ready(function() {
        setFocusEnd("search_name");

        $('.bootstrap-select').selectpicker();
    });

    $('body').on('click','.delete' ,function(e){
        var id = $(this).attr('id');
        var dialog = bootbox.dialog({
            title: 'Confirmation',
            message: "<h4>Are You Sure Want to delete ?</h4>",
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
                    callback: function() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>index.php/Consultant/confirm_assign",
                            data:{ 'id' : id},
                            success: function(data) {
                                var datas = $.parseJSON(data);
                                if(datas == '1') {
                                    window.location.href="<?php echo base_url();?>index.php/Consultant/delete_employee/"+id;
                                } else {
                                    var dialog = bootbox.dialog({
                                        title: 'Warning',
                                        message: "This employee has been assigned to risk.",
                                        size: 'small',
                                        buttons: {
                                            cancel: {
                                                label: "OK",
                                                className: 'btn-danger',
                                                callback: function() {
                                                    dialog.modal('hide');
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            }
        });
    });

    function edit(val){
        $('#modal_theme_primary1').modal('show');
        $.ajax({
            type: "POST",
            url: "<?= base_url('consultant/finduser') ?>",
            data:{ 'id' : val },
            success: function(data) {
                var datas = $.parseJSON(data);
                $("#edit_name").val(datas.employee_name);
                $("#edit_email").val(datas.employee_email);
                $("#edit_phone").val(datas.employee_phone);
                $("#edit_role").val(datas.role);
                $("#edit_username").val(datas.username);
                $("#old_username").val(datas.username);
                $("#employee_id").val(datas.employee_id);

                $("#checked_div > label > div > span").removeClass("checked");
                $(".permisions").prop("checked", false);

                var user_types = datas.type_ids.split(",");
                for(var i=0; i<user_types.length; i++) {
                    if(user_types[i] == '1') {
                        $("#uniform-edit_executive > span").addClass("checked");
                        $("#edit_executive").prop("checked", true);
                    } else if(user_types[i] == '2') {
                        $("#uniform-edit_process_owner_sme > span").addClass("checked");
                        $("#edit_process_owner_sme").prop("checked", true);
                    } else if(user_types[i] == '3') {
                        $("#uniform-edit_employee > span").addClass("checked");
                        $("#edit_employee").prop("checked", true);
                    } else if(user_types[i] == '4') {
                        $("#uniform-edit_pm_mo_sv > span").addClass("checked");
                        $("#edit_pm_mo_sv").prop("checked", true);
                    } else if(user_types[i] == '5') {
                        $("#uniform-edit_procurement > span").addClass("checked");
                        $("#edit_procurement").prop("checked", true);
                    } else if(user_types[i] == '6') {
                        $("#uniform-edit_warehousing > span").addClass("checked");
                        $("#edit_warehousing").prop("checked", true);
                    } else if(user_types[i] == '7') {
                        $("#uniform-edit_sales > span").addClass("checked");
                        $("#edit_sales").prop("checked", true);
                    } else if(user_types[i] == '8') {
                        $("#uniform-edit_manufacturing > span").addClass("checked");
                        $("#edit_manufacturing").prop("checked", true);
                    }
                }
            }
        });
    }

    function confirm_add_data() {
        if($("#add_name").val().length == 0) {
            $('#name_err').html('* this field is required');
            return false;
        } else if($("#add_email").val().length == 0) {
            $('#name_err').html('');
            $('#email_err').html('* this field is required');
            return false;
        } else if ($("#add_role").val() == null) {
            $('#name_err').html('');
            $('#email_err').html('');
            $('#role_err').html('* this field is required');
            return false;
        } else if($("#add_username").val().length == 0) {
            $('#name_err').html('');
            $('#email_err').html('');
            $('#role_err').html('');
            $('#username_err').html('* this field is required');
            return false;
        } else if($("#add_password").val().length == 0) {
            $('#name_err').html('');
            $('#email_err').html('');
            $('#role_err').html('');
            $('#username_err').html('');
            $('#password_err').html('* this field is required');
            return false;
        } else if(!$('#executive').is(":checked") && !$('#process_owner_sme').is(":checked") && !$('#employee').is(":checked") &&
            !$('#pm_mo_sv').is(":checked") && !$('#procurement').is(":checked") && !$('#warehousing').is(":checked") &&
            !$('#sales').is(":checked") && !$('#manufacturing').is(":checked")){
            $('#name_err').html('');
            $('#email_err').html('');
            $('#role_err').html('');
            $('#username_err').html('');
            $('#type_err').html('* this field is required');
            return false;
        }
        else {
            $("input[name='add_role']").val($("#add_role").val());
            document.add_employee.submit();
        }
    }

    function confirm_edit_data() {
        if($("#edit_name").val().length == 0) {
            $('#edit_name_err').html('* this field is required');
            return false;
        } else if($("#edit_email").val().length == 0) {
            $('#edit_name_err').html('');
            $('#edit_email_err').html('* this field is required');
            return false;
        } else if($("#edit_role").val() == null) {
            $('#edit_name_err').html('');
            $('#edit_email_err').html('');
            $('#edit_role_err').html('* this field is required');
            return false;
        } else if($("#edit_username").val().length == 0) {
            $('#edit_name_err').html('');
            $('#edit_email_err').html('');
            $('#edit_role_err').html('');
            $('#edit_username_err').html('* this field is required');
            return false;
        } else if(!$('#edit_executive').is(":checked") && !$('#edit_process_owner_sme').is(":checked") && !$('#edit_employee').is(":checked") &&
            !$('#edit_pm_mo_sv').is(":checked") && !$('#edit_procurement').is(":checked") && !$('#edit_warehousing').is(":checked") &&
            !$('#edit_sales').is(":checked") && !$('#edit_manufacturing').is(":checked")){
            $('#edit_name_err').html('');
            $('#edit_email_err').html('');
            $('#edit_role_err').html('');
            $('#edit_username_err').html('');
            $('#edit_type_err').html('* this field is required');
            return false;
        }
        else {
            $("input[name='edit_role']").val($("#edit_role").val());
            document.edit_employee.submit();
        }
    }
</script>

</body>

<!-- Primary modal -->
<div id="modal_theme_primary" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-user role-right"></i> New Employee</h6>
            </div>
            <form action="<?= base_url('consultant/add_employee') ?>" method="post" name="add_employee">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Full Name: </label>
                                <input type="text" placeholder="Your Full Name" class="form-control" name="add_name" id="add_name" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="name_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Email: </label>
                                <input type="email" placeholder="Your Email" class="form-control" name="add_email" id="add_email" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="email_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Phone: </label>
                                <input type="text" placeholder="+12345678910" class="form-control" name="add_phone" id="add_phone" required>
                                <div class="form-control-feedback">
                                    <i class="icon-mobile text-muted"></i>
                                </div>
                                <span id="add_phone_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Role: </label>
                                <input type="text" placeholder="You Role" class="form-control" name="add_role" id="add_role" required>
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="role_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Username: </label>
                                <input type="text" placeholder="Your username" class="form-control" name="add_username" id="add_username" required value="">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                <span id="username_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback">
                                <label>Password: </label>
                                <input type="password" placeholder="Your password" class="form-control" name="add_password" id="add_password" required value="">
                                <div class="form-control-feedback">
                                    <i class="icon-lock text-muted"></i>
                                </div>
                                <span id="password_err" style="color:red;"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="styled permisions" name="employee" id="employee" value="3">
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback" style="margin-left: 15px;">
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="process_owner_sme" id="process_owner_sme" value="2">
                                    Process Owner/SME
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="employee" id="employee" value="3">
                                    Risk Monitor
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="pm_mo_sv" id="pm_mo_sv" value="4">
                                    Production Manager/Monitor/Supervisor
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="procurement" id="procurement" value="5">
                                    Procurement
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="warehousing" id="warehousing" value="6">
                                    Warehousing
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="sales" id="sales" value="7">
                                    Sales
                                </label>
                                <label class="checkbox" style="padding-left: 30px;">
                                    <input type="checkbox" class="styled permisions" name="manufacturing" id="manufacturing" value="8">
                                    Manufacturing
                                </label>
                            </div>
                            <span id="type_err" style="color:red;"></span>
                        </div>
                    </div> -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="confirm_add_data();"><i class="icon-plus2 role-right"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->
</html>
