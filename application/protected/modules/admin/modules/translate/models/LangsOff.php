<?php

/**
 * This is the model class for table "langs_off".
 *
 * The followings are the available columns in table 'langs_off':
 * @property integer $id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property integer $is_active
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class LangsOff extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LangsOff the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'langs_off';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_active, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('module, controller, action', 'length', 'max'=>50),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, module, controller, action, is_active, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'module' => 'Module',
			'controller' => 'Controller',
			'action' => 'Action',
			'is_active' => 'Is Active',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'created_ip' => 'Created Ip',
			'modified_at' => 'Modified At',
			'modified_by' => 'Modified By',
			'modified_ip' => 'Modified Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_ip',$this->created_ip,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_ip',$this->modified_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function isPagePostNeeded()
    {
        $module = (string)FALSE;
        $action = (string)FALSE;
        
        $controller = Yii::app()->controller->id;
        
        if (Yii::app()->controller->module != NULL)
        {
            $module = Yii::app()->controller->module->id;
        }
        
        if (Yii::app()->controller->action != NULL)
        {
            $action = Yii::app()->controller->action->id;
        }
        
        $object = self::model()->find('module=:module AND controller=:controller AND action=:action AND is_active=:is_active', array(
            ':module'       => $module,
            ':controller'   => $controller,
            ':action'       => $action,
            ':is_active'    => (int)TRUE
        ));
        
        return ($object != NULL);
    }
}