<div class="page-content">
	<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
	<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Modal title</h4>
				</div>
				<div class="modal-body">
					Widget settings form goes here
				</div>
				<div class="modal-footer">
					<button type="button" class="btn blue">Save changes</button>
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
	<style>
	.content a{text-decoration: none; box-shadow: 4px 4px 4px #888888;  float:left; display:inline-block; width:30%; height:60px; border-radius:5px; line-height:60px; text-align:center; vertical-align:middle; margin-left:2%; margin-top:2%; font-size:30px; font-weight:bold; color:#fff;}
	.content a:hover{background:#F00; }
	.one{background:#99CCCC;}
	.two{background:#FFCC99;}
	.three{background:#FFCCCC;}
	.four{background:#FF9999;}
	.five{background:#CC99CC;}
	</style>
	<!-- BEGIN PAGE CONTENT-->
	<div class="row" style="height: 760px;">
		<div class="content">
			<a href="<?php echo $this->createUrl('/admin/stockSetting/index',array('companyId'=>$this->companyId));?>" class="one">安全库存设置</a>
		</div>
	</div>
	<!-- END PAGE CONTENT-->
	