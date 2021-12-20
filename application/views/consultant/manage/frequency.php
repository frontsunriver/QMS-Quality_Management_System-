<!-- Primary modal -->
<div id="frequencys" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><i class="icon-plus2 position-right"></i>FREQUENCY: </h6>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group has-feedback">
                                <input type="text" placeholder="Name" class="form-control" name="name" id="new_frequency">
                                <div class="form-control-feedback">
                                    <i class="icon-list text-muted"></i>
                                </div>
                            </div>
                            <span id="frequency_err" style="color:red;"></span>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                <select class="form-control" name="type" id="type" required>
                                    <option value="0">Days</option>
                                    <option value="1">Hours</option>
                                    <option value="2">Minutes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group has-feedback">
                                <input type="number" min="1" value="1" placeholder="Days" class="form-control" name="day" id="new_day" style="padding-right: 8px;">
                            </div>
                            <span id="day_err" style="color:red;"></span>
                        </div>
                        <div class="col-md-2">
                            <a onclick="add_frequency();" class="btn btn-primary">ADD</a>
                        </div>
                    </div>
                    <div class="row" style="max-height: 450px; overflow-y: auto;">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Name</th>
                                    <th>Count</th>
                                    <th>Type</th>
                                    <th>ACTION</th>
                                </tr>
                                </thead>
                                <tbody id="frequency_list">

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
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_frequency",
            data:{'name' : 1},
            success: function(data) {
                $('#frequency').html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_frequency_table",
            data:{'name' : 1},
            success: function(data) {
                $('#frequency_list').html(data);
            }
        });
        $("#new_frequency").keypress( function(event) {
            if (event.keyCode == "13") {
                add_frequency();
            }
        });
    });

    function add_frequency() {
        var new_frequency = $('#new_frequency').val();
        var new_day = $('#new_day').val();
        if (new_frequency.length==0) {
            $('#frequency_err').html('* this field is required');
        }else if (new_day < 1) {
            $('#day_err').html('* this field is incorrect');
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>index.php/Consultant/add_frequency",
                data:{'frequency' : new_frequency, 'days' : new_day, 'type':$("#type").val()},
                success: function(data) {
                    $('#frequency').html(data);
                    $('#new_frequency').val('');
                    callfrequency();
//                    callfrequency1();
                }
            });
        }
    }

    function deletefrequency(val){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/delete_frequency",
            data:{'id' :val},
            success: function(data) {
                var datas = $.parseJSON(data)
                if(datas == "success") {
                    callfrequency();
                    callfrequency1();
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

    function callfrequency(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/Consultant/all_frequency_table",
            data:{'name' : 1},
            success: function(data) {
                $('#frequency_list').html(data);
            }
        });
    }

    function callfrequency1(){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/consultant/all_frequency",
            data:{'name' : 1},
            success: function(data) {
                $('#frequency').html(data);
            }
        });
    }
</script>
