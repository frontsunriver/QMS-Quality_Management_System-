<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
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
                                <?php
                                /*                                $consultant_id = $this->session->userdata('consultant_id');
                                                                $plan_ids1 = @$this->db->query("select * from upgrad_plan where `consultant_id`='$consultant_id' AND `status`='1'")->row()->plan_id;
                                                                if (count($plan_ids1) > 0) {
                                                                    $d1 = @$this->db->query("select * from plan where `plan_id`='$plan_ids1'")->row()->no_of_user;
                                                                }
                                                                $d2 = @$this->db->query("select * from plan order by no_of_user DESC")->row()->plan_id;
                                                                */?><!--
                                <?php /*if ($d1 != $d2 && $d2 > $d1) { */?>
                                    <a href="<?php /*echo base_url(); */?>index.php/Auth/update_process"
                                       class="btn bg-brown"> <i class="icon-wrench" title="Main pages"></i> <span> Upgrade Plan</span></a>
                                --><?php /*} */?>
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
                        <h5 class="panel-title">View Control</h5>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                            <label style="padding-left: 3px;">
                                <?php if ($risk_type == 0 && $type_flag == 0): ?>
                                    Issues 1
                                <?php elseif ($risk_type == 0 && $type_flag == 1): ?>
                                    Needs and Expectation 1
                                <?php else:?>
                                    Process1 Name
                                <?php endif;?>
                            </label>
                            <textarea placeholder="<?php if ($risk_type == 0): ?>Issues 1<?php else:?>Risk1<?php endif;?>" name="issues1" class="form-control" disabled><?=$control->issues1?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0 && $type_flag == 0): ?>
                                Issues 2
                            <?php elseif ($risk_type == 0 && $type_flag == 1): ?>
                                Needs and Expectation 2
                            <?php else:?>
                                Process2 Name
                            <?php endif;?>
                        </label>
                        <textarea placeholder="<?php if ($risk_type == 0): ?>Issues 2<?php else:?>Risk2<?php endif;?>" name="issues2" class="form-control" disabled><?=$control->issues2?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">Control Monitoring</label>
                        <input type="text" class="form-control" value = "<?=$control->name?>" disabled>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0): ?>
                                Functional Area
                            <?php else:?>
                                AREA/SYSTEM Monitered
                            <?php endif;?>
                        </label>
                        <textarea placeholder="Functional Area" name="functional_area" class="form-control" disabled><?=$control->functional_area?></textarea>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">Monitor</label>
                        <select class="form-control" name="monitor" id="monitor" disabled>
                            <?php foreach ($employees as $row): ?>
                                <option value="<?=$row->employee_id?>" <?php if ($control->monitor == $row->employee_id): ?><?php echo "selected";?><?php endif;?>><?=$row->employee_name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-6" style="margin-top: 10px;">
                        <label style="padding-left: 3px;">
                            <?php if ($risk_type == 0): ?>
                                Responsible Person
                            <?php else:?>
                                Process Owner
                            <?php endif;?>
                        </label>
                        <select class="form-control" name="responsible_party" id="responsible_party" disabled>
                            <?php foreach ($employees as $row): ?>
                                <option value="<?=$row->employee_id?>" <?php if ($control->responsible_party == $row->employee_id): ?><?php echo "selected";?><?php endif;?>><?=$row->employee_name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <table class="table datatable-monitoring">
                    </table>
                    <div style="padding: 20px;" class="col-sm-12">
                        <a onclick="window.history.back()" class="btn btn-primary" style="margin-right: 20px;">Back</a>
                        <a href="<?php echo  base_url(); ?>index.php/Consultant/control_barcode/<?=$control_id?>" class="btn btn-primary" style="margin-right: 20px;">Next</a>
<!--                        --><?php //if ($risk_type != 0): ?>
<!--                            <a href = "--><?php //echo  base_url(); ?><!--index.php/Consultant/control_barcode/--><?//=$control_id?><!--" class="btn btn-primary" style="margin-right: 20px;">Next</a>-->
<!--                        --><?php //endif; ?>
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
<script type="text/javascript" src="<?=base_url();?>assets/js/user/view_control.js"></script>
<script>
    var control_id = "<?=$history_id?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
</script>
</body>
</html>
