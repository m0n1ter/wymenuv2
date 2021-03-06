<?php

/**
 * This is the model class for table "nb_point_record".
 *
 * The followings are the available columns in table 'nb_point_record':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $point_type
 * @property string $type_lid
 * @property integer $point_num
 * @property string $brand_user_lid
 * @property string $end_time
 * @property string $delete_flag
 * @property string $is_sync
 */
class PointRecord extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nb_point_record';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('update_at, point_type', 'required'),
			array('point_num', 'numerical', 'integerOnly'=>true),
			array('lid, dpid, type_lid, brand_user_lid', 'length', 'max'=>10),
			array('point_type, delete_flag', 'length', 'max'=>2),
				array('is_sync','length','max'=>50),
			array('create_at, end_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lid, dpid, create_at, update_at, point_type, type_lid, point_num, brand_user_lid, end_time, delete_flag, is_sync', 'safe', 'on'=>'search'),
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
			'point_type' => '0表示消费，1表示充值',
			'type_lid' => '消费就是order的lid，充值就是recharge_record的 lid',
			'point_num' => '积分数额',
			'brand_user_lid' => '会员id',
			'end_time' => '0表示有效，1表示无效',
			'delete_flag' => '0表示存在，1表示删除',
				'is_sync' => yii::t('app','是否同步'),
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
		$criteria->compare('point_type',$this->point_type,true);
		$criteria->compare('type_lid',$this->type_lid,true);
		$criteria->compare('point_num',$this->point_num);
		$criteria->compare('brand_user_lid',$this->brand_user_lid,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('delete_flag',$this->delete_flag,true);
		$criteria->compare('is_sync',$this->is_sync,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PointRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
