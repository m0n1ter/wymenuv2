<?php
/* @var $this ProductController */
	$parentCategorys = ProductCategory::getCategorys($this->companyId);	
	$result = ProductClass::getCartInfo($this->companyId,$siteNoId);	
	$resArr = explode(':',$result);
	$price = $resArr[0];
	$nums = $resArr[1];
//	var_dump($parentCategorys);exit;
?>
<?php 
	$baseUrl = Yii::app()->baseUrl;
?>
<link rel="stylesheet" type="text/css"  href="<?php echo $baseUrl.'/css/product/categorypad.css';?>" />
<div class="fixed-top">
  <div class="padsetting"></div>
  <div class="top-left"> 
      
  	<div class="top-left-right">            
	<select name="category">
		<?php if($parentCategorys):?>
		<?php foreach($parentCategorys as $categorys):?>
			<optgroup class="partents" label="<?php echo $categorys['category_name'];?>" lid="<?php echo $categorys['lid'];?>"><?php echo $categorys['category_name'];?></optgroup>
			<?php foreach($categorys['children'] as $category):?>
				<option class="child" value="<?php echo $category['lid'];?>"><?php echo Helper::truncate_utf8_string($category['category_name'],6);?></option>
			<?php endforeach;?>
		<?php endforeach;?>
		<?php endif;?>
	</select>
	</div>
  </div>
   <div class="top-middle">
   	<button id="updatePadOrder">下单并打印</button>
   </div>
  <div class="top-right">
	  <div class="shoppingCart">
	     <div class="total-num num-circel"><?php echo $nums;?></div>
	  </div>
	  <div class="total-price"><?php echo Money::priceFormat($price);?></div>
  	<div class="clear"></div>
  </div>
</div>
