<script type="text/javascript" src="<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl.'/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js');?>"></script>
<script type="text/javascript" src="<?php Yii::app()->clientScript->registerScriptFile( Yii::app()->request->baseUrl.'/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js');?>"></script>
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
    <?php $this->widget('application.modules.admin.components.widgets.PageHeader', array('head'=>yii::t('app','数据中心'),'subhead'=>yii::t('app','营业数据'),'breadcrumbs'=>array(array('word'=>yii::t('app','会员数据'),'url'=>$this->createUrl('statementmember/list' , array('companyId'=>$this->companyId,'type'=>2,))),array('word'=>yii::t('app','支付方式报表'),'url'=>'')),'back'=>array('word'=>yii::t('app','返回'),'url'=>$this->createUrl('statementmember/list' , array('companyId' => $this->companyId,'type'=>2)))));?>

    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-globe"></i><?php echo yii::t('app','支付方式报表');?></div>
            <div class="actions">
                    
                    <div class="btn-group">
	                    <div class="input-group input-large date-picker input-daterange" data-date="10/11/2012" data-date-format="mm/dd/yyyy">
	                         <input type="text" class="form-control" name="begtime" id="begin_time" placeholder="<?php echo yii::t('app','起始时间');?>" value="<?php echo $begin_time; ?>">  
	                         <span class="input-group-addon">~</span>
	                         <input type="text" class="form-control" name="endtime" id="end_time" placeholder="<?php echo yii::t('app','终止时间');?>"  value="<?php echo $end_time;?>">           
	                    </div>  
                    </div>	
					
                    <div class="btn-group">
                                    <button type="submit" id="btn_time_query" class="btn red" ><i class="fa fa-pencial"></i><?php echo yii::t('app','查 询');?></button>
                                    <button type="submit" id="excel"  class="btn green" ><i class="fa fa-pencial"></i><?php echo yii::t('app','导出Excel');?></button>				
                                    <!-- <a href="<?php echo $this->createUrl('statements/export' , array('companyId' => $this->companyId));?>/text/<?php echo $text;?>/begin_time/<?php echo $begin_time;?>/end_time/<?php echo $end_time;?>" class="btn green" ><i class="fa fa-pencial"></i><?php echo yii::t('app','导出Excel2');?></a> -->
                    </div>			
                </div>
            </div> 
			
			<div class="portlet-body" id="table-manage">
			<table class="table table-striped table-bordered table-hover" id="sample_1">
		        <thead>
		            <tr>
		                <?php  $grouppay_item = 0;?>
		                <!-- 	<th>序号</th> -->
		               <th><?php echo yii::t('app','店铺');?></th>
		               <th><?php echo yii::t('app','总单数');?></th> 
		               <th><?php echo yii::t('app','毛利润');?></th> 
		                  
		               <th><?php echo yii::t('app','系统券');?></th>
		               <th><?php echo yii::t('app','积分');?></th> 
		               <th><?php echo yii::t('app','微信储值支付');?></th>                                                            
		
		            </tr>
		        </thead>
				<tbody>
		        <?php if( $models) :?>
		        <!--foreach-->
		        <?php $a=1;?>
		        <?php 
		         $orders_total=0;      // 总单数
		         $grossprofit_total=0; // 总毛利润
		         $discount_total=0;    // 总优惠
		         $gather_total=0;      // 实收款 
		         $cash_total=0;        // 现金
		         $wechat_total = 0;    // 微信
		         $wxorder_total = 0;    // 微信点单
		         $wxwaimai_total = 0;    // 微信外卖
		         $alipay_total = 0;    // 支付宝
		         $unionpay_total=0;    // 银联
		         $vipcard_total = 0;   // 会员卡 
		         $grouppay_arr = array();   //支付宝/美团
		        for($i =0;$i<$grouppay_item;$i++){
		           $grouppay_arr[$i] =0; 
		           // $grouppay.$i =0;
		        }
		        $all_wxcards = 0;
		        $all_wxcharges = 0;
		        $all_wxpoints = 0;
		        $retreats = 0;
		        foreach ($models as $model): ?>
		
		        <tr class="odd gradeX">
		        	
		        	<td><?php echo $model->company->company_name;?></td>
		            <td><?php 
		                $orders_total = $orders_total+$model->all_nums;    //总单数
		                echo $model->all_nums;?></td>
		             <td><?php 
		                $reality_all = $this->getGrossProfit($model->dpid,$begin_time,$end_time);
		                $grossprofit_total+=$reality_all;
		                echo $reality_all;
		                ?></td>
		            
		            <td><?php 
		                $wxcard=$this->getPaymentPrice($model->dpid,$begin_time,$end_time,0,9);
		                $all_wxcards = $all_wxcards + $wxcard;
		                echo $wxcard; 
		                ?>
		            </td>
		            <td><?php 
		                $wxpoint=$this->getPaymentPrice($model->dpid,$begin_time,$end_time,0,8);
		                $all_wxpoints = $all_wxpoints + $wxpoint;
		                echo $wxpoint; 
		                ?>
		            </td>
		            <td><?php 
		                $wxcharge=$this->getPaymentPrice($model->dpid,$begin_time,$end_time,0,10);
		                $all_wxcharges = $all_wxcharges + $wxcharge;
		                echo $wxcharge; 
		                ?>
		            </td>
										
		        </tr>
		       
		        <?php endforeach;?>	
		      
		        <tr>
		            <td><?php echo "总计";?></td>
		            <td><?php echo $orders_total; ?></td>
		            <td><?php  echo $grossprofit_total;?></td>
		           
		            <td><?php echo $all_wxcards;?></td>
		            <td><?php echo $all_wxpoints;?></td>
		            <td><?php echo $all_wxcharges;?></td>
		            
										
		        </tr>
		      <?php endif;?> 
		       
		        
		        </tbody>
    	</table>

					
    </div>
</div>
			<!-- END EXAMPLE TABLE PORTLET-->
</div>
	<!-- END PAGE CONTENT-->
</div>
<!-- END PAGE -->

<script>
//var str=new array();						
jQuery(document).ready(function(){
	if (jQuery().datepicker) {
		$('.date-picker').datepicker({
			format: 'yyyy-mm-dd',
			language: 'zh-CN',
			rtl: App.isRTL(),
			autoclose: true
		});
		$('body').removeClass("modal-open");
	}
});
     $('#btn_time_query').click(function time() {  

     	var begin_time = $('#begin_time').val();
     	var end_time = $('#end_time').val();
     	var text = $('#text').val();
     	var userid = $('#userid').val();
     	location.href="<?php echo $this->createUrl('statementmember/paymentReport' , array('companyId'=>$this->companyId ));?>/begin_time/"+begin_time+"/end_time/"+end_time+"/text/"+text+"/userid/"+userid     

	});
	
	$('#excel').click(function excel(){
		layer.msg('暂未开放');return false;
		var begin_time = $('#begin_time').val();
		var end_time = $('#end_time').val();
		var text = $('#text').val();
		var userid = $('#userid').val();
		if(confirm('确认导出并且下载Excel文件吗？')){
			location.href="<?php echo $this->createUrl('statements/paymentExport' , array('companyId'=>$this->companyId));?>/begin_time/"+begin_time+"/end_time/"+end_time+"/text/"+text+"/userid/"+userid;
		}else{
			// location.href="<?php echo $this->createUrl('statements/export' , array('companyId'=>$this->companyId ));?>/str/"+str+"/begin_time/"+begin_time+"/end_time/"+end_time +"/text/"+text;
		}
	});

</script> 
