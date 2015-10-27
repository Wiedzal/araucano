<?php

/**
 * This is the model class for table "langs_deleted".
 *
 * The followings are the available columns in table 'langs_deleted':
 * @property integer $id
 * @property integer $lang__id
 * @property string $alias
 * @property integer $is_default
 * @property integer $is_enabled
 * @property integer $is_restored
 * @property integer $attachment__id_active
 * @property integer $attachment__id_nonactive
 * @property string $title
 * @property string $lang__created_at
 * @property integer $lang__created_by
 * @property string $lang__created_ip
 * @property string $lang__modified_at
 * @property integer $lang__modified_by
 * @property string $lang__modified_ip
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class LangsDeleted extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LangsDeleted the static model class
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
		return 'langs_deleted';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lang__id, is_default, is_enabled, is_restored, attachment__id_active, attachment__id_nonactive, lang__created_by, lang__modified_by, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('alias', 'length', 'max'=>2),
			array('title', 'length', 'max'=>50),
			array('lang__created_ip, lang__modified_ip, created_ip, modified_ip', 'length', 'max'=>100),
			array('lang__created_at, lang__modified_at, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lang__id, alias, is_default, is_enabled, is_restored, attachment__id_active, attachment__id_nonactive, title, lang__created_at, lang__created_by, lang__created_ip, lang__modified_at, lang__modified_by, lang__modified_ip, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
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
			'lang__id' => 'Lang',
			'alias' => 'Псевдоним удаленного языка',
			'is_default' => 'Is Default',
			'is_enabled' => 'Is Enabled',
			'is_restored' => 'Is Restored',
			'attachment__id_active' => 'Изображение активного флага',
            'attachment__id_nonactive' => 'Изображение неактивного флага',
			'title' => 'Название удаленного языка',
			'lang__created_at' => 'Lang Created At',
			'lang__created_by' => 'Lang Created By',
			'lang__created_ip' => 'Lang Created Ip',
			'lang__modified_at' => 'Lang Modified At',
			'lang__modified_by' => 'Lang Modified By',
			'lang__modified_ip' => 'Lang Modified Ip',
			'created_at' => 'Дата удаления',
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
		$criteria->compare('lang__id',$this->lang__id);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('is_default',$this->is_default);
		$criteria->compare('is_enabled',$this->is_enabled);
		$criteria->compare('is_restored',$this->is_restored);
		$criteria->compare('attachment__id_active',$this->attachment__id_active);
        $criteria->compare('attachment__id_nonactive',$this->attachment__id_nonactive);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('lang__created_at',$this->lang__created_at,true);
		$criteria->compare('lang__created_by',$this->lang__created_by);
		$criteria->compare('lang__created_ip',$this->lang__created_ip,true);
		$criteria->compare('lang__modified_at',$this->lang__modified_at,true);
		$criteria->compare('lang__modified_by',$this->lang__modified_by);
		$criteria->compare('lang__modified_ip',$this->lang__modified_ip,true);
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
    
    public static function langDelete($langExist)
    {
        $deleteLang                             = new LangsDeleted();
        $deleteLang->lang__id                   = $langExist->id;
        $deleteLang->alias                      = $langExist->alias;
        $deleteLang->is_default                 = $langExist->is_default;
        $deleteLang->is_enabled                 = $langExist->is_enabled;
        $deleteLang->attachment__id_active      = $langExist->attachment__id_active;
        $deleteLang->attachment__id_nonactive   = $langExist->attachment__id_nonactive;
        $deleteLang->title                      = $langExist->lang->title;
        $deleteLang->lang__created_at           = $langExist->created_at;
        $deleteLang->lang__created_by           = $langExist->created_by;
        $deleteLang->lang__created_ip           = $langExist->created_ip;
        $deleteLang->lang__modified_at          = $langExist->modified_at;
        $deleteLang->lang__modified_by          = $langExist->modified_by;
        $deleteLang->lang__modified_ip          = $langExist->modified_ip;
        
        if (!$deleteLang->save())
        {
            Yii::trace('DELETING LANG FATAL ERROR. CODE#1: ' . var_export($deleteLang->getErrors(), TRUE));
            throw new CException(Yii::t('app', 'Ошибка удаления языка'), E_USER_ERROR);            
        }
        
        LangsLang::model()->deleteAll('langs__id=:langs__id', array(':langs__id' => $langExist->id));
        
        if (!$langExist->delete())
        {
            Yii::trace('DELETING LANG FATAL ERROR. CODE#2: ' . var_export($langExist->getErrors(), TRUE));
            throw new CException(Yii::t('app', 'Ошибка удаления языка'), E_USER_ERROR);
        }
        
        return TRUE;
    }
    
    public static function langRestore($id)
    {
        $deleteLang = self::model()->findByPk($id);
        
        if ($deleteLang == NULL)
        {
            Yii::app()->user->setFlash('error', 'Удаленный язык не найден');
            return FALSE;
        }
        
        if ((bool)$deleteLang->is_restored)
        {
            Yii::app()->user->setFlash('error', 'Удаленный язык уже восстановлен');
            return FALSE;
        }
        
        $langExist = Langs::model()->findByPk($deleteLang->lang__id);
        
        if ($langExist != NULL)
        {
            Yii::app()->user->setFlash('error', 'Удаленный язык уже восстановлен');
            return FALSE;
        } 

        $langExist = Langs::model()->find('alias=:alias', array(':alias' => $deleteLang->alias));
        
        if ($langExist != NULL)
        {
            Yii::app()->user->setFlash('error', 'Язык с псевдонимом удаленного языка уже создан');
            return FALSE;
        }
        
        $restoreLang                            = new Langs();
        $restoreLang->id                        = $deleteLang->lang__id;
        $restoreLang->alias                     = $deleteLang->alias;
        $restoreLang->is_default                = $deleteLang->is_default;
        $restoreLang->is_enabled                = $deleteLang->is_enabled;
        $restoreLang->attachment__id_active     = $deleteLang->attachment__id_active;
        $restoreLang->attachment__id_nonactive  = $deleteLang->attachment__id_nonactive;
        
        $restoreLangLang                = new LangsLang();
        $restoreLangLang->lang          = Yii::app()->language;
        $restoreLangLang->langs__id     = $deleteLang->lang__id;
        $restoreLangLang->title         = $deleteLang->title;
        
        $deleteLang->is_restored        = (int)TRUE;
        
        if (!$restoreLang->save())
        {
            Yii::trace('RESTORING LANG FATAL ERROR. CODE#1: ' . var_export($restoreLang->getErrors(), TRUE));
            throw new CException('Ошибка восстановления языка', E_USER_ERROR);
        }
        
        if (!$restoreLangLang->save())
        {
            Yii::trace('RESTORING LANG FATAL ERROR. CODE#2: ' . var_export($restoreLangLang->getErrors(), TRUE));
            throw new CException('Ошибка восстановления языка', E_USER_ERROR);
        }

        if (!$deleteLang->save())
        {
            Yii::trace('RESTORING LANG FATAL ERROR. CODE#2: ' . var_export($deleteLang->getErrors(), TRUE));
            throw new CException('Ошибка восстановления языка', E_USER_ERROR);
        }        

        Yii::app()->user->setFlash('success', 'Язык успешно восстановлен');
        return TRUE;
    }
}