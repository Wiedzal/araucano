<?php

define('TRANSLATES_PER_PAGE',   50);

/**
 * This is the model class for table "translate".
 *
 * The followings are the available columns in table 'translate':
 * @property integer $id
 * @property string $category
 * @property string $text
 * @property string $context
 * @property string $guid
 * @property integer $object_type
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class Translate extends ActiveRecord
{
    const FILE_MODE         = 0770;
    const MESSAGE_FOLDER    = 'messages';
    
    const FILTER_TYPE_ALL               = -1;
    const FILTER_TYPE_TRANSLATED        = 1;
    const FILTER_TYPE_NOT_TRANSLATED    = 2;

    const OBJECT_TYPE_STATIC_PHP        = 1;
    const OBJECT_TYPE_STATIC_JAVASCRIPT = 2;
    const OBJECT_TYPE_HANDLE            = 3;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Translate the static model class
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
		return 'translate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_type, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>1000),
			array('context', 'length', 'max'=>255),
            array('category', 'length', 'max'=>50),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, text, context, guid, object_type, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
            'lang'              => array(self::HAS_ONE, 'TranslateLang', 'translate__id', 'condition' => 'lang=:lang', 'params' => array(':lang' => Yii::app()->language)),
            'translate_lang'    => array(self::HAS_ONE, 'TranslateLang', 'translate__id'),
            'langs'             => array(self::HAS_MANY, 'TranslateLang', 'translate__id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'category' => Yii::t('app', 'Категория'),
			'text' => Yii::t('app', 'Оригинальный текст'),
			'context' => Yii::t('app', 'Контекст'),
			'guid' => 'Guid',
            'object_type' => Yii::t('app', 'Тип транслита'),
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
        $criteria->compare('category',$this->category,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('context',$this->context,true);
		$criteria->compare('guid',$this->guid,true);
        $criteria->compare('object_type',$this->object_type,true);
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
    
    public static function setNewGuid($text, $category, $context)
    {
        $guid = sha1($text . $category . $context);
        
        return $guid;
    }
    
    public static function getFilterArray()
    {
        return array(
            self::FILTER_TYPE_ALL               => Yii::t('app', 'Все записи'),
            self::FILTER_TYPE_TRANSLATED        => Yii::t('app', 'Переведено на язык(и)'),
            self::FILTER_TYPE_NOT_TRANSLATED    => Yii::t('app', 'Не переведено на язык(и)')
        );
    }

    public static function fileRegenerate()
    {
        $categoriesModel = self::model()->findAll(array(
            'select'    => 'category',
            'group'     => 'category'
        ));
    
        $langsModel = Langs::model()->findAll();
    
        foreach ($categoriesModel as $categoryModel)
        {
            foreach ($langsModel as $langModel)
            {
                $directory = Yii::app()->basePath . DIRECTORY_SEPARATOR . self::MESSAGE_FOLDER . DIRECTORY_SEPARATOR . $langModel->alias;
                $path = Yii::app()->basePath . DIRECTORY_SEPARATOR . self::MESSAGE_FOLDER . DIRECTORY_SEPARATOR . $langModel->alias . DIRECTORY_SEPARATOR . $categoryModel->category . '.php';       
                
                if (!file_exists($directory))
                {
                    if(!mkdir($directory, self::FILE_MODE, true))
                    {
                        trigger_error('Не удалось создать директорию для хранения транслита. Проверьте права.', E_USER_ERROR);
                    }
                    @chmod($directory, self::FILE_MODE);
                }                
                
                $translates = self::model()->findAll(array(
                    'condition' => 'category=:category AND (object_type=:object_type_php OR object_type=:object_type_handle)',
                    'params'    => array(':category' => $categoryModel->category, ':object_type_php' => self::OBJECT_TYPE_STATIC_PHP, ':object_type_handle' => self::OBJECT_TYPE_HANDLE),
                    'with'      => array(
                        'lang' => array(
                            'joinType' => 'INNER JOIN',
                            'condition' => 'lang=:lang AND text != ""',
                            'params'    => array(':lang' => $langModel->alias)
                        )
                    )
                ));
                
                $result = array();
                foreach ($translates as $translate)
                {
                    $result[sha1($translate->text . $translate->context)] = str_replace('\'', '\\\'', $translate->lang->translate);
                }
                
                self::fileWrite($path, $result);
            }
        }
    }    
    
    public static function fileWrite($path, $result)
    {
        $predata = '<?php' . "\n" . 'return array(' . "\n";
        $enddata = ');';
        
        $body = '';
        foreach ($result as $key => $dataset)
        {
            $body .= "\t" . "'" . $key . "'" . "\t" . '=>' . "\t" . "'" . $dataset . "', " . "\n";
        }
        
        
        file_put_contents($path, $predata . $body . $enddata);
    }
    
    public static function fileRegenerateJavascript()
    {
        $path = Yii::app()->basePath . '/../js/translate/app_translate.js';
        $directory = Yii::app()->basePath . '/../js/translate';
        
        if (!file_exists($directory))
        {
            if(!mkdir($directory, self::FILE_MODE, true))
            {
                trigger_error('Не удалось создать директорию для хранения транслита. Проверьте права.', E_USER_ERROR);
            }
            @chmod($directory, self::FILE_MODE);
        }                
     
        $langsModel = Langs::model()->findAll();
    
        $result = array();
    
        foreach ($langsModel as $langModel)
        {
            $translatesLang = TranslateLang::model()->findAll(array(
                'condition' => 'lang=:lang AND text != ""',
                'params'    => array(':lang' => $langModel->alias),
                'with'      => array(
                    'translateModel' => array(
                        'joinType' => 'INNER JOIN',
                        'condition' => 'object_type=:object_type_javascript',
                        'params'    => array(':object_type_javascript' => self::OBJECT_TYPE_STATIC_JAVASCRIPT)
                    )
                )                
            ));

            foreach ($translatesLang as $translate)
            {
                $result[$translate->lang . '_' . $translate->translateModel->text] = $translate->translate;
            }
        }
       
        $predata = 'var app_js_translate = new Object;' . "\n";
        
        $body = '';
        foreach ($result as $key => $dataset)
        {
            $body .= "\t" . "app_js_translate['" . $key . "']" . "\t" . '=' . "\t" . "'" . $dataset . "';" . "\n";
        }       
        
        file_put_contents($path, $predata . $body);
    }    
    
    public static function getLangsFromFilter($filter)
    {
        $result = '';
        foreach ($filter as $param => $value)
        {
            if (strpos($param, 'filter-lang-alias-') !== FALSE)
            {
                $result .= '"' . substr($param, 18) . '", ';
            }
        }
        
        return trim($result, ', ');
    }
    
    public static function saveTranslateForJavascript($text)
    {
        $translate      = new Translate();
        $translateLang  = new TranslateLang();
    
        $translate->text        = $text;
        $translate->category    = 'javascript';
        $translate->context     = (string)FALSE;
        $translate->guid        = Translate::setNewGuid($translate->text, $translate->category, $translate->context);
        $translate->object_type = Translate::OBJECT_TYPE_STATIC_JAVASCRIPT;
        
        if (!$translate->save())
        {
            Yii::trace('JAVASCRIPT LANGS COLLECTION ERROR. CODE#1: ' . var_export($translate->getErrors(), TRUE));
        }
        
        $translateLang->translate__id   = $translate->id;
        $translateLang->lang            = Yii::app()->sourceLanguage;
        $translateLang->translate       = $text;
        
        if (!$translateLang->save())
        {
            Yii::trace('JAVASCRIPT LANGS COLLECTION ERROR. CODE#2: ' . var_export($translateLang->getErrors(), TRUE));
        }
        
        Translate::fileRegenerateJavascript();
    }    
}