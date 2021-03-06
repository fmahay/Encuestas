<?php

/**
 * This is the model class for table "administradores".
 *
 * The followings are the available columns in table 'administradores':
 * @property string $email
 * @property string $tipo
 *
 * The followings are the available model relations:
 * @property Usuarios $fk_email
 * @property Usuarios $fk_tipo
 * @property Encuesta[] $fk_encuestas_mail
 * @property Encuesta[] $fk_encuestas_tipo
 */
class Administradores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Administradores the static model class
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
		return 'administradores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, tipo', 'required'),
			array('email', 'length', 'max'=>150),
			array('tipo', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('email, tipo', 'safe', 'on'=>'search'),
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
			'fk_email' => array(self::HAS_ONE, 'Usuarios', 'email'),
			'fk_tipo' => array(self::HAS_ONE, 'Usuarios', 'tipo'),
			'fk_encuestas_tipo' => array(self::HAS_MANY, 'Encuesta', 'fk_admin_email, fk_admin_tipo'),
			'count_encuestas_creadas' => array(self::STAT, 'Encuesta', 'fk_admin_email, fk_admin_tipo', 'select'=>'COUNT(t.id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'tipo' => 'Tipo',
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

		$criteria->compare('email',$this->email,true);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}