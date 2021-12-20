<!-- Primary modal -->
          <div id="shifts" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i>shift: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newshift">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="shifterr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_shift();" class="btn btn-primary">ADD</a>
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
                            <tbody id="shiftlist">
                              
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
	function add_shift() { 
	var newshift = $('#newshift').val(); 
	if (newshift.length==0) {
     $('#shifterr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_shift",
                    data:{'name' : newshift},
                    success: function(data) {
                    	
                    $('#shift').html(data);
                    $('#newshift').val('');
						callshift();
						callshift1();

					}
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_shift",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#shift').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_shift_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#shiftlist').html(data);
                    }
                  });
  });

  function callshift(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_shift_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#shiftlist').html(data);
                    }
                  });

  	          
  }
  function deleteshift(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_shift",
                    data:{'id' :val},
                    success: function(data) {
						callshift();
						callshift1();
                    }
                  });
  }

  function callshift1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_shift",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#shift').html(data);
                    }
                  });
  }
</script>
