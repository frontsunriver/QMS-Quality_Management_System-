<!-- Primary modal -->
          <div id="regulatory_requirements" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h6 class="modal-title"><i class="icon-plus2 position-right"></i> REGULATORY REQUIREMENT: </h6>
                </div>
                <div class="modal-body">
                <form method="post">
                       <div class="row">
                       <div class="col-md-10">
                        <div class="form-group has-feedback">
                        <input type="text" placeholder="" class="form-control" name="name" id="newregulatory_requirement">
                        <div class="form-control-feedback">
                          <i class="icon-list text-muted"></i>
                        </div>
                      </div>
                      <span id="regulatory_requirementerr" style="color:red;"></span>
                       </div>
                       <div class="col-md-2">
                         <a onclick="add_regulatory_requirement();" class="btn btn-primary">ADD</a>
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
                            <tbody id="regulatory_requirementlist">
                              
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
	function add_regulatory_requirement() { 
	var newregulatory_requirement = $('#newregulatory_requirement').val(); 
	if (newregulatory_requirement.length==0) {
     $('#regulatory_requirementerr').html('* this field is required');
 	}else{
	            $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/add_regulatory_requirement",
                    data:{'name' : newregulatory_requirement},
                    success: function(data) {
                    	
                    $('#regulatory_requirement').html(data);
                    $('#newregulatory_requirement').val('');
						callregulatory_requirement();
						callregulatory_requirement1();
                    }
                  });
	}          
  }
  $(document).ready(function () { 
   
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_regulatory_requirement",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#regulatory_requirement').html(data);
                    }
                  });


  });

  $(document).ready(function () { 
              $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_regulatory_requirement_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#regulatory_requirementlist').html(data);
                    }
                  });
  });

  function callregulatory_requirement(){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_regulatory_requirement_table",
                    data:{'name' : 1},
                    success: function(data) {
                    $('#regulatory_requirementlist').html(data);
                    }
                  });

  	          
  }
  function deleteregulatory_requirement(val){
  	$.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/delete_regulatory_requirement",
                    data:{'id' :val},
                    success: function(data) {
						callregulatory_requirement();
						callregulatory_requirement1();

                    }
                  });

  }

  function callregulatory_requirement1(){
  	 $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/consultant/all_regulatory_requirement",
                    data:{'name' : 1},
                    success: function(data) {

                    $('#regulatory_requirement').html(data);
                    }
                  });
  }
</script>
