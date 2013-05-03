<?php

/**
 * This is the model class for table "det_encuestas".
 *
 * The followings are the available columns in table 'det_encuestas':
 * @property integer $id
 * @property string $comentario
 * @property string $fecha
 * @property integer $status
 * @property integer $fk_encuesta
 * @property string $fk_usuarios_email
 * @property string $fk_usuarios_tipo
 *
 * The followings are the available model relations:
 * @property Encuesta $fk_encuesta
 * @property Usuarios $fk_usuarios_email
 * @property Usuarios $fk_usuarios_tipo
 */
class DetEncuestas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DetEncuestas the static model class
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
		return 'det_encuestas';
	}

	public static function getStatus() {
		return $list_status= array('0'=>'Pendiente', '1'=>'Contestada');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fk_encuesta, fk_usuarios_email, fk_usuarios_tipo', 'required'),
			array('status, fk_encuesta', 'numerical', 'integerOnly'=>true),
			array('fk_usuarios_email', 'length', 'max'=>150),
			array('fk_usuarios_tipo', 'length', 'max'=>45),
			array('comentario, fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, comentario, fecha, status, fk_encuesta, fk_usuarios_email, fk_usuarios_tipo', 'safe', 'on'=>'search'),
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
			'fk_encuesta_id' => array(self::BELONGS_TO, 'Encuesta', 'fk_encuesta'),
			'fk_usuarios_email' => array(self::BELONGS_TO, 'Usuarios', 'fk_usuarios_email, fk_usuarios_tipo'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comentario' => 'Comentario',
			'fecha' => 'Fecha respondida',
			'status' => 'Status',
			'fk_encuesta' => 'Fk Encuesta',
			'fk_usuarios_email' => 'Fk Usuarios Email',
			'fk_usuarios_tipo' => 'Fk Usuarios Tipo',
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
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('fk_encuesta',$this->fk_encuesta);
		$criteria->compare('fk_usuarios_email',$this->fk_usuarios_email,true);
		$criteria->compare('fk_usuarios_tipo',$this->fk_usuarios_tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}