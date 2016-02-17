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
		$this->getPointsValid();
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
		$this->cashTpl = Yii::app()->db->createCommand($sql)->queryRow();
	}
	/**
	 * 
	 * 
	 * 获取积分有效期
	 * 
	 */
	 public function getPointsValid(){
	 	$sql = 'select * from nb_points_valid where dpid='.$this->dpid.' and is_available=0 and delete_flag=0';
		$this->pointsValid = Yii::app()->db->createCommand($sql)->queryRow();
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
 		if($this->cashTpl){
 			$this->consumerCashBack = floor($this->cashToal*$this->cashTpl['proportion_points']);
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
		if($this->cashTpl&&$this->consumerCashBack){
			if($this->cashTpl['date_info_type']==1){
				$beginTime = date('Y-m-d H:i:s',$this->cashTpl['begin_timestamp']);
				$endTime = date('Y-m-d H:i:s',$this->cashTpl['	end_timestamp']);
			}elseif($this->cashTpl['date_info_type']==2){
				$beginTime = date('Y-m-d H:i:s',strtotime('+'.$this->cashTpl['fixed_begin_term'].' day'));
				$endTime = date('Y-m-d H:i:s',strtotime('+'.$this->cashTpl['fixed_term'].' month'));
			}
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
					        	'remain_cashback_num'=>$this->consumerCashBack,
					        	'begin_timestamp'=>$beginTime,
					        	'end_timestamp'=>$endTime,
					        	'brand_user_lid'=>$this->userId,
					        	'is_sync'=>DataSync::getInitSync(),
								);
			$result = Yii::app()->db->createCommand()->insert('nb_cashback_record', $cashRecordData);
			if(!$result){
				throw new Exception('现金支付记录失败');
			}
		}
		if($this->pointsTpl&&$this->consumerPointsBack){
			if($this->pointsValid){
				$endTime = date('Y-m-d H:i:s',strtotime('+'.$this->pointsValid['valid_days'].' day'));
			}else{
				$endTime = date('Y-m-d H:i:s',strtotime('+1 year'));
			}
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
					        	'end_time'=>$endTime,
					        	'is_sync'=>DataSync::getInitSync(),
								);
			$result = Yii::app()->db->createCommand()->insert('nb_point_record', $pointRecordData);
			if(!$result){
				throw new Exception('现金支付记录失败');
			}
		}
	}
	
	/**
	 * 
	 * 
	 * 使用消费余额
	 * $isAll 是否全部使用
	 * 
	 * 
	 */
	 public static function userCashBack($total,$userId,$dpid,$isAll = 0){
	 	$cash = 0;
	 	$now = date('Y-m-d H:i:s',time());
	 	$is_sync = DataSync::getInitSync();
	 	if($isAll){
			$sql = 'update nb_cashback_record set remain_cashback_num=0,is_sync='.$is_sync.'  where brand_user_lid = '.$userId.' and dpid='.$dpid.' and delete_flag=0 and ((point_type=0 and begin_timestamp < "'.$now.'" and end_timestamp > "'.$now.'") or point_type=1)';
			Yii::app()->db->createCommand($sql)->execute();
	 	}else{
	 		$sql = 'select * from nb_cashback_record where brand_user_lid = '.$userId.' and dpid='.$dpid.' and delete_flag=0 and ((point_type=0 and begin_timestamp < "'.$now.'" and end_timestamp > "'.$now.'") or point_type=1) order by end_timestamp asc , lid asc';
	 		$cashbacks = Yii::app()->db->createCommand($sql)->queryAll();
	 		foreach($cashbacks as $cashback){
	 			$cash += $cashback['remain_cashback_num'];
	 			if($cash < $total){
	 				$sql = 'update nb_cashback_record set remain_cashback_num=0,is_sync='.$is_sync.'  where lid = '.$cashback['lid'].' and dpid='.$dpid;
	 				Yii::app()->db->createCommand($sql)->execute();
	 			}else{
	 				
	 				$sql = 'update nb_cashback_record set remain_cashback_num = remain_cashback_num - '.($total - ($cash - $cashback['remain_cashback_num'])).',is_sync='.$is_sync.'  where lid = '.$cashback['lid'].' and dpid='.$dpid;
	 				Yii::app()->db->createCommand($sql)->execute();
	 				break;
	 			}
	 		}
	 	}
	 }
	
}