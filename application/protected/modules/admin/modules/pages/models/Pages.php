<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $img
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $created_at
 * @property integer $created_by
 * @property string $modified_at
 * @property integer $modified_by
 */
class Pages extends ActiveRecord
{
    public $title_ru;
    public $title_es;
    public $title_en;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
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
			array('created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, meta_keywords, meta_description, created_at, created_by, modified_at, modified_by', 'safe', 'on'=>'search'),
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
            'lang' => array(self::HAS_ONE, 'PagesLang', 'page_id', 'condition' => '(langs LIKE :langMatch AND lang.lang=:lang) OR (langs NOT LIKE :langMatch AND lang.lang = "ru")', 'params' => array(':lang' => Yii::app()->language, ':langMatch' => '%|' . Yii::app()->language . '|%')),
            'lang_ru' => array(self::HAS_ONE, 'PagesLang', 'page_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'ru')),
            'lang_es' => array(self::HAS_ONE, 'PagesLang', 'page_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'es')),
            'lang_en' => array(self::HAS_ONE, 'PagesLang', 'page_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'en')),
            'contents' => array(self::HAS_MANY, 'Contents', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'image' => 'image',
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
		$criteria->compare('image',$this->image,true);
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
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function behaviors()
    {
        return array(
            'imageBehavior' => array(
                'class' => 'ImageBehavior',
                'savePathAlias' => 'upload/pages_picture',
                'thumbnailPathAlias' => 'upload/pages_picture/thumbs',
            ),
        );
    }
    
    public function getTitleByLang($lang)
	{
        $pagesLang = PagesLang::model()->find('page_id=:page_id AND lang=:lang', array('page_id'=>$this->id, 'lang'=>$lang));

		if($pagesLang)
        {
            return $pagesLang->title;
        }
        
        return $this->lang->title;
	}
    
    public function getPagesLangModel($lang)
	{
        $pagesLang = PagesLang::model()->find('page_id=:page_id AND lang=:lang', array('page_id'=>$this->id, 'lang'=>$lang));

		if(!$pagesLang)
        {
            $pagesLang = new PagesLang();
            //var_dump($this->lang);die;
            $pagesLang->attributes = $this->lang->attributes;
            $pagesLang->lang = $lang;
            $pagesLang->id = null;
            
            return $pagesLang;
        }
        
        return $pagesLang;
	}
}
