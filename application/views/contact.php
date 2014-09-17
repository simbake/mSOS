
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Contact Us <span class="glyphicon glyphicon-envelope" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	<?php
        	$show=$this->session->flashdata('email_message');
        	  if($show){   ?>
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Message sent successfull! We will contact you later, Thanks.
            </div>
           <?php } ?>
           <?php
        	$show=$this->session->flashdata('email_error');
        	  if($show){   ?>
            <div class="alert alert-info alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              Error! Please contact Admin: <?php echo $show; ?>
            </div>
           <?php } ?>
        	<fieldset>
      <legend>Email</legend>
			<p style="font-size: 15px;">You can email the mSOS Help Desk at ddsrmsos@gmail.com. 
				You can also use the form below to raise any query or report technical issues.</p>
		</fieldset>
		
	 <!-- <legend>Contact Form</legend>-->
         <form class="form-horizontal" method="post" action="<?php echo base_url().'contact/send' ?>" role="form">
         	<div class="form-group">
    <label for="names" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="names" required name="names" placeholder="Name">
    </div>
  </div>
  <div class="form-group">
    <label for="email" class="col-sm-2 control-label" >Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="email" required name='email' placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="message" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
      <textarea name="message" placeholder='Message' required rows="3" class="form-control"></textarea>
    </div>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-send"></span> Send Message</button>
    </div>
  </div>
</form>
      
        </div>
      </div>
    </div></div>
    
   <!-- <div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        </div>
      </div>
    </div></div>-->
    
  </div> 

