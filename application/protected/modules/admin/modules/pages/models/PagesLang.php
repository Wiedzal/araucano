<?php

/**
 * This is the model class for table "pages_lang".
 *
 * The followings are the available columns in table 'pages_lang':
 * @property integer $id
 * @property string $lang
 * @property integer $page_id
 * @property string $title
 * @property string $header
 * @property string $created_at
 * @property integer $created_by
 * @property string $modified_at
 * @property integer $modified_by
 */
class PagesLang extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages_lang';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang, langs, page_id, title', 'required'),
			array('page_id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('lang', 'length', 'max'=>2),
			array('title, header, header_add, langs, meta_keywords', 'length', 'max'=>255),
			array('reg_title', 'length', 'max'=>25),
            array('meta_description', 'length', 'max'=>1000),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lang, langs, page_id, title, header, header_add, meta_keywords, meta_description, created_at, created_by, modified_at, modified_by', 'safe', 'on'=>'search'),
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
			'lang' => 'Lang',
			'langs' => 'Langs',
			'page_id' => 'Page',
			'reg_title' => 'Текст кнопки',
			'title' => 'Название',
			'header' => 'Заголовок',
			'header_add' => 'Дополнительный заголовок',
            'meta_keywords' => 'Ключевые слова',
			'meta_description' => 'Ключевое описание',
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
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('langs',$this->langs,true);
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('header',$this->header,true);
		$criteria->compare('header_add',$this->header_add,true);
		$criteria->compare('reg_title',$this->reg_title,true);
        $criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
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
	 * @return PagesLang the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
