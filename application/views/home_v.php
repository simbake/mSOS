<?php if($this->session->userdata("user_indicator")=='Administrator'){ ?>
<div class="col-md-6" style="padding-left: 3%;">
	<?php } else{ ?>
	<div class="col-md-8" style="padding-left: 3%;">

	<?php } ?>
<div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Map <span class="glyphicon glyphicon-globe" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        	<?php //echo $map['html']; ?>
        </div>
      </div>
    </div></div>
    
    <div class="row">
    <div class="panel panel-success">
      <div class="panel-heading">
        <h3 class="panel-title">Graph <span class="glyphicon glyphicon-stats" style=""></span></h3>
      </div>
      <div class="panel-body" style="overflow-y: auto">
        <div style="/*border: 1px solid #036;*/ ;" id="container">
        <?php echo renderChart("" . base_url() . "Scripts/FusionCharts/StackedColumn2D.swf", "", $strXML_e5, "e_6", '', 400, false, true); ?>
        </div>
      </div>
    </div>
    </div>
    
    </div>
    <?php
    
    if($this->session->userdata("user_indicator")=='Administrator'){
    
     ?>
    <div class="col-md-2">			
    	
	<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3">
            <div class="panel-group" id="accordion">
	<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span class="glyphicon glyphicon-sort-by-attributes">
                            </span> <a data-toggle="collapse" data-parent="#accordion" href="#disease_collapse">Map Filter</a>
                        </h4>
                    </div>
                    <div id="disease_collapse" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                               <?php foreach($all_diseases as $diseases_all){  ?>
                                <tr>
                                    <td>
                                         <a href="<?php echo base_url().'home_controller/home/'.$diseases_all->id ?>"><?php echo $diseases_all->Full_Name  ?></a>
                                    </td>
                                </tr>
                              <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
               </div>
              </div>
               </div>
                </div>
              
	
	</div><?php } ?>