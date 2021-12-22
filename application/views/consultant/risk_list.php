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
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/pnotify.min.js"></script>
    <script type="text/javascript" src="<?=base_url();?>assets/js/plugins/notifications/sweet_alert.min.js"></script>
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
                        <h5 class="panel-title">Potential Hazard List</h5>
                    </div>
                    <div>
                        <label style="float: left;padding:20px;padding-top: 5px;">Select Type </label>
                        <select class="form-control" id="type" style="float: left;width:20%;" required>
                            <option value = "0">Strategic Risk</option>
                            <option value = "1">Operational Risk</option>
                            <option value = "2">PreRequisite Program(PRP)</option>
                            <option value = "3">FSSC Additional Requirements</option>
                            <option value = "-1" selected>Show All</option>
                        </select>
                        <label style="float: left;padding:20px;padding-top: 5px;">Status </label>
                        <select class="form-control" id="status" style="float: left;width:20%;" required>
                            <option value = "0">Open</option>
                            <option value = "1">Close</option>
                        </select>
                        <a onclick="download_risk()" class="btn btn-primary pull-right" style="margin-right: 20px;float: left;">Export</a>
                        
                        <button type="button" id="new_risk" class="btn btn-primary pull-right" style="margin-right: 20px;" data-toggle="modal" data-target="#modal_risk">
                            ADD</button>
                    </div>

                    <table class="table datatable-risk">
                    </table>
                </div>
                <!-- /basic datatable -->

                <!-- User form modal -->
                <div id="modal_risk" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">New Hazard</h5>
                            </div>
                            <form id="form_risk">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Hazard Name</label>
                                                        <input type="text" placeholder="Risk Name" name="name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Description</label>
                                                        <textarea name="description" placeholder="description" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>Details and Technical Data</label>
                                                        <textarea name="detail" placeholder="Details and Technical Data" class="form-control">N/A</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" class="styled" id="type1" onchange="change_type()" name="risk_type" value="0" checked>Strategic Risk</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label style="padding-left: 30px;"><input type="radio" class="styled" id="type1_1" name="type_flag" value="0">Internal and External Issues</label>
                                                <label style="padding-left: 30px;"><input type="radio" class="styled" id="type1_2" name="type_flag" value="1">Needs and expectation of interested Parties</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" class="styled" id="type2" onchange="change_type()" name="risk_type" value="1">Operational Risk</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label style="padding-left: 30px;"><input type="radio" class="styled" id="type2_1" value="0">Management System processes</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" class="styled" id="type4" onchange="change_type()" name="risk_type" value="3">FSSC Additional Requirements</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label><input type="radio" class="styled" id="type3" onchange="change_type()" name="risk_type" value="2">PreRequisite Program(PRP)</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 20px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="Food">Food</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 20px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="Environmental">Environmental</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 20px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="TACCP">TACCP</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 10px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="Quality">Quality</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 10px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="Safety">Safety</label>
                                            </div>
                                            <div class="col-sm-4" style="padding-top: 10px;">
                                                <label><input type="checkbox" class="styled" name="assess_type" value="VACCP">VACCP</label>
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
                <div id="modal_edit" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Hazard Info</h5>
                            </div>

                            <form id="form_edit">
                                <input type="hidden" name="id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Hazard Source</label>
                                                <input type="text" placeholder="Risk Name" name="name" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Description</label>
                                                <textarea name="description" placeholder="description" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Details and Technical Data</label>
                                                <textarea name="detail" placeholder="Details and Technical Data" class="form-control">N/A</textarea>
                                            </div>
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
<script type="text/javascript" src="<?=base_url();?>assets/js/user/risk_list.js"></script>
<script>
    var status = -1;
    var type = -1;
    var user_type = "<?=$user_type?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    $('#type2_1').prop("disabled", true);
    $('#type1_1').prop("checked", true);
    function change_type(){
        var assess_type = document.getElementsByName("assess_type");
        var type_1 = $('#type1').prop("checked");
        var type_2 = $('#type2').prop("checked");
        var type_4 = $('#type4').prop("checked");
        if (type_1 == true){
            $('#type1_1').prop("disabled", false);
            $('#type1_2').prop("disabled", false);
            $('#type2_1').prop("disabled", true);
        }else if (type_2 == true){
            $('#type1_1').prop("disabled", true);
            $('#type1_2').prop("disabled", true);
            $('#type2_1').prop("disabled", false);
            $('#type2_1').prop("checked", true);
        }else{
            $('#type1_1').prop("disabled", true);
            $('#type1_2').prop("disabled", true);
            $('#type2_1').prop("disabled", true);
        }
        for (var i=0;i<6;i++){
            if (type_4 == true){
                $(assess_type[i]).prop("disabled",true);
                $(assess_type[i]).prop("checked",false);
                if (i == 0){
                    $(assess_type[0]).prop("checked",true);
                }
            }else{
                $(assess_type[i]).prop("disabled",false);
            }
        }
    }
    function download_risk(){
        window.location.href="<?php echo base_url(); ?>index.php/Consultant/download_risk?type="+type+"&status="+status;
    }
</script>
</body>
</html>
