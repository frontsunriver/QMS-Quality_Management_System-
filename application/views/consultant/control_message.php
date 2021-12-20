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
                            <th>NO</th>
                            <th>Control Name</th>
                            <th>Control Plan</th>
                            <th>Action</th>
                            <th>Assessment</th>
                            <th>Frequency</th>
                            <th>Action </th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $count=1;
                        foreach ($control_message as $messages) {
                            ?>
                            <tr>
                                <td><?=$count?></td>
                                <td><?=$messages->name?></td>
                                <td><?=$messages->plan?></td>
                                <td><?=$messages->actions?></td>
                                <td><?=$messages->assessment?></td>
                                <td><?=$messages->frequency_name?></td>
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php/Consultant/show_control_message/<?=$messages->id?>" class="btn btn-primary">View</a>
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

<script type="text/javascript">

    // console.clear();


</script>
</body>



</html>
