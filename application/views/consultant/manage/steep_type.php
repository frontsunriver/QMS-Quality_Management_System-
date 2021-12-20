<!-- Primary modal -->
          <div id="steep_type" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i> Type: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="new_steep_type">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="steep_type_err" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_steep_type();" class="btn btn-primary">ADD</a>
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
                            <tbody id="steep_type_list">
                              
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
	function add_steep_type() { 
	var new_steep_type = $('#new_steep_type').val(); 
	if (new_steep_type.length==0) {
     $('#steep_type_err').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_steep_type",
                    data:{'name' : new_steep_type},
                    success: function(data) {
	                    $('#process_steep_type').html(data);
    	                $('#new_steep_type').val('');
						callsteep_type();
						callsteep_type1();

					}
                  });
	}          
  }
  $(function () {
      var name = "";
      <?php if (!empty($steep_id)): ?>
      name = "<?=$steep_id?>";
      <?php endif; ?>
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_steep_type",
                    data:{'name' : name},
                    success: function(data) {
                    $('#process_steep_type').html(data);
                    }
                  });
  });
  $(document).ready(function () {
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_steep_type_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#steep_type_list').html(data);
                    }
                  });
  });

  function callsteep_type(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_steep_type_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#steep_type_list').html(data);
                    }
                  });


  }
  function deletesteep_type(val){
  	$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/consultant/delete_steep_type",
			data:{'id' :val},
			success: function(data) {
				callsteep_type();
				callsteep_type1();
			}
		  });

  }

  function callsteep_type1(){
  	 $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>index.php/consultant/all_steep_type",
        data:{'name' : 0},
        success: function(data) {
        $('#process_steep_type').html(data);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>index.php/consultant/all_edit_steep_type",
            data:{'name' : 0},
            success: function(data) {
                $('#edit_steep_type').html(data);
            }
        });
        }
      });
  }
</script>
