<?php

/**
 * This is the model class for table "navigation".
 *
 * The followings are the available columns in table 'navigation':
 * @property integer $id
 * @property integer $object_id
 * @property string $url
 * @property string $target
 * @property integer $is_visible
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class Navigation extends ActiveRecord
{
	public  $_sort_order_old;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'navigation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id, is_visible, sort_order, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>255),
			array('target', 'length', 'max'=>25),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, object_id, url, target, is_visible, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
            'lang' => array(self::HAS_ONE, 'NavigationLang', 'navigation_id', 'condition' => '(langs LIKE :langMatch AND lang.lang=:lang) OR (langs NOT LIKE :langMatch AND lang.lang = "ru")', 'params' => array(':lang' => Yii::app()->language, ':langMatch' => '%|' . Yii::app()->language . '|%')),
            'lang_ru' => array(self::HAS_ONE, 'NavigationLang', 'navigation_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'ru')),
            'lang_es' => array(self::HAS_ONE, 'NavigationLang', 'navigation_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'es')),
            'lang_en' => array(self::HAS_ONE, 'NavigationLang', 'navigation_id', 'condition'=>'lang=:lang','params'=>array(':lang' => 'en')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'object_id' => 'Object',
			'url' => 'Url',
			'target' => 'Target',
			'sort_order' => 'sort_order',
			'is_visible' => 'Is Visible',
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
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('is_visible',$this->is_visible);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Navigation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function afterFind()
    {
        $this->_sort_order_old = $this->sort_order;
	}	
    
    public function getTitleByLang($lang)
	{
        $navigationLang = NavigationLang::model()->find('navigation_id=:navigation_id AND lang=:lang', array('navigation_id'=>$this->id, 'lang'=>$lang));

		if($navigationLang)
        {
            return $navigationLang->title;
        }
        
        return $this->lang->title;
	}
    
    public function getPossiblePages()
	{
         Yii::import('application.modules.admin.modules.pages.models.*');
         
        $criteria = new CDbCriteria();
        $criteria->order = 'id';
        
        $models = Pages::model()->findAll($criteria);

        return CHtml::listData($models, 'id', 'lang.title');
	}
    
    public function getNavigationLangModel($lang)
	{
        $navigationLang = NavigationLang::model()->find('navigation_id=:navigation_id AND lang=:lang', array('navigation_id'=>$this->id, 'lang'=>$lang));

		if(!$navigationLang)
        {
            $navigationLang = new NavigationLang();
            //var_dump($this->lang);die;
            $navigationLang->attributes = $this->lang->attributes;
            $navigationLang->lang = $lang;
            $navigationLang->id = null;
            
            return $navigationLang;
        }
        
        return $navigationLang;
	}
	
	public function updatePosition($options = array()) {
		$location = array_key_exists('location', $options) ? $options['location'] : null;
        
        if ($this->isNewRecord)
        {
            $this->updateNeighborsPositions('insert');
        }
		elseif (isset($options['delete']) && $options['delete'] === TRUE)
        {
            $this->updateNeighborsPositions('remove');
        }
        else
        {
            $this->updateNeighborsPositions('shift', $location);
        }
	}
	 
	public function updateNeighborsPositions($mode = 'shift', $location = 'top')
    {
		if ($mode == 'shift' && $this->sort_order > $this->_sort_order_old)
        {
            $this->sort_order--;
            $neighbors = $this->model()->findAll(array(
                'condition' => 'sort_order <= :sort_order_new AND sort_order > :sort_order_old AND location = :location',
                'params' => array(
                    ':sort_order_new' => $this->sort_order, 
                    ':sort_order_old' => $this->_sort_order_old,
                    ':location' => $location
                ),
                'order' => 'sort_order',
                )
            );
        }
		elseif ($mode == 'shift' && $this->sort_order < $this->_sort_order_old)
        {
            $neighbors = $this->model()->findAll(array(
                'condition' => 'sort_order >= :sort_order_new AND sort_order < :sort_order_old AND location = :location',
                'params' => array(':sort_order_new' => $this->sort_order, ':sort_order_old' => $this->_sort_order_old,':location' => $location),
                'order' => 'sort_order',
                )
            );
        }
		elseif ($mode == 'insert')
        { 
            $neighbors = $this->model()->findAll(array(
                'condition' => 'sort_order >= :current_sort_order AND location = :location',
                'params' => array(':current_sort_order' => $this->sort_order, ':location' => $location),
                'order' => 'sort_order',
                )
            );
        }
		elseif ($mode == 'remove' && !$this->isNewRecord)
        {
            $neighbors = $this->model()->findAll(array(
                'condition' => 'sort_order > :current_sort_order AND location = :location',
                'params' => array(':current_sort_order' => $this->_sort_order_old, ':location' => $location),
                'order' => 'sort_order',
                )
            );        
        }
		else
        {
            return;
        }
		
		foreach ($neighbors as $neighbor)
        {
            switch ($mode)
            {
                case 'shift':
                    if ($this->sort_order < $this->_sort_order_old)
                    {
                        $neighbor->sort_order++ ;
                    }
                    else
                    {
                        $neighbor->sort_order-- ;
                    }
                    break;
                case 'insert':
                    $neighbor->sort_order ++;
                    break;
                case 'remove':
                    $neighbor->sort_order --;
                    break;
            }
            $neighbor->save();
        }
	}
}
