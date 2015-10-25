<?php

/**
 * This is the model class for table "contents".
 *
 * The followings are the available columns in table 'contents':
 * @property integer $id
 * @property string $alias
 * @property string $title
 * @property string $created_at
 * @property integer $created_by
 * @property string $modified_at
 * @property integer $modified_by
 */
class Contents extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contents';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias', 'required'),
			array('page_id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('alias', 'length', 'max'=>255),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, page_id, alias, created_at, created_by, modified_at, modified_by', 'safe', 'on'=>'search'),
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
            'lang' => array(self::HAS_ONE, 'ContentsLang', 'content_id', 'condition'=>'lang=:lang', 'params'=>array(':lang' => Yii::app()->language)),
            'lang_ru' => array(self::HAS_ONE, 'ContentsLang', 'content_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'ru')),
            'lang_es' => array(self::HAS_ONE, 'ContentsLang', 'content_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'es')),
            'lang_en' => array(self::HAS_ONE, 'ContentsLang', 'content_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'en')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'alias' => 'Alias',
			'page_id' => 'page_id',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'modified_at' => 'Modified At',
			'modified_by' => 'Modified By',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contents the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
