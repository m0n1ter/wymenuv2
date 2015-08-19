	<!-- BEGIN PAGE -->  
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
			<!-- BEGIN PAGE HEADER-->   
			<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','会员管理'),'subhead'=>yii::t('app','会员充值'),'breadcrumbs'=>array(array('word'=>yii::t('app','会员管理'),'url'=>$this->createUrl('member/index' , array('companyId'=>$this->companyId))),array('word'=>yii::t('app','会员充值'),'url'=>''))));?>
			
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-reorder"></i><?php echo yii::t('app','会员充值');?></div>
						</div>
						<div class="portlet-body form">
							<div class="col-md-2">
							</div>
							<div class="col-md-8">
								<div class="row">
									<div class="col-md-12" style="padding:0;margin-top:20px;">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="请输入卡号、手机、会员姓名" value="" />
											<span class="input-group-btn">
											<button class="btn blue getMember" type="button"> 搜 索 </button>
											</span>
									     </div>
							        </div>
								</div>
								<div class="row">
									<div class="col-md-7" style="padding:0;margin-top:10px;">
										<div class="table-responsive" style="font-size:20px;">
											<table class="table table-hover">
												<tbody>
													<tr>
														<td width="10%">卡号:</td>
														<td width="50%" id="selfcode"></td>
													</tr>
													<tr>
														<td>余额:</td>
														<td id="all-money"></td>
													</tr>
													<tr>
														<td>姓名:</td>
														<td id="name"></td>
													</tr>
													<tr>
														<td>手机:</td>
														<td id="mobile"></td>
													</tr>
													<tr>
														<td>邮箱:</td>
														<td id="email"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<div class="col-md-5" style="padding:0;margin-top:10px;">
									<!-- BEGIN FORM-->
									<?php $form=$this->beginWidget('CActiveForm', array(
											'id' => 'taste-form',
											'errorMessageCssClass' => 'help-block',
											'htmlOptions' => array(
												'class' => 'form-horizontal',
												'enctype' => 'multipart/form-data'
											),
									)); ?>
										<div class="form-body">
											<div class="form-group">
												<?php echo $form->label($model, 'reality_money',array('class' => 'col-md-6 control-label'));?>
												<div class="col-md-6">
													<?php echo $form->textField($model, 'reality_money',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('reality_money')));?>
													<?php echo $form->error($model, 'reality_money' )?>
												</div>
											</div>
											<div class="form-group">
												<?php echo $form->label($model, 'give_money',array('class' => 'col-md-6 control-label'));?>
												<div class="col-md-6">
													<?php echo $form->textField($model, 'give_money',array('class' => 'form-control','placeholder'=>$model->getAttributeLabel('give_money')));?>
													<?php echo $form->error($model, 'give_money' )?>
												</div>
											</div>
											<div class="col-md-offset-3 col-md-9">
													<button type="submit" class="btn blue"><?php echo yii::t('app','确定');?></button>
													<a href="<?php echo $this->createUrl('member/index' , array('companyId' => $model->dpid));?>" class="btn default"><?php echo yii::t('app','返回');?></a>                              
												</div>
											</div>
											<input type="hidden" name="MemberRecharge[rfid]" value="" />
											<input type="hidden" name="MemberRecharge[selfcode]" value="" />
									<?php $this->endWidget(); ?>
									<!-- END FORM--> 
									</div>
								</div>
							</div>
							<div class="col-md-2">
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->    
		</div>
		<!-- END PAGE --> 
		<script type="text/javascript">
		jQuery(document).ready(function(){
			$('.getMember').click(function(){
				var card = $(this).parents('.input-group').find('input').val();
				$.get('<?php echo $this->createUrl('/admin/member/getMember', array('companyId' => $model->dpid));?>/card/'+card,function(data){
					if(data.status){
						$('input[name="MemberRecharge[rfid]"]').val(rfid);
						$('input[name="MemberRecharge[selfcode]"]').val(selfcode);
						$('#selfcode').html(data.msg.selfcode)
						$('#all-money').html(data.msg.all_money)
						$('#name').html(data.msg.name)
						$('#mobile').html(data.msg.mobile)
						$('#email').html(data.msg.email)
					}else{
						alert(data.msg);
					}
				},'json') ;
			});
		});
		</script> 