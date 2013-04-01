<?php

/**
 * This is the model class for table "encuesta".
 *
 * The followings are the available columns in table 'encuesta':
 * @property integer $id
 * @property string $nombre
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $status
 * @property string $fk_admin_email
 * @property string $fk_admin_tipo
 *
 * The followings are the available model relations:
 * @property DetEncuestas[] $fk_det_encuestas
 * @property Administradores $fk_admin_tpo
 * @property Administradores $fk_admin_email
 * @property Preguntas[] $fk_preguntas
 */
class Encuesta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Encuesta the static model class
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
		return 'encuesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, fecha_inicio, fecha_fin, fk_admin_email, fk_admin_tipo', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('nombre, fk_admin_email', 'length', 'max'=>150),
			array('fk_admin_tipo', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, fecha_inicio, fecha_fin, status, fk_admin_email, fk_admin_tipo', 'safe', 'on'=>'search'),
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
			'fk_det_encuestas' => array(self::BELONGS_TO, 'DetEncuestas', 'fk_encuesta'),
			'fk_admin_tipo' => array(self::BELONGS_TO, 'Administradores', 'fk_admin_tipo'),
			'fk_admin_email' => array(self::BELONGS_TO, 'Administradores', 'fk_admin_email'),
			'fk_preguntas' => array(self::HAS_MANY, 'Preguntas', 'id_encuesta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_fin' => 'Fecha Fin',
			'status' => 'Status',
			'fk_admin_email' => 'Fk Admin Email',
			'fk_admin_tipo' => 'Fk Admin Tipo',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('fk_admin_email',$this->fk_admin_email,true);
		$criteria->compare('fk_admin_tipo',$this->fk_admin_tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}