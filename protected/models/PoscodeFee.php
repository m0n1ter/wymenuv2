<?php

/**
 * This is the model class for table "nb_poscode_fee".
 *
 * The followings are the available columns in table 'nb_poscode_fee':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $poscode
 * @property string $exp_time
 * @property integer $num
 * @property string $status
 */
class PoscodeFee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nb_poscode_fee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dpid, poscode', 'required'),
			array('num', 'numerical', 'integerOnly'=>true),
			array('lid, dpid', 'length', 'max'=>10),
			array('poscode', 'length', 'max'=>50),
			array('used_at, exp_time', 'length', 'max'=>255),
			array('status', 'length', 'max'=>25),
			array('create_at, update_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lid, dpid, create_at, update_at, poscode, exp_time, num, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'lid' => 'Lid',
			'dpid' => '店铺id',
			'create_at' => 'Create At',
			'update_at' => '最近一次更新时间',
			'poscode' => '序列号',
			'used_at' => '到期时间',
			'exp_time' => '到期时间',
			'num' => '第几台机器',
			'status' => '0表示状态正常，1表示POS端不可用，2表示线上不可用，3表示都不可用',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('lid',$this->lid,true);
		$criteria->compare('dpid',$this->dpid,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('update_at',$this->update_at,true);
		$criteria->compare('poscode',$this->poscode,true);
		$criteria->compare('used_at',$this->used_at,true);
		$criteria->compare('exp_time',$this->exp_time,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PoscodeFee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getPosfee($dpid,$poscede){
		$sql = 'select * from nb_poscode_fee where dpid='.$dpid.' and poscode="'.$poscede.'"';
		$posfee = Yii::app()->db->createCommand($sql)->queryRow();
		return $posfee;
	}
	public static function getPosfeeset($dpid){
		$sql = 'select * from nb_poscode_feeset where dpid='.$dpid;
		$posfeeset = Yii::app()->db->createCommand($sql)->queryRow();
		return $posfeeset;
	}
	public static function getPosfeeOrder($dpid,$poscode,$tradeno){
		$sql = 'select * from nb_poscode_fee_order where dpid='.$dpid.' and poscode="'.$poscode.'" and trade_no="'.$tradeno.'" and delete_flag=0';
		$posfeeorder = Yii::app()->db->createCommand($sql)->queryRow();
		return $posfeeorder;
	}
	public static function dealPosfeeOrder($posfeeorder,$transactionId){
		$dpid = $posfeeorder['dpid'];
		$poscode = $posfeeorder['poscode'];
		$now = date('Y-m-d H:i:s',time());
		$extTime = $posfeeorder['exp_time'];
		if($extTime < $now){
			$extTime = $now;
		}
		$addtime = $posfeeorder['years'];
		$time = date('Y-m-d H:i:s',strtotime($extTime.' +'.$addtime.' year'));
		
		$sql = 'update nb_poscode_fee_order set transcation_id="'.$transactionId.'",status=1 where lid='.$posfeeorder['lid'].' and dpid='.$dpid;
		Yii::app()->db->createCommand($sql)->execute();
		
		$sql = 'update nb_poscode_fee set exp_time="'.$time.'" where dpid='.$dpid.' and poscode="'.$poscode.'"';
		Yii::app()->db->createCommand($sql)->execute();
		
		$se = new Sequence("poscode_fee_record");
		$id = $se->nextval();
		$data = array(
				'lid'=>$id,
				'dpid'=>$dpid,
				'create_at'=>$now,
				'update_at'=>$now,
				'poscode'=>$poscode,
				'type'=>1,
				'add_time'=>$addtime,
				'expire_time'=>$time
		);
		$result = Yii::app()->db->createCommand()->insert('nb_poscode_fee_record',$data);
	}
}
