<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Photo</title>
    <!--    <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">-->
    <link href="<?= base_url(); ?>assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url(); ?>assets/css/colors.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>assets/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

    <script type="text/javascript" src="<?= base_url(); ?>assets/js/pages/uploader_bootstrap.js"></script>
    <!-- /global stylesheets -->

    <!--    <script type="text/javascript" src="--><?//= base_url(); ?><!--assets/js/pages/datatables_basic.js"></script>-->
    <style type="text/css">

    </style>
</head>

<body class="navbar-top">

    <input type="hidden" id="id" name="id" value="<?=$id?>">
    <!--<input type="hidden" id="control_id" name="control_id" value="<?/*=$id*/?>">-->
    <input type="hidden" id="type" name="type" value="<?=$type?>">
    <div class="form-group">
        <div class="col-lg-10">
            <input type="file" class="file-input-ajax" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera">
        </div>
    </div>

<script>
    function fileSelected() {
        $(".fileinput-upload-button").removeAttr("href");
        $(".fileinput-upload-button").attr("onclick","uploadFile()");

        var count = document.getElementById('fileToUpload').files.length;
        for (var index = 0; index < count; index ++)
        {
            var file = document.getElementById('fileToUpload').files[index];
            var fileSize = 0;
            if (file.size > 1024 * 1024)
                fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
            else
                fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
        }
    }
    function uploadFile(){
        var fd = new FormData();
        var count = document.getElementById('fileToUpload').files.length;
        for (var index = 0; index < count; index ++)
        {
            var file = document.getElementById('fileToUpload').files[index];
            fd.append("file_name", file);
        }
        //fd.append("control_id", $("#control_id").val());
        fd.append("id", $("#id").val());
        fd.append("type", $("#type").val());
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        //xhr.open("POST", "<?php echo base_url(); ?>index.php/welcome/add_barcode");
        xhr.open("POST", "<?php echo base_url(); ?>index.php/welcome/upload_barcode_request");
        xhr.send(fd);
    }

    function uploadProgress(evt) {
        return;
    }

    function uploadComplete(evt) {
        /* This event is raised when the server send back a response */
        alert(evt.target.responseText);
    }
    function uploadFailed(evt) {
        alert("There was an error attempting to upload the file.");
    }
    function uploadCanceled(evt) {
        alert("The upload has been canceled by the user or the browser dropped the connection.");
    }
</script>
</body>
</html>
