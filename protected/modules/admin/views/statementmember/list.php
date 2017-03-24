
<style>
		span.tab{
			color: black;
			border-right:1px dashed white;
			margin-right:10px;
			padding-right:10px;
			display:inline-block;
		}
                span.tab-active{
			color:white;
		}
		.ku-item{
			width:100px;
			height:100px;
			margin-right:20px;
			margin-top:20px;
			margin-left:20px;
			border-radius:5px !important;
		/*	border:2px solid black;
			box-shadow: 5px 5px 5px #888888;*/
			vertical-align:middle;
		}
		.ku-item-info{
			width:144px;
			font-size:2em;
			color:black;
			text-align:center;
		}
		.ku-purple{
			
		}
		.ku-item.sdbb{
			background-image:url(../../../../../../img/waiter/icon-sdbb.png);
			background-position: 13px 15px;
    		background-repeat: no-repeat;
			background-size: 80%;
		}	
		.ku-item.yysj{
			background-image:url(../../../../../../img/waiter/icon-yysj.png);
			background-position: -750px 16px;
    		background-repeat: no-repeat;
		}
		.margin-left-right{
			margin-left:10px;
			margin-right:10px;
		}
		.cf-black{
			color: #000 !important;
			
		}		
	</style>
<div class="page-content">
	<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->               
	
	<!-- /.modal -->
	<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
	
	<!-- BEGIN PAGE CONTENT-->
	<?php if($type==2):?>
		<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('breadcrumbs'=>array(array('word'=>yii::t('app','会员数据'),'url'=>''))));?>
	<?php endif;?>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet purple box">
			      	<div class="portlet-title">
					<div class="caption"><em class=" fa <?php if($type==0){echo '';}else{echo 'cf-black';}?> fa-shopping-cart">&nbsp</em><a href="<?php echo $this->createUrl('statements/list',array('companyId'=>$this->companyId,'type'=>0));?>"><span class="tab <?php if($type==0){ echo 'tab-active';}?>"><?php echo yii::t('app','营业数据');?></span></a></div>
					<div class="caption"><em class=" fa <?php if($type==2){echo '';}else{echo 'cf-black';}?> fa-shopping-cart">&nbsp</em><a href="<?php echo $this->createUrl('statementmember/list',array('companyId'=>$this->companyId,'type'=>2));?>"><span class="tab <?php if($type==2){ echo 'tab-active';}?>"><?php echo yii::t('app','会员数据');?></span></a></div>
				</div>
				<div class="portlet-body" style="min-height: 750px">
					
					
					<?php if($type==2):?>
					<a href="<?php echo $this->createUrl('statementmember/wxmemberReport',array('companyId' => $this->companyId,'text'=>'3','begin_time'=>date('Y-m-d',time()),'end_time'=>date('Y-m-d',time()),'page'=>1));?>">
						<div class="pull-left margin-left-right">
							<div class="ku-item ku-grey yysj"></div>
							<div class="ku-item-info">微信会员</div>
						</div>
					</a>
					<a href="<?php echo $this->createUrl('statementmember/cardmemberReport',array('companyId' => $this->companyId,'text'=>'3','begin_time'=>date('Y-m-d',time()),'end_time'=>date('Y-m-d',time()),'page'=>1));?>">
						<div class="pull-left margin-left-right">
							<div class="ku-item ku-grey sdbb"></div>
							<div class="ku-item-info">实卡会员</div>
						</div>
					</a>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<!-- END PAGE CONTENT-->
	<script>
        $(document).ready(function() {
            $('.relation').click(function(){
                $('.modal').modal();
           });
        });
	</script>