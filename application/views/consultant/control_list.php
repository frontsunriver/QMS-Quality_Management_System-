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
        td, th {text-align: center; word-break:break-all!important;}
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
                        <h5 class="panel-title">Determine Controls</h5>
                    </div>
                    <div>
                        <?php if ($user_type != "monitor"): ?>
                            <button type="button" id="new_control" class="btn btn-primary pull-right" style="margin-right: 20px;" data-toggle="modal" data-target="#modal_control">ADD</button>
                        <?php endif;?>
                    </div>

                    <table class="table datatable-control">
                    </table>
                </div>
                <a type="button" class="btn btn-primary" style="margin: 10px;margin-bottom: 0px;width: 100px;" onclick="window.history.back()">Back</a>
                <!-- /basic datatable -->

                <!-- User form modal -->
                <div id="modal_control" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Control Info</h5>
                            </div>
                            <form id="form_control">
                                <input type="hidden" class="form-control" name="id">
                                <input type="hidden" class="form-control" name="process_id" value="<?=$process_id?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Action</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="action" id="action">
                                                        <?php foreach ($actions as $row): ?>
                                                            <option value="<?=$row->id?>"><?=$row->rating?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Process Owner</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="sme" id="sme">
                                                        <?php foreach ($employees as $row): ?>
                                                            <option value="<?=$row->employee_id?>"><?=$row->employee_name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Control Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Control Name" name="name" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Plan</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea name="plan" placeholder="Plan" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Responsible Party</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="responsible_party" id="responsible_party">
                                                        <?php foreach ($employees as $row): ?>
                                                            <option value="<?=$row->employee_id?>"><?=$row->employee_name?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Frequency</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="col-md-9">
                                                        <select class="form-control" name="frequency" id="frequency" required>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a data-toggle="modal" data-target="#frequencys" class="btn btn-primary">MANAGE</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Assessment</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="assessment" id="assessment">
                                                        <?php foreach ($assessments as $row): ?>
                                                            <option value="<?=$row->id?>"><?=$row->rating?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">OK</button>
                                </div>
                            </form>
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
<script type="text/javascript" src="<?=base_url();?>assets/js/user/control_list.js"></script>
<script>
    var process_id = "<?=$process_id?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    var user_type = "<?=$user_type?>";
</script>
<?php $this->load->view('consultant/manage/frequency'); ?>
</body>
</html>
