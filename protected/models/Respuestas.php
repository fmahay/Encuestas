<?php

/**
 * This is the model class for table "respuestas".
 *
 * The followings are the available columns in table 'respuestas':
 * @property integer $id
 * @property string $respuesta
 * @property string $fecha
 * @property string $fk_usuarios_email
 * @property string $fk_usuarios_tipo
 * @property integer $preguntas_id
 * @property integer $preguntas_id_encuesta
 *
 * The followings are the available model relations:
 * @property Usuarios $fk_usuarios_email
 * @property Usuarios $fk_usuarios_tipo
 * @property Preguntas $fk_preguntas
 * @property Preguntas $fk_preguntas_encuesta
 */
class Respuestas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Respuestas the static model class
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
		return 'respuestas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('respuesta, fecha, fk_usuarios_email, fk_usuarios_tipo, preguntas_id, preguntas_id_encuesta', 'required'),
			array('preguntas_id, preguntas_id_encuesta', 'numerical', 'integerOnly'=>true),
			array('respuesta, fk_usuarios_tipo', 'length', 'max'=>45),
			array('fk_usuarios_email', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, respuesta, fecha, fk_usuarios_email, fk_usuarios_tipo, preguntas_id, preguntas_id_encuesta', 'safe', 'on'=>'search'),
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
			'fk_usuarios_email' => array(self::HAS_ONE, 'Usuarios', 'fk_usuarios_email'),
			'fk_usuarios_tipo' => array(self::HAS_ONE, 'Usuarios', 'fk_usuarios_tipo'),
			'fk_preguntas' => array(self::HAS_ONE, 'Preguntas', 'preguntas_id'),
			'fk_preguntas_encuesta' => array(self::BELONGS_TO, 'Preguntas', 'preguntas_id_encuesta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'respuesta' => 'Respuesta',
			'fecha' => 'Fecha',
			'fk_usuarios_email' => 'Fk Usuarios Email',
			'fk_usuarios_tipo' => 'Fk Usuarios Tipo',
			'preguntas_id' => 'Preguntas',
			'preguntas_id_encuesta' => 'Preguntas Id Encuesta',
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
		$criteria->compare('respuesta',$this->respuesta,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('fk_usuarios_email',$this->fk_usuarios_email,true);
		$criteria->compare('fk_usuarios_tipo',$this->fk_usuarios_tipo,true);
		$criteria->compare('preguntas_id',$this->preguntas_id);
		$criteria->compare('preguntas_id_encuesta',$this->preguntas_id_encuesta);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}