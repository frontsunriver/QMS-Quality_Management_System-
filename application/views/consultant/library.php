<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <!-- <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> -->
    <link href="<?= base_url(CSS_URL . 'icons/icomoon/styles.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url(CSS_URL . 'bootstrap.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url(CSS_URL . 'core.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url(CSS_URL . 'components.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url(CSS_URL . 'colors.css') ?>" rel="stylesheet" type="text/css">

    <!-- Core JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>

    <script type="text/javascript" src="<?= base_url(JS_URL . 'core/app.js') ?>"></script>
    <!-- /core JS files -->
</head>

<style>
    .panel-heading button {
        font-size: 14px;
    }
    .field-label {
        line-height: 36px;
        vertical-align: middle;
        text-align: right;
    }
</style>

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
                                <img src="<?= base_url(UPLOAD_URL . 'logo/' . ($audito->logo == '1' ? $dlogo->logo : $audito->logo)) ?>" style="height: 50px;" />
                                <span class="text-semibold"><?= $title ?></span>
                                <div class="pull-right">
                                </div>
                            </h4>
                        </div>
                    </div>
                    <div class="breadcrumb-line">
                        <ul class="breadcrumb">
                            <li>
                                <a href="<?= base_url('welcome/consultantdashboard') ?>"><i class="icon-home2 role-left"></i>Home</a></li>
                            <li><a href="#"><?= $title ?></a></li>
                        </ul>

                        <ul class="breadcrumb-elements">
                        </ul>
                    </div>
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h6 class="panel-title" style="display: inline-block;">Library List</h6>
                            <div style="float: right;">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_default"> <i class="icon-plus3"></i> Create Directory</button>
                            </div>
                        </div>
                        <div class="panel-body text-left">
                            
                        </div>
                    </div>
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

<div id="modal_default" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Create Directory</h5>
            </div>
            <hr style="margin: 10px 0 0 0;" />
            <div class="modal-body">
                <div class="row">
                    <label class="col-sm-3 control-label field-label">Directory Name</label>
                    <div class="col-sm-8">
                        <input type="text" id="new_directory" class="form-control" />
                    </div>
                </div>
            </div>
            <hr style="margin: 0 0 10px 0;" />
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="onCreateDirectory()">Create</button>
                <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function onCreateDirectory() {
        var new_dir = $('#new_directory').val();
        if (new_dir == '') {
            alert('Insert Directory name');
            return;
        }

        $.ajax({
            type: 'post',
            url: '<?= base_url('consultant/library_create_directory') ?>',
            data: {
                new_dir: new_dir
            },
            success: function(data, status, xhr) {
                
            }
        });
    }
</script>

</body>
</html>