
	 <div class="col-md-9" style="padding-left: 1.5%;">
  	<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">mSOS Blog <span class="glyphicon glyphicon-pencil" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        
        <form name="blog" method="post" action="<?php echo base_url().'blogs/post_blog'?>">
				<?php if($this->session->userdata("user_id")){ ?>
				<table class="table table-bordered">
					<tr>
						<td><strong>New Topic:</strong></td>
						<td><input type="text" name="heading" size="80" /></td>
					</tr>
					<tr>
						<td>New Post:</td>
						<td><textarea cols="60" name="blog_post"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button type="submit" name="btn" class="btn-default"><span class="glyphicon glyphicon-pencil"></span> Submit Blog</button>
						</td>
					</tr>
				</table>
				
				</form><hr/><?php } ?>
				<?php foreach($all as $row):
					foreach($row->bloger as $d):
					
					?>
				<table border="0" cellpadding="2" cellspacing="2" width="100%">
				<tbody>
				<tr>
				<td class="lightborderlow" valign="top"><span class="style32">

				<strong ><?php echo $row['title'] ?> </strong>| <span class="glyphicon glyphicon-user"></span> <?php echo $d['fname']?> | <span class="glyphicon glyphicon-calendar"></span> <?php $a = $row->time_p; $dt = new DateTime($a); echo $dt->format('j F, Y') ?>

				<br><br><div align="justify"> <?php echo  substr_replace ($row['post'],'...', 500);?><a target="_self" href="<?php echo site_url('blogs/view/'.$row->id)?>" style="font-size: 15px;font-style:italic">Read More</a>
				</div>
				<hr />
				
				
				</span>
				</td>

				</tr>
				</tbody>
				</table>
				
				<?php endforeach; ?>
				<?php endforeach; ?>
				
        
        </div>
      </div>
    </div></div>
    
    
  </div> 
  
	
	