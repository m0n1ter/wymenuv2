<?php
/* @var $this ProductController */
	$baseUrl = Yii::app()->baseUrl;
        Yii::app()->clientScript->registerCssFile($baseUrl.'/css/style.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-btn.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-img.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-list.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-base.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-box.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-color.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/pic.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/ui-media.css'); 
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product-cn.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/reset.css');
	Yii::app()->clientScript->registerCssFile($baseUrl.'/css/product/slick.css');
        Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/language/'.Yii::app()->language.'.js');
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/product/zepto.js');
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/product/base64.js'); 
	Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/product/pic-pad-cn.js');
?>

	<?php $this->renderPartial('parentcategory',array('categoryId'=>$categoryId,'type'=>$type,'siteNoId'=>$siteNoId));?>
	<link href='<?php echo $baseUrl.'/css/product/reset.css';?>' rel='stylesheet' type='text/css'>
	<link href=<?php echo $baseUrl.'/css/product/slick.css';?> rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="<?php echo $baseUrl.'/js/product/slick.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo $baseUrl.'/js/product/classie.js';?>"></script>
	<script type="text/javascript" src="<?php echo $baseUrl.'/js/product/jquery.form.js';?>"></script>
	<script type="text/javascript" src="<?php echo $baseUrl.'/js/product/productpad-cn.js';?>"></script>
        <div id="page_0" class="up ub ub-ver" tabindex="0">
	<!--content开始-->
    <div id="content" class="ub-f1 tx-l t-bla ub-img6 res10">
                
		<div id="forum_list">
			<div class="outDiv" id="leftPic">
			</div>
			<div class="outDiv" id="rightPic">
			</div>
		</div>
    </div>
    <!--content结束-->
</div>
<form id="padOrderForm" action="/wymenuv2/product/confirmPadOrder/companyid/<?php echo $this->companyId;?>/padid/<?php echo $this->padId;?>" method="post">
<div class="product-pad-mask">
    <input type="hidden" id="id_client_is_temp" name="client_is_temp" value="1">
    <input type="hidden" id="id_client_site_id" name="client_site_id" value="0">
    <input type="hidden" id="id_client_site_name" name="client_site_name" value="新增临时座位！">
	<div class="mask-trangle"></div>
        <div class="product-mask-info"><div style="padding:1px;display: inline;"><?php echo yii::t('app','确认无误后，点击“确认”按钮下单。');?></div><button id="updatePadOrder"><?php echo yii::t('app','确认');?></button></div>
        <div class="product-mask-tip"><?php echo yii::t('app','提示：点击列表中的菜品名称,快速找到该菜品并增减数量。');?>
            <br><?php echo yii::t('app','也可以点击“取消”按钮，删除本订单');?> 
            <div id="cancelPadOrder"><?php echo yii::t('app','取消');?></div>
        </div>
	<div class="info">
	</div>
	<div class="product-bottom">
	</div>
</div>
</form>
<div class="setting-pad-mask">
	<div class="mask-trangle"></div>
	<div class="product-mask-info"><?php echo yii::t('app','点单帮助');?></div>
        <div class="line"></div>
        <div class="product-mask-info" id="clientSitelist"><?php echo yii::t('app','座位列表');?></div>
	<div class="line"></div>
        <div class="product-mask-info" id="printerShow"><?php echo yii::t('app','打印机校正');?></div>
	<div class="line"></div>
        <!--<div class="product-mask-info">中 文</div>
        <div class="line"></div>
        <div class="product-mask-info">日本語</div>
        <div class="line"></div>-->
        <div class="product-mask-info" id="pad-disbind-menu"><?php echo yii::t('app','解除绑定'); ?></div>
        <div class="line"></div>
        <div class="product-mask-info" id="pad-app-exit"><?php echo yii::t('app',"清除缓存");?></div>
	<div class="product-bottom">
	</div>
</div>
<div id="print_check" class="setting-pad-print">
    <div class="setting-print-info"><?php echo yii::t('app','打印机未校正，请校正');?><button style="background-color: grey" id="printerClose"><?php echo yii::t('app','关闭');?></button></div>
        <div class="setting-print-tip"><?php echo yii::t('app','第一步、点击“开始校正”按钮；');?></div>
        <div class="setting-print-tip"><?php echo yii::t('app','第二步、弹出对话框中点“确定”，对话框中有“复选框”，请点击打勾；');?>
            <br><img src="../../../../../../../img/print/1_<?php echo Yii::app()->language; ?>.jpg" /></div>
        <div class="setting-print-tip"><?php echo yii::t('app','第三步、如果打印失败，请再次重复上述过程，直到提示“打印成功”，并且打印机正常输出“打印校正成功”字样。');?>
            <br><img src="../../../../../../../img/print/2_<?php echo Yii::app()->language; ?>.jpg" /></div>
        <div class="setting-print-tip"><div style="padding:10px;display: inline;"><?php echo yii::t('app','请点击“开始校正”按钮，开始校正吧...');?></div><button id="printerCheck"><?php echo yii::t('app','开始校正');?></button></div>
