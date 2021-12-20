<!-- Primary modal -->
          <div id="process_steps" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i> Process Step: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newprocessstep">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="processsteperr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_process_step();" class="btn btn-primary">ADD</a>
                       </div>
                     </div>
                  <div class="row">
                       <div class="col-md-12">
                         <table class="table">
                           <thead>
                            <tr>
                              <th>VALUE</th>
                            <th>ACTION</th>
                            </tr>
                            </thead>
                            <tbody id="processsteplist">
                              
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
	function add_process_step() {
	var newprocessstep = $('#newprocessstep').val();
	if (newprocessstep.length==0) {
     $('#processsteperr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_process_step",
                    data:{'name' : newprocessstep},
                    success: function(data) {
                    	
                    $('#process_step').html(data);
                    $('#newprocessstep').val('');
						callprocessstep();
						callprocessstep1();
                    }
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_process_step",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#process_step').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_process_step_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#processsteplist').html(data);
                    }
                  });
  });

  function callprocessstep(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_process_step_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#processsteplist').html(data);
                    }
                  });

  	          
  }
  function deletestandard(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_process_step",
                    data:{'id' :val},
                    success: function(data) {

						callprocessstep();
						callprocessstep1();

                    }
                  });
  }

  function callprocessstep1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_process_step",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#process_step').html(data);
                    }
                  });
  }
</script>
