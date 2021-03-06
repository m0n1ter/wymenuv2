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
	<?php if($types):?>
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('breadcrumbs'=>array(array('word'=>yii::t('app','仓库设置'),'url'=>$this->createUrl('tmall/list' , array('companyId'=>$this->companyId,'type'=>1,))),array('word'=>yii::t('app','配送员设置'),'url'=>'')),'back'=>array('word'=>yii::t('app','返回'),'url'=>$this->createUrl('tmall/list' , array('companyId' => $this->companyId,'type' => '1',)))));?>
	<?php else:?>
	<?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('breadcrumbs'=>array(array('word'=>yii::t('app','餐桌设置'),'url'=>$this->createUrl('product/list' , array('companyId'=>$this->companyId,'type'=>1,))),array('word'=>yii::t('app','送餐员设置'),'url'=>'')),'back'=>array('word'=>yii::t('app','返回'),'url'=>$this->createUrl('product/list' , array('companyId' => $this->companyId,'type' => '1',)))));?>
	<?php endif;?>
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<?php $form=$this->beginWidget('CActiveForm', array(
				'id' => 'companywifi-form',
				'action' => $this->createUrl('takeawayMember/delete' , array('companyId' => $this->companyId,'types'=>$types)),
				'errorMessageCssClass' => 'help-block',
				'htmlOptions' => array(
					'class' => 'form-horizontal',
					'enctype' => 'multipart/form-data'
				),
		)); ?>
		<div class="col-md-12">
			<!-- BEGIN EXAMPLE TABLE PORTLET-->
			<div class="portlet box purple">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-globe"></i><?php if($types) echo yii::t('app','配送员列表');else echo yii::t('app','送餐员列表');?></div>
					<div class="actions">
						<?php if(Yii::app()->user->role <= User::GROUPER):?>
						<a href="<?php echo $this->createUrl('takeawayMember/create', array('companyId' => $this->companyId,'types'=>$types));?>" class="btn blue"><i class="fa fa-pencil"></i> <?php echo yii::t('app','添加');?></a>
						<div class="btn-group">
							<button type="submit"  class="btn red"><i class="fa fa-ban"></i> <?php echo yii::t('app','删除');?></button>
						</div>
						<?php endif;?>
						
					</div>
				</div>
				<div class="portlet-body" id="table-manage">
				<div class="dataTables_wrapper form-inline">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="sample_1">
						<thead>
							<tr>
								<th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
								<?php if(Yii::app()->user->role <User::ADMIN):?>
                                <th><?php echo yii::t('app','唯一ID');?></th>
                                <?php endif;?>
								<th><?php echo yii::t('app','编号');?></th>
								<th><?php if($types) echo yii::t('app','配送员名称');else echo yii::t('app','送餐员名称');?></th>
								<th><?php echo yii::t('app','手机号码');?></th>
								<th><?php echo yii::t('app','创建时间');?></th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($models as $model):?>
							<tr class="odd gradeX">
								<td><input type="checkbox" class="checkboxes" value="<?php echo $model->lid;?>" name="ids[]" /></td>
								<?php if(Yii::app()->user->role <User::ADMIN):?>
                                <td><?php echo $model->lid;?></td>
                                <?php endif;?>
                                <td><?php echo $model->cardId;?></td>
								<td><?php echo $model->member_name;?></td>
								<td><?php echo $model->phone_number;?></td>
								<td><?php echo $model->create_at;?></td>
								<td class="center">
									<a class="btn btn-sm blue" href="<?php echo $this->createUrl('takeawayMember/update' , array('id' => $model->lid , 'companyId' => $this->companyId,'types'=>$types));?>"><?php echo yii::t('app','编辑');?></a>
								</td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					</div>
					<?php if($pages->getItemCount()):?>
						<div class="row">
							<div class="col-md-5 col-sm-12">
								<div class="dataTables_info">
									<?php echo yii::t('app','共');?> <?php echo $pages->getPageCount();?> <?php echo yii::t('app','页');?>  , <?php echo $pages->getItemCount();?> <?php echo yii::t('app','条数据');?> , <?php echo yii::t('app','当前是第');?> <?php echo $pages->getCurrentPage()+1;?> <?php echo yii::t('app','页');?>
								</div>
							</div>
							<div class="col-md-7 col-sm-12">
								<div class="dataTables_paginate paging_bootstrap">
								<?php $this->widget('CLinkPager', array(
									'pages' => $pages,
									'header'=>'',
									'firstPageLabel' => '<<',
									'lastPageLabel' => '>>',
									'firstPageCssClass' => '',
									'lastPageCssClass' => '',
									'maxButtonCount' => 8,
									'nextPageCssClass' => '',
									'previousPageCssClass' => '',
									'prevPageLabel' => '<',
									'nextPageLabel' => '>',
									'selectedPageCssClass' => 'active',
									'internalPageCssClass' => '',
									'hiddenPageCssClass' => 'disabled',
									'htmlOptions'=>array('class'=>'pagination pull-right')
								));
								?>
								</div>
							</div>
						</div>
						<?php endif;?>					
					</div>
				</div>
			</div>
			<!-- END EXAMPLE TABLE PORTLET-->
		</div>
	<?php $this->endWidget(); ?>
	</div>
	<!-- END PAGE CONTENT-->
	<script type="text/javascript">
	$(document).ready(function(){
		$('#companywifi-form').submit(function(){
			if(!$('.checkboxes:checked').length){
				alert("<?php echo yii::t('app','请选择要删除的项');?>");
				return false;
			}
			return true;
		});
	});
	</script>