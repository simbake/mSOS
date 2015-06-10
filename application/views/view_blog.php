<?php 
 if (isset($all)) {

	$title = $all -> title;
	$post = $all -> post;
	$time_p = $all -> time_p;
	$id = $all -> id;
}

 ?>
	
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo $title?> <span class="gglyphicon glyphicon-envelope" style=""></span></h3> 
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	<table width="100%" border="0">
  <tr>
    <td>
    	<p class=styleNewsHeader><strong></strong></p>  
		<div class=styleNewsBody><?php echo nl2br($post)?></div>
	</td>
  	</tr>
	<?php if($this->session->userdata("user_id")>0){?>
  	<form method="post" action="<?php echo base_url().'blogs/post_comment'?>">
  		<input type="hidden" name="pcomments" value="<?php echo $id?>" />
  	<tr>
  		<td><textarea name="comments" cols="60px" style="float: right;"></textarea></td>
  		
  	</tr>
  	<tr>
  		<td>
  			<button type="submit" name="btn" class="btn-default" style="float: right"><span class="glyphicon glyphicon-pencil"></span> Post Comment</button>
  		</td>
  	</tr>
  </form>
  <?php } ?>
  
</table><br/><br/>
				<div style="width: 100%; float: left">
				
					<fieldset>
						<legend><span class="glyphicon glyphicon-comment"></span> Comments</legend>
	
						<table width="100%" border="0">
	<?php foreach($all1 as $row):?>						
  <tr>
    <td>
    	<p class=styleNewsHeader><span class="glyphicon glyphicon-calendar"></span><strong> <?php $a = $row->date_b; $dt = new DateTime($a); echo $dt->format('j F, Y') ?></strong></p>  
		<div class=styleNewsBody><?php echo nl2br($row->comment)?></div><hr />
	</td>
  	</tr>
  <?php endforeach;?>
</table>
        </div>
      </div>
    </div></div>
    
    <!--<div class="row">
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
  

	