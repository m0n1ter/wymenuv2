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
    <?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('breadcrumbs'=>array(array('word'=>yii::t('app','仓库管理'),'url'=>$this->createUrl('tmall/list' , array('companyId'=>$this->companyId,'type'=>2,))),array('word'=>yii::t('app','供应商信息列表'),'url'=>'')),'back'=>array('word'=>yii::t('app','返回'),'url'=>$this->createUrl('tmall/list' , array('companyId' => $this->companyId,'type' => '2',)))));?>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id' => 'supplier-form',
            'action' => $this->createUrl('supplier/delete' , array('companyId' => $this->companyId)),
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
                    <div class="caption"><i class="fa fa-globe"></i><?php echo yii::t('app','供应商信息列表');?></div>
                    <div class="actions">

                        <a href="<?php echo $this->createUrl('Supplier/create' , array('companyId' => $this->companyId));?>" class="btn blue"><i class="fa fa-pencil"></i> <?php echo yii::t('app','添加');?></a>
                        <div class="btn-group">
                            <button type="submit"  class="btn red" ><i class="fa fa-ban"></i> <?php echo yii::t('app','删除');?></button>
                        </div>
                    </div>
                </div>
                <div class="portlet-body" id="table-manage">
                    <div class="dataTables_wrapper form-inline">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="sample_1">
                                <thead>
                                <tr>
                                    <th class="table-checkbox"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                                    <th ><?php echo yii::t('app','供应商类别');?></th>
                                    <th ><?php echo yii::t('app','供应商名称');?></th>
                                    <th><?php echo yii::t('app','邮编');?></th>
                                    <th><?php echo yii::t('app','公司地址');?></th>
                                    <th><?php echo yii::t('app','联系人');?></th>
                                    <th><?php echo yii::t('app','联系电话');?></th>
                                    <th><?php echo yii::t('app','传真');?></th>
                                    <th><?php echo yii::t('app','电子邮箱');?></th>
                                    <th><?php echo yii::t('app','开户银行');?></th>
                                    <th><?php echo yii::t('app','开户账号');?></th>
                                    <th><?php echo yii::t('app','纳税账号');?></th>
                                    <th><?php echo yii::t('app','备注');?></th>
                                    <th><?php echo yii::t('app','操作');?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if($models) :?>
                                    <?php foreach ($models as $model):?>
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" class="checkboxes" value="<?php echo $model->lid;?>" name="ids[]" /></td>
                                            <td ><?php echo $this->getClassName($model->classification_id);?></td>
                                            <td><?php echo $model->manufacturer_name;?></td>
                                            <td><?php echo $model->post_code;?></td>
                                            <td><?php echo $model->address;?></td>
                                            <td><?php echo $model->contact_name;?></td>
                                            <td><?php echo $model->contact_tel;?></td>
                                            <td><?php echo $model->contact_fax;?></td>
                                            <td><?php echo $model->email;?></td>
                                            <td><?php echo $model->bank;?></td>
                                            <td><?php echo $model->bank_account;?></td>
                                            <td><?php echo $model->tax_account;?></td>
                                            <td><?php echo $model->remark;?></td>
                                            <td class="center">
                                                <a href="<?php echo $this->createUrl('Supplier/update',array('id' => $model->lid , 'companyId' => $model->dpid));?>"><?php echo yii::t('app','编辑');?></a>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                        <?php if($pages->getItemCount()):?>
                            <div class="row">
                                <div class="col-md-5 col-sm-12">
                                    <div class="dataTables_info">
                                        <?php echo yii::t('app','共');?> <?php echo $pages->getPageCount();?> <?php echo yii::t('app','页');?> , <?php echo $pages->getItemCount();?> <?php echo yii::t('app','条数据');?> , <?php echo yii::t('app','当前是第');?> <?php echo $pages->getCurrentPage()+1;?> <?php echo yii::t('app','页');?>
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
            $('#material-form').submit(function(){
                if(!$('.checkboxes:checked').length){
                    alert("<?php echo yii::t('app','请选择要删除的项');?>");
                    return false;
                }
                return true;
            });
            $('.s-btn').on('switch-change', function () {
                var id = $(this).find('input').attr('pid');
                $.get('<?php echo $this->createUrl('mfrInformation/status',array('companyId'=>$this->companyId));?>/id/'+id);
            });
            $('.r-btn').on('switch-change', function () {
                var id = $(this).find('input').attr('pid');
                $.get('<?php echo $this->createUrl('mfrInformation/recommend',array('companyId'=>$this->companyId));?>/id/'+id);
            });
            $('#selectCategory').change(function(){
                var cid = $(this).val();
                location.href="<?php echo $this->createUrl('mfrInformation/index' , array('companyId'=>$this->companyId));?>/cid/"+cid;
            });
        });
    </script>