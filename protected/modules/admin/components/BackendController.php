<?php
class BackendController extends CController
{
	public $layout = '/layouts/main_admin';
	public $companyId = 0;
	public function beforeAction($action) {
		parent::beforeAction($action);
		$controllerId = Yii::app()->controller->getId();
		$action = Yii::app()->controller->getAction()->getId();   
		//var_dump(Yii::app()->user->companyId);             
        //$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
        //var_dump(Yii::app()->user->role);exit;
		if(Yii::app()->user->isGuest) {
			if($controllerId != 'login' && $action != 'upload') {
				$this->redirect(Yii::app()->params['admin_return_url']);
			}
		}elseif(Yii::app()->user->role > User::USER &&$controllerId != 'login'){
			$this->redirect(Yii::app()->params['admin_return_url']);
		}else{
			$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
			
			$role = Yii::app()->user->role;
			//var_dump($companyId);var_dump($role);exit;
			
			
			if(Yii::app()->user->role > User::ADMIN && $controllerId != 'login' && Yii::app()->user->companyId != $companyId){
				//var_dump($controllerId);exit;
				//$this->redirect(Yii::app()->request->urlReferrer);
			}elseif(Yii::app()->user->role == User::ADMIN && $controllerId != 'login'){
				$dpids = Helper::getCompanyIds(Yii::app()->request->getParam('companyId',"0000000000"));
				$dpids = Helper::getCompanyIds(Yii::app()->user->companyId);
				//var_dump($dpids);exit;
				if($dpids == null){
					$dpids = array(0);
				}
				$results =  array_search($companyId, $dpids);
				
				if($results){
					$this->companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
				}else{
					//var_dump($companyId);var_dump($dpids);var_dump($results);var_dump(Yii::app()->user->role);exit;
					$this->redirect(Yii::app()->params['admin_return_url']);
					//$this->redirect(Yii::app()->request->urlReferrer);
				}
			}
			else{
				$this->companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
				//var_dump($this->companyId);exit;
			}
		}
                Until::isOperateValid($controllerId, $action,$this->companyId,$this);
                
		return true ;
	}
        // 
        
	
	
// 	public function beforeAction($action) {
// 		parent::beforeAction($action);
// 		$controllerId = Yii::app()->controller->getId();
// 		$action = Yii::app()->controller->getAction()->getId();
// 		//$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
// 		if(Yii::app()->user->isGuest) {
// 			if($controllerId != 'login' && $action != 'upload') {
// 				$this->redirect(Yii::app()->params['admin_return_url']);
// 			}
// 		} elseif(Yii::app()->user->role > User::USER &&$controllerId != 'login'){
// 			$this->redirect(Yii::app()->params['admin_return_url']);
// 		}else{
// 			//if(yii::app()->user->role == User::POWER_ADMIN){
// 			$this->companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
// 			//}elseif(yii::app()->user->role != User::POWER_ADMIN ){
// 			//	$this->redirect(Yii::app()->request->urlReferrer);
// 			//}
// 		}
// 		Until::isOperateValid($controllerId, $action,$this->companyId,$this);
	
// 		return true ;
// 	}
	
	
	
        
//        public function afterAction($action) {
//		parent::afterAction($action);
////		$controllerId = Yii::app()->controller->getId();
////		$action = Yii::app()->controller->getAction()->getId();                
////                
////		if(Yii::app()->user->isGuest) {
////			if($controllerId != 'login' && $action != 'upload') {
////				$this->redirect(Yii::app()->params['admin_return_url']);
////			}
////		} elseif(Yii::app()->user->role > User::WAITER &&$controllerId != 'login'){
////			$this->redirect(Yii::app()->params['admin_return_url']);
////		}else {
////			$this->companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId',"0000000000"));
////		}
//                //判断和上次同步的时间是否超过5分钟，
//                //判断云端网络是否连接
//                //如果超过则从云端下载数据；
//                //如果超过则将本地数据上传到云端；
//		return true ;
//	}
}