</div>
<!-- 座位列表，每次打开时都刷新 -->
<div id="divid_client_sitelist" class="client_sitelist">
    
</div>
<!-- 加入订单动画 -->
<div class="aniele"></div>
<!-- 口味的页面  -->
<div class="taste-layer"></div>
<!-- 产品大图 -->
<div class="large-pic"></div>
<script type="text/javascript">
        var event_clicktouchstart="touchstart";
        var event_clicktouchend="touchend";
        if (typeof Androidwymenuprinter == "undefined") {
                event_clicktouchstart="click";
                event_clicktouchend="click";
          }else{
              event_clicktouchstart="touchstart";
              event_clicktouchend="touchend";
          }
	var cat = '<?php echo $categoryId;?>';
	var t = '<?php echo $type;?>';
	var isPad = '<?php echo $isPad;?>';
        var isPrintChecked=false;
        var padprinterping="local";
        var bodyfont=Math.round(10*document.body.clientWidth/1080)+"px";
        document.body.style.fontSize=bodyfont;
        //alert(window.screen.width);
        //alert(document.body.clientWidth);//big pad 1080 1920 pc:width1366
        //alert(document.body.style.fontSize);
	window.onload=function(type,catgory,pad)
	{
		type = t;
                catgory = cat;
		pad = isPad;
		getPicList(type,catgory,1);
	}	
	$(document).ready(function(){
                
		$('select[name="category"]').change(function(){
			var val = $(this).val();
			var obj = $('div[category="'+val+'"]:first');
			var height = obj.offset().top;
			$('body').scrollTop(height);
		});
		$(window).scroll(function(){
			$('.blockCategory').each(function(){
				var top = $(document).scrollTop();
				var categoryTop = $(this).offset().top;
				var height = $(this).height();
				if(parseInt(height)+parseInt(categoryTop) > parseInt(top)){
					var categoryId = $(this).attr('category');
                                        //alert(top);
					//$('select option[value="'+categoryId+'"]').attr('selected',true);
                                        $('#pad_category_select').val(categoryId);
					return false;
				}
			});
		});
                
                ///
                $.ajax({
 			url:'/wymenuv2/padbind/getPadPrinter',
 			async: false,
 			data:"companyid=<?php echo $_GET["companyid"]; ?>&padid=<?php echo $_GET["padid"]; ?>",
 			success:function(msg){
                            padprinterping=msg;
 			},
                        error:function(){
                            padprinterping="local";
 			},
 		});
        //alert(padprinterping);
                if (typeof Androidwymenuprinter != "undefined") {
                    
                    if(padprinterping!="local")
                    {
                        Androidwymenuprinter.printNetPing(padprinterping,10);
                    }
                 }
	});
        
       function menu_alarm(msg) {
            alert(msg);
       }
       
         <!--{"company_id":"0000000001","do_id":"sell_off",
	       //num <0 无数量限制-->
      function sell_off(do_data) {
            //alert(do_data);
            var data = eval('(' + do_data + ')');
            	//for(var item in data.do_data){
            	for(var item in data){
                    $('div.blockCategory[product-id="'+data[item].product_id+'"]').attr('store',data[item].num);
                    if(parseInt(data[item].num)==0){
                    	$('div.blockCategory[product-id="'+data[item].product_id+'"]').find('.sellOff').remove();
                    	var str = '<div class="sellOff sellOut"><?php echo yii::t('app',"已售完");?></div>';
                    	$('div.blockCategory[product-id="'+data[item].product_id+'"]').find('a').append(str);
                    }else if(parseInt(data[item].num) > 0){
                    	$('div.blockCategory[product-id="'+data[item].product_id+'"]').find('.sellOff').remove();
                    	var str = '<div class="sellOff">仅剩<br/>'+data[item].num+'份</div>';
                    	$('div.blockCategory[product-id="'+data[item].product_id+'"]').find('a').append(str);
                    }else{
                    	$('div.blockCategory[product-id="'+data[item].product_id+'"]').find('.sellOff').remove();
                    }
            	}             
       }       
       
       //加载所有座位
        $('#clientSitelist').on(event_clicktouchstart,function(){
            $('#divid_client_sitelist').load("<?php echo $this->createUrl('product/clientSitelist',array('companyId'=>$this->companyId,'padtype'=>'2'));?>");
            $('.setting-pad-mask').hide();
            $('#divid_client_sitelist').show();
        });
       
</script>