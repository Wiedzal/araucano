<?php

define('LANGS_PER_PAGE',    15);

/**
 * This is the model class for table "langs".
 *
 * The followings are the available columns in table 'langs':
 * @property integer $id
 * @property string $alias
 * @property integer $is_default
 * @property integer $is_enabled
 * @property integer $attachment__id_active
 * @property integer $attachment__id_nonactive
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class Langs extends ActiveRecord
{
    const FILE_NAME         = 'languagesAvaible';
    const FILE_DEFAULT_NAME = 'languageDefault';
    const FILE_MODE = 0770;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Langs the static model class
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
		return 'langs';
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
            array('alias', 'match', 'pattern' => '/^[a-z]+$/u', 'message' => Yii::t('app', 'Псевдоним содержит недопустимые символы')),
			array('is_default, is_enabled, attachment__id_active, attachment__id_nonactive, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('alias', 'unique'),
			array('alias', 'length', 'max'=>2, 'min'=>2, 'tooShort'=>Yii::t('app', 'Псевдоним должен содержать 2 символа'), 'tooLong'=>Yii::t('app', 'Псевдоним должен содержать 2 символа')),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, alias, is_default, is_enabled, attachment__id_active, attachment__id_nonactive, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
            'lang'      => array(self::HAS_ONE, 'LangsLang', 'langs__id', 'condition' => 'lang=:lang', 'params' => array(':lang' => Yii::app()->language)),
            'creator'   => array(self::HAS_ONE, 'Users', array('id' => 'created_by'), 'select' => 'username'),
            'redactor'  => array(self::HAS_ONE, 'Users', array('id' => 'modified_by'), 'select' => 'username'),            
		);
        
        
        
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'alias' => Yii::t('app', 'Псевдоним'),
			'is_default' => Yii::t('app', 'Язык по умолчанию ?'),
			'is_enabled' => Yii::t('app', 'Включить ?'),
			'attachment__id_active' => Yii::t('app', 'Флаг выбранного языка'),
            'attachment__id_nonactive' => Yii::t('app', 'Флаг невыбранного языка'),
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('is_default',$this->is_default);
		$criteria->compare('is_enabled',$this->is_enabled);
		$criteria->compare('attachment__id_active',$this->attachment__id_active);
        $criteria->compare('attachment_nonactive',$this->attachment__id_nonactive);
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
    
    public static function fileRegenerate()
    {
        $directory = SETTINGS_EXTERNAL_PATH;
        $path = SETTINGS_EXTERNAL_PATH . DIRECTORY_SEPARATOR . self::FILE_NAME . '.php';       
        
        if (!file_exists($directory))
        {
            if(!mkdir($directory, self::FILE_MODE, true))
            {
                trigger_error('Не удалось создать директорию для хранения списка языков. Проверьте права.', E_USER_ERROR);
            }
            @chmod($directory, self::FILE_MODE);
        }     
    
        $langs      = self::model()->findAll('is_enabled=:is_enabled', array(':is_enabled' => (int)TRUE));
        
        $result     = array();
        
        foreach ($langs as $lang)
        {
            $result[$lang->alias] = $lang->lang->title;
        }
        
        self::fileWrite($path, $result);

        $default   = self::model()->find('is_default=:is_default', array(':is_default' => (int)TRUE));
        
        $path = SETTINGS_EXTERNAL_PATH . DIRECTORY_SEPARATOR . self::FILE_DEFAULT_NAME . '.php';       
        $defaultSettings = Yii::app()->language;

        if (file_exists($path))
        {
            $defaultSettings = include $path;
        }        
        if ($default->alias != $defaultSettings)
        {
            file_put_contents($path, '<?php' . "\n" . 'return "' . $default->alias . '";');
        }
    }    
    
    public static function fileWrite($path, $result)
    {
        $predata = '<?php' . "\n" . 'return array(' . "\n";
        $enddata = ');';
        
        $body = '';
        foreach ($result as $key => $dataset)
        {
            $dataset = str_replace('"', '', $dataset);
            $dataset = str_replace("'", '', $dataset);
            $body .= "\t" . "'" . CHtml::encode($key) . "'" . "\t" . '=>' . "\t" . "'" . CHtml::encode($dataset) . "', " . "\n";
        }
        
        
        file_put_contents($path, $predata . $body . $enddata);
    } 
}