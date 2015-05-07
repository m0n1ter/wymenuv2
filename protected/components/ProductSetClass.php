<?php
class ProductSetClass
{
	//获取套餐某一产品的价格
	public static function GetProductSetPrice($dpid,$setId,$productId){
		$sql = 'select * from nb_product_set_detail where set_id=:setId and product_id=:productId and dpid=:dpid';
		$connect = Yii::app()->db->createCommand($sql);
		$connect->bindValue(':setId',$setId);
		$connect->bindValue(':productId',$productId);
		$connect->bindValue(':dpid',$dpid);
		$product = $connect->queryRow();
		$price = $product['price'];
		return $price;
	}
	//获取套餐某一产品的价格
	public static function GetTotalProductSetPrice($dpid,$setId){
		$sql = 'select sum(price) as price from nb_product_set_detail where set_id=:setId and dpid=:dpid and delete_flag=0';
		$connect = Yii::app()->db->createCommand($sql);
		$connect->bindValue(':setId',$setId);
		$connect->bindValue(':dpid',$dpid);
		$product = $connect->queryRow();
		$price = $product['price'];
		return $price;
	}
	//获取套餐信息
	public static function GetProductSetName($setId){
		$sql = 'select * from nb_product_set where lid=:lid';
		$connect = Yii::app()->db->createCommand($sql);
		$connect->bindValue(':lid',$setId);
		$productset = $connect->queryRow();
		$name = $productset['set_name'];
		return $name;
	}
        
        public static function getSetlist($companyId){
		$criteria = new CDbCriteria;
		$criteria->condition =  't.delete_flag=0 and t.dpid='.$companyId ;
		$criteria->order = ' t.lid asc ';
		
		$models = ProductSet::model()->findAll($criteria);
                
		//return CHtml::listData($models, 'lid', 'category_name','pid');
		//$options = array();
		$options = array('--请选择分类--');
		if($models) {
			foreach ($models as $model) {
                                    $options[$model->lid] = $model->set_name;
                        }
		 //var_dump($options);exit;
		}
		return $options;
	}
}