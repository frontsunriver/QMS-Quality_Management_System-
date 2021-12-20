<!-- Primary modal -->
<div id="triggers" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-plus2 position-right"></i>TRIGGER: </h6>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group has-feedback">
                                <input type="text" placeholder="" class="form-control" name="name" id="new_trigger">
                                <div class="form-control-feedback">
                                    <i class="icon-list text-muted"></i>
                                </div>
                            </div>
                            <span id="trigger_err" style="color:red;"></span>
                        </div>
                        <div class="col-md-2">
                            <a onclick="add_trigger();" class="btn btn-primary">ADD</a>
                        </div>
                    </div>
                    <div class="row" style="max-height: 450px; overflow-y: auto;">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAME</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody id="trigger_list">

                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /primary modal -->

<script type="text/javascript">
    $(document).ready(function () {
        var name = "0";
        <?php if (!empty($checklist_id)): ?>
        name = "<?=$checklist_id?>";
        <?php endif; ?>
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_trigger",
            data:{'name' : name},
            success: function(data) {
                $('#trigger').html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_trigger_table",
            data:{'name' : 1},
            success: function(data) {
                $('#trigger_list').html(data);
            }
        });
        $("#new_trigger").keypress( function(event) {
            if (event.keyCode == "13") {
                add_trigger();
            }
        });
    });

    function add_trigger() {
        var new_trigger = $('#new_trigger').val();
        if (new_trigger.length==0) {
            $('#trigger_err').html('* this field is required');
        }else{
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Consultant/add_trigger",
                data:{'trigger' : new_trigger},
                success: function(data) {
                    $('#trigger').html(data);
                    $('#new_trigger').val('');
                    calltrigger();
//                    calltrigger1();
                }
            });
        }
    }

    function deletetrigger(val){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/delete_trigger",
            data:{'id' :val},
            success: function(data) {
                var datas = $.parseJSON(data)
                if(datas == "success") {
                    calltrigger();
                    calltrigger1();
                } else {
                    var dialog = bootbox.dialog({
                        title: 'Warning',
                        message: "You cannot delete! It is used.",
                        size: 'small',
                        buttons: {
                            cancel: {
                                label: "Ok",
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

    function calltrigger(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_trigger_table",
            data:{'name' : 1},
            success: function(data) {
                $('#trigger_list').html(data);
            }
        });
    }

    function calltrigger1(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/consultant/all_trigger",
            data:{'name' : 1},
            success: function(data) {
                $('#trigger').html(data);
            }
        });
    }
</script>
