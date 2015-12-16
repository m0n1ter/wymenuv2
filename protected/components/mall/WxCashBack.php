<?php 
/**
 * 
 * 
 * 消费返现 返积分类
 * 
 * $cashToal 是消费额 余额支付是消费的充值额  微信支付 是消费总额
 * $cashBackTotal 所用反现中的余额
 * 
 */
class WxCashBack
{
	
	
	public $dpid;
	public $userId;
	public $historyPoints;
	public $avaliablePoints;
	public $consumerCashBack = 0;
	public $consumerPointsBack = 0;
	
	public function __construct($dpid,$userId,$cashToal = 0,$cashBackTotal = 0){
		$this->dpid = $dpid;
		$this->userId = $userId;
		$this->cashToal = $cashToal;
		$this->cashBackTotal = $cashBackTotal;
		$this->getPoints();
		$this->getCashTpl();
		$this->getPointsTpl();
		$this->getConsumerBack();
	}
	public function getPoints(){
		$this->historyPoints = WxBrandUser::getHistoryPoints($this->userId,$this->dpid);
		$this->avaliablePoints = WxBrandUser::getAvaliablePoints($this->userId,$this->dpid);
	}
	/**
	 * 
	 * 获取返现模板
	 * 
	 */
	public function getCashTpl(){
		$sql = 'select * from nb_consumer_cash_proportion where dpid='.$this->dpid.' and ((point_type=0 and min_available_point < '.$this->historyPoints.' and max_available_point > '.$this->historyPoints.' ) or (point_type=1 and min_available_point < '.$this->avaliablePoints.' and max_available_point > '.$this->avaliablePoints.'))  and is_available=0 and delete_flag=0';
		$this->cahsTpl = Yii::app()->db->createCommand($sql)->queryRow();
	}
	/**
	 * 
	 * 获取返积分模板
	 * 
	 */
	public function getPointsTpl(){
		$sql = 'select * from nb_consumer_points_proportion where dpid='.$this->dpid.' and is_available=0 and delete_flag=0';
		$this->pointsTpl = Yii::app()->db->createCommand($sql)->queryRow();
	}
	/**
	 * 
	 * 计算最后返还结果
	 * 
	 */
	 public function getConsumerBack(){
 		if($this->cahsTpl){
 			$this->consumerCashBack = floor($this->cashToal*$this->cahsTpl['proportion_points']);
 		}
 		if($this->pointsTpl){
 			$this->consumerPointsBack = floor(($this->cashToal + $this->cashBackTotal)*$this->pointsTpl['proportion_points']);
 		}
	 }
	/**
	 * 
	 * 
	 * 插入对应当 记录表
	 * 
	 */
	public function inRecord($orderId){
		$time = time();
		if($this->cahsTpl&&$this->consumerCashBack){
			$se = new Sequence("cashback_record");
		    $lid = $se->nextval();
			$cashRecordData = array(
								'lid'=>$lid,
					        	'dpid'=>$this->dpid,
					        	'create_at'=>date('Y-m-d H:i:s',$time),
					        	'update_at'=>date('Y-m-d H:i:s',$time),
					        	'point_type'=>0,
					        	'type_lid'=>$orderId,
					        	'cashback_num'=>$this->consumerCashBack,
					        	'brand_user_lid'=>$this->userId,
					        	'is_sync'=>DataSync::getInitSync(),
								);
			$result = Yii::app()->db->createCommand()->insert('nb_cashback_record', $cashRecordData);
			
			$sql = 'update nb_brand_user set remain_back_money = remain_back_money + '.$this->consumerCashBack.' where lid='.$this->userId.' and dpid='.$this->dpid;
			Yii::app()->db->createCommand($sql)->execute();
		}
		if($this->pointsTpl&&$this->consumerPointsBack){
			$se = new Sequence("point_record");
		    $lid = $se->nextval();
			$pointRecordData = array(
								'lid'=>$lid,
					        	'dpid'=>$this->dpid,
					        	'create_at'=>date('Y-m-d H:i:s',$time),
					        	'update_at'=>date('Y-m-d H:i:s',$time),
					        	'point_type'=>0,
					        	'type_lid'=>$orderId,
					        	'point_num'=>$this->consumerPointsBack,
					        	'brand_user_lid'=>$this->userId,
					        	'is_sync'=>DataSync::getInitSync(),
								);
			$result = Yii::app()->db->createCommand()->insert('nb_point_record', $pointRecordData);
		}
							
	}
}