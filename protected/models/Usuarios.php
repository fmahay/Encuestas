<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property string $email
 * @property string $tipo
 * @property string $nombre
 * @property string $check_tipo
 * @property string $pass
 * @property string $new_pass
 * @property string $confirm_new_pass
 * @property string $pass_php
 * @property string $pass_hash
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Administradores[] $fk_administradores_email
 * @property Administradores[] $fk_administradores_tipo
 * @property DetEncuestas[] $fk_detEncuestas_email
 * @property DetEncuestas[] $fk_detEncuestases_tipo
 * @property Respuestas[] $fk_respuestas_email
 * @property Respuestas[] $fk_respuestas_tipo
 * 
 */
class Usuarios extends CActiveRecord
{
	public $pass;
	public $new_pass;
	public $confirm_new_pass;
	public $check_tipo;
	public $id;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
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
		return 'usuarios';
	}

	/**
	 * Checks if the given password is correct.
	 * @parm string the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($pass) {
		if($this->hashPassword($pass, $this->session) === $this->pass_hash && md5($pass) === $this->pass_php)
			return true;
		return false; 
	}
	
	/**
	 * Generates the password hash
	 * @parm string password
	 * @parm string salt
	 * @return string hash
	 */
	public function hashPassword($password, $salt) {
		return md5($salt.$password);
	}
	
	/**
	 * Generates a salt that can be used to generate a password hash
	 * @return string the salt
	 */
	public function generateSalt() {
		return uniqid('', true);
	}
	
	/**
	 * Find a list of users types.
	 * @return array of users types.
	 */
	public static function getListTipos() {
		return CHtml::listData(Usuarios::model()->findAll(array('select'=>'t.tipo', 'distinct'=>true)),'tipo', 'tipo');
	}
	
	/**
	 * Array of status options.
	 * @return array of status options.
	 */
	public static function getStatus() {
		return $list_status = array('0'=>'Inactivo', '1'=>'Activo');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that will receive user inputs.
		return array(
			array('email, nombre', 'required'),
			array('pass', 'required', 'on'=>'create, changePassword'),
			array('new_pass, confirm_new_pass', 'required', 'on'=>'changePassword'),
			array('confirm_new_pass', 'compare', 'compareAttribute'=>'new_pass', 'on'=>'changePassword', 'message'=>'La nueva contraseña y la confirmación deben de ser exactamente iguales.'),
			array('pass', 'validatorPass', 'on'=>'changePassword'),
			array('check_tipo', 'boolean', 'on'=>'create'),
			array('status', 'numerical', 'integerOnly'=>true, 'on'=>'create'),
			array('email', 'length', 'max'=>150),
			array('email', 'email'),
			array('email', 'unique','attributeName'=>'email','className'=>'usuarios','allowEmpty'=>false, 'message'=>'{value} ya existe, ingrese otro email.'),
			array('tipo', 'length', 'max'=>45, 'on'=>'create'),
			array('nombre', 'length', 'max'=>200),
			array('pass', 'length', 'min'=>8, 'on'=>'create, changePassword'),
			array('new_pass, confirm_new_pass', 'length', 'min'=>8, 'on'=>'changePassword'),
			// The following rule is used by search().
			array('email, tipo, nombre, status', 'safe', 'on'=>'search'),
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
			'fk_administradores_et' => array(self::HAS_ONE, 'Administradores', 'email, tipo'),
			'fk_detEncuestas_email' => array(self::HAS_MANY, 'DetEncuestas', 'fk_usuarios_email, fk_usuarios_tipo'),
			'fk_respuestas_email' => array(self::HAS_MANY, 'Respuestas', 'fk_usuarios_email'),
			'fk_respuestas_tipo' => array(self::HAS_MANY, 'Respuestas', 'fk_usuarios_tipo'),
			'count_encuestas_asignadas' => array(self::STAT, 'DetEncuestas', 'fk_usuarios_email, fk_usuarios_tipo', 'select'=>'COUNT(t.id)'),
		);
	}

	/**
	 * Check if the password especific is equals to actual password
	 */
	public function validatorPass($attribute, $params) {
		if($this->hashPassword($this->$attribute, $this->session) !== Yii::app()->user->getState('pass_hash') && md5($this->$attribute) !== Yii::app()->user->getState('pass_hash'))
			 $this->addError($attribute, 'La contraseña ingresada no coincide con la actual.');
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'tipo' => 'Tipo',
			'check_tipo' => 'Privilegios de Administrador',
			'nombre' => 'Nombre',
			'pass' => 'Contraseña',
			'new_pass' => 'Nueva Contraseña',
			'confirm_new_pass' => 'Confirmar Nueva Contraseña',
			'pass_php' => 'Pass Php',
			'pass_hash' => 'Pass Hash',
			'status' => 'Status',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>5),
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * This is used to assign users into survey.
	 * @param integer id of a survey
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchUsers($id_encuesta) 
	{
		$email = Yii::app()->user->getId();

		$criteria=new CDbCriteria;
		$criteria->condition = "email != '$email' && status=1 && email not in (select fk_usuarios_email from det_encuestas where fk_encuesta=$id_encuesta)";

		$criteria->compare('email',$this->email,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * This is used to show assigned users to a survey.
	 * @param integer id of a survey
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchAssignedUsers($id_encuesta) {
		$criteria=new CDbCriteria;

		$criteria->select = "t.email ,t.tipo, t.nombre, de.status, de.id as id ";
		$criteria->join = "INNER JOIN det_encuestas as de ON t.email = de.fk_usuarios_email && t.tipo = de.fk_usuarios_tipo";
		$criteria->condition = "t.status = 1 && de.fk_encuesta = $id_encuesta";

		$criteria->compare('email',$this->email,true);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('status',DetEncuestas::model()->status,true);
		$criteria->compare("id",DetEncuestas::model()->id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array('pageSize'=>20),
		));
	}
}
