<script>
    // On Change Toogle Switch Active/Deactive button
    $('body').on('change','.otp-active-deactive' ,function(e){
        var _elm = $(this);
        if ($(this).is(":checked"))
        {
            console.log('It is active now');
            var checkedValue = 1;
            var checkedMsg = 'Activate';

        }
        else {
            console.log('It is deactive now');
            var checkedValue = 0;
            var checkedMsg = 'Deactivate';
        }
        var dialog = bootbox.dialog({
            title: 'Confirmation',
            message: "<h4>Are You Sure want to "+checkedMsg+" OTP Verification?</h4>",
            size: 'small',
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: 'btn-danger',
                    callback: function(){
                        dialog.modal('hide');
                        if(checkedValue === 1) {
                            console.log('comes here');
                            _elm.prop('checked', false);
                            _elm.parent().addClass('off');
                        } else {
                            console.log('comes here elseeeee');
                            _elm.prop('checked', true);
                            _elm.parent().removeClass('off');
                        }
                    }
                },

                ok: {
                    label: "OK",
                    className: 'btn-success',
                    callback: function(){
                        $.ajax({
                            type:"post",
                            url:"<?php echo base_url();?>index.php/admin/update_otp_setting",
                            data:{
                                status:checkedValue
                            },
                            cache:false,
                            success:function (_response) {
                                _response = JSON.parse(_response);
                                if (_response.success){
                                    alert(_response.message);
                                }
                            },errors:function (_response) {
                                console.error(_response)
                            }
                        });
                        //window.location.href="<?php echo base_url();?>index.php/admin/update_otp_setting?is_active="+checkedValue;
                    }
                }
            }
        });
    });
</script>
<!-- <div class="footer text-muted">
	&copy; 2018. <a href="#">EMS</a> by <a href="#" target="_blank">EMS DEVELOPER</a>
</div> -->