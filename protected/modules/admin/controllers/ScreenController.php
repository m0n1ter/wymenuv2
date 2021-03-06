<?php
class ScreenController extends BackendController
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
	public function beforeAction($action) {
		parent::beforeAction($action);
		if(!$this->companyId && $this->getAction()->getId() != 'upload') {
			Yii::app()->user->setFlash('error' , yii::t('app','请选择公司'));
			$this->redirect(array('company/index'));
		}
		return true;
	}
	public function actionIndex(){
		$download = Yii::app()->request->getParam('download',0);
		if($download){
			$prizes = array();
			$openid = '';
			$today = date('Y-m-d',time());
			$num = Yii::app()->request->getPost('num');
			$account = WxAccount::get($this->companyId);
			$openid .= $account['appid']."\r\n";
			$sql = 'select  t.branduser_lid,t.create_at,t.content,t1.nickname,t1.openid,t1.card_id from nb_discuss t,nb_brand_user t1 where t.dpid=t1.dpid and t.branduser_lid=t1.lid and t.dpid=:dpid and t.create_at > :today and t.delete_flag=0 group by branduser_lid';
			$models = Yii::app()->db->createCommand($sql)
									->bindValue(':dpid',$this->companyId)
									->bindValue(':today',$today)
									->queryAll();
			
			$count = count($models);
			$num = $num <= $count ?$num : $count;
			if($count > 1){
				shuffle($models);
				$rdKeys = array_rand($models,$num);
				foreach($rdKeys as $key){
					array_push($prizes,$models[$key]);
					$openid .=$models[$key]['openid']."\r\n";
				}
			}else{
				$prizes = $models;
				$openid .=$models[0]['openid']."\r\n";
			}
//			$this->exportExcelFile($prizes);
			$this->exportTxtFile($openid);
			exit;
		}
		$criteria = new CDbCriteria;
		
		$criteria->addCondition('dpid=:dpid and delete_flag=0');
		$criteria->order = 'lid desc';
		$criteria->params[':dpid'] = $this->companyId;
		
		$pages = new CPagination(Screen::model()->count($criteria));
		//	    $pages->setPageSize(1);
		$pages->applyLimit($criteria);
		$models = Screen::model()->findAll($criteria);
		
		$this->render('index',array(
				'models'=>$models,
				'pages'=>$pages,
		));
	}
	
	public function actionCreate(){
		$model = new Screen();
		$model->dpid = $this->companyId ;
		//$model->create_time = time();
		
		if(Yii::app()->request->isPostRequest) {
			$model->attributes = Yii::app()->request->getPost('Screen');
			
            $se=new Sequence("screen");
            $model->lid = $se->nextval();
            $model->create_at = date('Y-m-d H:i:s',time());
            $model->update_at = date('Y-m-d H:i:s',time());
			if($model->save()){
				Yii::app()->user->setFlash('success',yii::t('app','添加成功！'));
				$this->redirect(array('screen/index' , 'companyId' => $this->companyId ));
			}
		}
		$this->render('create' , array(
			'model' => $model ,
		));
	}
	
	public function actionUpdate(){
		$id = Yii::app()->request->getParam('id');
		$model = Screen::model()->find('lid=:screenId and dpid=:dpid' , array(':screenId' => $id,':dpid'=>$this->companyId));
		
		$model->dpid = $this->companyId;
		//Until::isUpdateValid(array($id),$this->companyId,$this);//0,表示企业任何时候都在云端更新。
		if(Yii::app()->request->isPostRequest) {
			$model->attributes = Yii::app()->request->getPost('Screen');
			$model->update_at=date('Y-m-d H:i:s',time());
			if($model->save()){
				Yii::app()->user->setFlash('success',yii::t('app','修改成功！'));
				$this->redirect(array('screen/index' , 'companyId' => $this->companyId ));
			}
		}
		
		$this->render('update' , array(
				'model' => $model ,
		));
	}
	public function actionDelete(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		$ids = Yii::app()->request->getPost('ids');
        //Until::isUpdateValid($ids,$companyId,$this);//0,表示企业任何时候都在云端更新。
		if(!empty($ids)) {
			Yii::app()->db->createCommand('update nb_screen set delete_flag=1 where lid in ('.implode(',' , $ids).') and dpid = :companyId')
			->execute(array( ':companyId' => $this->companyId));
			$this->redirect(array('screen/index' , 'companyId' => $companyId)) ;
		} else {
			Yii::app()->user->setFlash('error' , yii::t('app','请选择要删除的项目'));
			$this->redirect(array('screen/index' , 'companyId' => $companyId)) ;
		}
		
	}
	public function actionDiscuss(){
		$content = Yii::app()->request->getPost('content',null);
		
		$criteria = new CDbCriteria;
		
		$criteria->addCondition('t.dpid=:dpid and delete_flag=0');
		if($content){
			$criteria->addSearchCondition('content',$content);
		}
		$criteria->order = 't.lid desc';
		$criteria->params[':dpid'] = $this->companyId;
		
		$pages = new CPagination(Discuss::model()->with('branduser')->count($criteria));
		//	    $pages->setPageSize(1);
		$pages->applyLimit($criteria);
		$models = Discuss::model()->with('branduser')->findAll($criteria);
		$this->render('discuss',array(
				'models'=>$models,
				'pages'=>$pages,
				'content'=>$content
		));
	}
	
	public function actionDeleteDiscuss(){
		$companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
		if(Yii::app()->request->isPostRequest){
			$ids = Yii::app()->request->getPost('ids');
            //Until::isUpdateValid($ids,$companyId,$this);//0,表示企业任何时候都在云端更新。
			if(!empty($ids)) {
				Yii::app()->db->createCommand('update nb_screen set delete_flag=1 where lid in ('.implode(',' , $ids).') and dpid = :companyId')
					->execute(array( ':companyId' => $this->companyId));
				Yii::app()->user->setFlash('success' , yii::t('app','删除成功'));
				$this->redirect(array('screen/discuss' , 'companyId' => $companyId)) ;
			} else {
				Yii::app()->user->setFlash('error' , yii::t('app','请选择要删除的项目'));
				$this->redirect(array('screen/discuss' , 'companyId' => $companyId)) ;
			}
		}else{
			$id =  Yii::app()->request->getParam('id');
			Yii::app()->db->createCommand('update nb_discuss set delete_flag=1 where lid = '.$id.' and dpid = :companyId')
				->execute(array( ':companyId' => $this->companyId));
			Yii::app()->user->setFlash('success' , yii::t('app','删除成功'));
			$this->redirect(array('screen/discuss' , 'companyId' => $companyId)) ;
		}
	}
	public function actionPrize(){
		$this->renderPartial('prize');
	}
	/**
	 * 生成电视二维码
	 */
	public function actionGenWxQrcode(){
		$id = (int)Yii::app()->request->getParam('id',0);
		
		$model = Screen::model()->find('lid=:lid and dpid=:dpid',array(':dpid'=>$this->companyId,':lid'=>$id));
		$data = array('msg'=>'请求失败！','status'=>false,'qrcode'=>'');

		$wxQrcode = new WxQrcode($this->companyId);
		$qrcode = $wxQrcode->getQrcode(WxQrcode::SITE_QRCODE,$model->lid,strtotime('2050-01-01 00:00:00'));
		
		if($qrcode){
			$model->saveAttributes(array('qrcode'=>$qrcode));
			$data['msg'] = '生成二维码成功！';
			$data['status'] = true;
			$data['qrcode'] = $qrcode;
		}
		Yii::app()->end(json_encode($data));
	}
	private function exportExcelFile($models,$export = 'xml'){
		$attributes = array(
			'card_id'=>'会员卡号',
			'nickname'=>'微信昵称',
			'content'=>'评论内容',
			'create_at'=>'评论时间',
		);
 		$data[1] = array_values($attributes);
 		$fields = array_keys($attributes);
		foreach($models as $model){
			$arr = array();
			foreach($fields as $f){
				if($f == 'card_id'){
					$arr[] = substr($model[$f],5);
				}else{
					$arr[] = $model[$f];
				}
			}
			$data[] = $arr;
		}
 		Until::exportFile($data,$export,$fileName=date('Y_m_d_H_i_s'));
	}
	private function exportTxtFile($models,$export = 'txt'){
		Until::exportFile($models,$export,$fileName='发送中奖文档.txt');
	}
}