<?php
class StorekeeperController extends BackendController{
    public $roles ;
    public $roles2;
    public $roles3;
    public $roles5;
    public $roles7;
    public $roles8;
    public $roles9;
    public $roles11;
    public $roles13;
    public $roles15;
    public $roles17;
    public function init(){
        $this->roles = array(
            '1' => yii::t('app','超级管理员'),
            '3' => yii::t('app','超级副管理员'),
            '4' => yii::t('app','支付管理'),
            '5' => yii::t('app','总部管理员'),
            '7' => yii::t('app','总部副管理员'),
            '8' => yii::t('app','营销员'),
            '9' => yii::t('app','区域管理员'),
            '11' => yii::t('app','店长'),
            '13' => yii::t('app','副店长'),
            '15' => yii::t('app','组长'),
            '17' => yii::t('app','收银员'),
            '19' => yii::t('app','服务员'),
        );

        //超级管理员的权限
        $this->roles3 = array(
            '5' => yii::t('app','总部管理员'),
        ) ;

        //超级副管理员的权限
        $this->roles5 = array(
            '11' => yii::t('app','仓库管理员'),
            '19' => yii::t('app','服务员'),
        ) ;

        //总部管理员的权限
        $this->roles7 = array(
            '11' => yii::t('app','仓库管理员'),
            '19' => yii::t('app','服务员'),
        ) ;

        //总部副管理员的权限
        $this->roles9 = array(
            '11' => yii::t('app','仓库管理员'),
            '19' => yii::t('app','服务员'),
        ) ;


        //店长的权限
        $this->roles13 = array(
            '19' => yii::t('app','采购员'),
        ) ;

        //组长的权限
        $this->roles = array('' => yii::t('app','-- 请选择 --' )) +$this->roles;
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        if(!$this->companyId && $this->getAction()->getId() != 'upload') {
            Yii::app()->user->setFlash('error' , yii::t('app','请选择公司'));
            $this->redirect(array('company/index'));
        }
        return true;
    }

    public function actionIndex() {
        $companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
        $criteria = new CDbCriteria;

        $criteria->condition = 't.dpid='.$this->companyId.' and t.status=1 and t.delete_flag = 0 and t.role >='.Yii::app()->user->role ;
        $pages = new CPagination(User::model()->count($criteria));
        //$pages->setPageSize(1);
        $pages->applyLimit($criteria);
        $models = User::model()->findAll($criteria);
        //var_dump($models);exit;
        $this->render('index',array(
            'models'=>$models,
            'pages'=>$pages,
            'companyId' => $companyId
        ));
    }

    public function actionCreate() {
        $companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
        $model = new UserForm() ;
        $model->dpid = $companyId ;
        $model->status = 1;
        $model->delete_flag = 0;
        if(Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('UserForm');
            $role = $model->role;
            if($role <=15){
                $username = $model->username;
                $ordusername = User::model()->find('username=:name and delete_flag=0' , array(':name'=>$username));
                if($ordusername){
                    Yii::app()->user->setFlash('error' ,yii::t('app', '该登陆名已存在，请重新取名！！！'));
                    $this->redirect(array('storekeeper/create' , 'companyId' => $companyId));
                }
            }else{
                $username = $model->username;
                $ordusername = User::model()->find('dpid=:dpid and username=:name and delete_flag=0' , array(':dpid'=> $companyId,':name'=>$username));
                if($ordusername){
                    Yii::app()->user->setFlash('error' ,yii::t('app', '该登陆名 已存在，请重新取名！！！'));
                    $this->redirect(array('storekeeper/create' , 'companyId' => $companyId));
                }
            }
            if($model->save()){
                Yii::app()->user->setFlash('success',yii::t('app','添加成功'));
                $this->redirect(array('storekeeper/index' , 'companyId' => $companyId));
            }
        }

        $this->render('create' , array(
            'model' => $model

        ));
    }

    public function actionUpdate() {
        $companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
        $id = Yii::app()->request->getParam('id');

        if(Yii::app()->user->role > User::SHOPKEEPER && Yii::app()->user->userId != $id) {
            Yii::app()->user->setFlash('error' , yii::t('app','你没有权限修改'));
            $this->redirect(array('storekeeper/index' , 'companyId' => $companyId)) ;
        }
        $model = new UserForm();
        $model->find('lid=:id and dpid=:dpid and delete_flag=0 and status =1', array(':id' => $id,':dpid'=>$companyId));

        if(Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('UserForm');
            $pw = Yii::app()->request->getParam('hidden1');
            if($pw){
                $model->password = $pw;
            }
            $model->update_at=date('Y-m-d H:i:s',time());
            //var_dump($model->attributes);exit;
            if($model->save()){
                Yii::app()->user->setFlash('success',yii::t('app','修改成功'));
                $this->redirect(array('storekeeper/index' , 'companyId' => $companyId));
            }
        }
        $this->render('update' , array('model' => $model)) ;
    }

    public function actionDelete(){
        $companyId = Helper::getCompanyId(Yii::app()->request->getParam('companyId'));
        if(Yii::app()->user->role > User::SHOPKEEPER) {
            Yii::app()->user->setFlash('error' , yii::t('app','你没有删除权限'));
            $this->redirect(array('storekeeper/index' , 'companyId' => $companyId));
        }
        $ids = Yii::app()->request->getPost('ids');

        if(!empty($ids)) {
            foreach ($ids as $id) {
                $model = User::model()->find('lid=:id and dpid=:companyId' , array(':id' => $id,':companyId'=>$companyId)) ;
                if($model) {
                    $model->saveAttributes(array('delete_flag'=>1,'status'=>0,'update_at'=>date('Y-m-d H:i:s',time())));
                }
            }
            $this->redirect(array('storekeeper/index' , 'companyId' => $companyId));
        } else {
            Yii::app()->user->setFlash('error' , yii::t('app','请选择要删除的项目'));
            $this->redirect(array('storekeeper/index' , 'companyId' => $companyId));
        }
    }


}