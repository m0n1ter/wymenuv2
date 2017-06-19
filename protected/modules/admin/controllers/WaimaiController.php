<?php
class WaimaiController extends BackendController
{
	public function actions() {
		return array(
			'upload'=>array(
				'class'=>'application.extensions.swfupload.SWFUploadAction',
				//注意这里是绝对路径,.EXT是文件后缀名替代符号
				'filepath'=>Helper::genFileName().'.EXT',
				//'onAfterUpload'=>array($this,'saveFile'),
			)
		);
	}
	public function actionList(){
		// $companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		
		$this->render('list');
	}
	public function actionIndex(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		$epoiid= 'ePoiId='.$companyId." and delete_flag=0";
		$tokenmodel = MeituanToken::model()->find($epoiid);
		$signkey='8isnqx6h2xewfmiu';
		$developerId=100746;
		$this->render('index',array(
			"signkey"=>$signkey,
			"developerId"=>$developerId,
			"tokenmodel"=>$tokenmodel
			));
	}
	public function actionCaipinyingshe(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		$epoiid= 'ePoiId='.$companyId." and delete_flag=0";
		$tokenmodel = MeituanToken::model()->find($epoiid);
		// print_r($tokenmodel);exit;
		$criteria = " dpid=".$companyId." and delete_flag=0";
		$productmodels = Product::model()->findAll($criteria);
		$setmodels = ProductSet::model()->findAll($criteria);
		// print_r($productmodels);exit;
		$this->render('caipinyingshe',array(
				"productmodels"=>$productmodels,
				"tokenmodel"=>$tokenmodel,
				"companyId"=>$companyId,
				"setmodels"=>$setmodels
			));
	}
	public function actionDpbd(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		$signkey = '8isnqx6h2xewfmiu';
		// echo $signkey;exit;
		$developerId = 100746;
		$this->render('dpbd',array(
			'companyId'=>$companyId,
			'developerId'=>$developerId,
			'signkey'=>$signkey
			));
	}
	public function actionJcbd(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		$epoiid = "ePoiId=".$companyId." and delete_flag=0";
		$tokenmodel = MeituanToken::model()->find($epoiid);
		$this->render('jcbd',array(
			'tokenmodel' =>$tokenmodel
			));
	}
}
?>