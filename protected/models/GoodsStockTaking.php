<?php

/**
 * This is the model class for table "nb_goods_stock_taking".
 *
 * The followings are the available columns in table 'nb_goods_stock_taking':
 * @property string $lid
 * @property string $dpid
 * @property string $create_at
 * @property string $update_at
 * @property string $goods_order_accountno
 * @property string $invoice_accountno
 * @property integer $goods_id
 * @property string $goods_code
 * @property string $material_code
 * @property string $price
 * @property string $num
 * @property string $status
 * @property string $delete_flag
 * @property string $is_sync
 */
class GoodsStockTaking extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'nb_goods_stock_taking';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lid, dpid, update_at, goods_order_accountno, invoice_accountno, goods_id, goods_code, material_code, price, num', 'required'),
            array('goods_id', 'numerical', 'integerOnly'=>true),
            array('lid, dpid, price, num', 'length', 'max'=>10),
            array('goods_order_accountno, invoice_accountno', 'length', 'max'=>30),
            array('goods_code, material_code', 'length', 'max'=>20),
            array('status, delete_flag', 'length', 'max'=>2),
            array('is_sync', 'length', 'max'=>50),
            array('create_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('lid, dpid, create_at, update_at, goods_order_accountno, invoice_accountno, goods_id, goods_code, material_code, price, num, status, delete_flag, is_sync', 'safe', 'on'=>'search'),
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
            'dpid' => '仓库dpid',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'goods_order_accountno' => '商品订单账单号',
            'invoice_accountno' => '出货单号',
            'goods_id' => '商品id',
            'goods_code' => '商品编码',
            'material_code' => '原料编码',
            'price' => '单价',
            'num' => '损耗数量',
            'status' => '0,未退款，1已退款, 2补发商品',
            'delete_flag' => 'Delete Flag',
            'is_sync' => 'Is Sync',
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
        $criteria->compare('goods_order_accountno',$this->goods_order_accountno,true);
        $criteria->compare('invoice_accountno',$this->invoice_accountno,true);
        $criteria->compare('goods_id',$this->goods_id);
        $criteria->compare('goods_code',$this->goods_code,true);
        $criteria->compare('material_code',$this->material_code,true);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('num',$this->num,true);
        $criteria->compare('status',$this->status,true);
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
     * @return GoodsStockTaking the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}