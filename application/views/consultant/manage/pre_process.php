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
<!--    <link rel="stylesheet" href="--><?//= base_url(); ?><!--assets/ck_editor/samples.css">-->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/neo.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/editor.css?t=HBDD">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/scayt.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/dialog.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/tableselection.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/wsc.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/ck_editor/copyformatting.css">
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
                            $admin_emails    = $this->db->query("SELECT * FROM `admin`")->row()->email;
                            $comp_email      = $this->db->query("SELECT * FROM `consultant` WHERE `consultant_id`='$consultant_id'")->row()->email;
                            $employees_email = $this->db->query("SELECT * FROM `employees` WHERE `consultant_id`='$consultant_id' &&  `employee_email`!=''")->result();
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/logo/<?= $audito ?>" style="height:50px;">
                            <span class="text-semibold"><?= $title ?></span>

                            <div class="pull-right">
                                <select class="form-control" style="width:70%;float: left;" onchange="mails(this.value);">
                                    <option><?=$admin_emails?></option>
                                    <option><?=$comp_email?></option>
                                <?php
                                    foreach ($employees_email as $employees_emails) {?>
                                        <option><?=$employees_emails->employee_email?></option>
                                    <?php }?>
                                </select>
                                <a title="Download" type="button" style="float:left;margin-left: 10px;" class="btn btn-primary btn-sm "  onclick="printDiv('ptn')" ><i class="icon-download " aria-hidden="true"></i></a>
                                <a title="Mail" id="mails" style="float:left;margin-left: 5px;;" href="mailto:<?=$admin_emails?>" class="btn btn-primary"><i class="icon-envelope "  aria-hidden="true"></i></a>
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
                <div class="panel panel-flat" id="ptn">
                    <div class="panel-heading">
                        <h5 class="panel-title"><?=$title?></h5>
                    </div>
                    <div>
                        <?php if($this->session->userdata('user_type') == 'consultant'):?>
                            <button type="button" id="new_out_process" class="btn btn-primary pull-right" style="margin-right: 20px;">ADD</button>
                        <?php endif;?>
                        <a href="<?php echo base_url(); ?>index.php/Consultant/download_content_pdf_pre_process" class="btn btn-primary pull-right" style="margin-right: 20px;float: left;">Export</a>
                    </div>
                    <table class="table datatable-out">
                    </table>
                </div>
                <!-- /basic datatable -->

                <!-- User form modal -->
                <div id="modal_process" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Process Info</h5>
                            </div>
                            <form id="form_process">
                                <input type="hidden" class="form-control" name="id">
                                <input type="hidden" class="form-control" name="flag">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Name" name="name" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Description</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea name="description" placeholder="Description" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Active Date</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="date" name="version_date" class="form-control" value="<?=date('Y-m-d')?>" >
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>Review Date</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input type="date" name="revision_date" class="form-control" value="<?=date('Y-m-d')?>" >
                                                </div>
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 10px;">
                                                <div class="col-sm-3" style="padding-top: 10px;">
                                                    <label>File</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" id="file_name" name="file_name" type="file">
                                                </div>
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
                <div id="modal_content" class="modal fade">
                    <div class="modal-dialog" style="width: 900px;">
                        <div class="modal-content" style="width: 900px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Content</h5>
                            </div>
                            <form action="<?php echo base_url(); ?>index.php/Consultant/pre_process_save_content" method="post">
                                <input type="hidden" id="edit_id" name="edit_id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Content</label>
                                                <textarea cols="120" id="content" name="content" rows="30"></textarea>
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
                <div id="modal_export" class="modal fade">
                    <div class="modal-dialog" style="width: 900px;">
                        <div class="modal-content" style="width: 900px;">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5 class="modal-title">Content</h5>
                            </div>
                            <form action="<?php echo base_url(); ?>index.php/Consultant/download_content_pdf_pre_process" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Content</label>
                                                <textarea cols="120" id="export_content" name="content" rows="30"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" onclick = "$('#modal_export').modal('hide');">Export</button>
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
<script type="text/javascript" src="<?=base_url();?>assets/js/user/pre_process.js"></script>
<script src="<?= base_url(); ?>assets/ck_editor/ckeditor.js"></script>
<script src="<?= base_url(); ?>assets/ck_editor/sample.js"></script>
<script src="<?= base_url(); ?>assets/ck_editor/config.js"></script>
<script src="<?= base_url(); ?>assets/ck_editor/en.js"></script>
<script src="<?= base_url(); ?>assets/ck_editor/styles.js"></script>
<script type="text/javascript">
    //<![CDATA[
    CKEDITOR.config.height = 300;
    CKEDITOR.config.width = 850;
    var editor = CKEDITOR.replace( 'content',
        {
            fullPage : true,
            // extraPlugins : 'docprops'
        });
    var editor1 = CKEDITOR.replace( 'export_content',
        {
            fullPage : true,
            // extraPlugins : 'docprops'
        });

    //]]>
</script>
<script>
    var flag = "0";
    var base_url_content = "<?php echo  base_url(); ?>";
    var base_url = "<?php echo  base_url(); ?>index.php/Consultant/";
    var file_path = "";
    function download_pdf(){
        editor1.setData("");
        $("#modal_export").modal();
    }
    function mails(val){
        $("#mails").prop("href","mailto:"+val);
    }
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
</body>
</html>
