<?php

/**
 * This is the model class for table "preguntas".
 *
 * The followings are the available columns in table 'preguntas':
 * @property integer $id
 * @property integer $id_encuesta
 * @property string $pregunta
 * @property string $opcion1
 * @property string $opcion2
 * @property string $opcion3
 *
 * The followings are the available model relations:
 * @property Encuesta $fk_encuesta
 * @property Respuestas[] $fk_respuestas
 * @property Respuestas[] $fk_respuestas_encuesta
 */
class Preguntas extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Preguntas the static model class
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
		return 'preguntas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_encuesta, pregunta, opcion1, opcion2, opcion3', 'required'),
			array('id_encuesta', 'numerical', 'integerOnly'=>true),
			array('pregunta', 'length', 'max'=>250),
			array('opcion1, opcion2, opcion3', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_encuesta, pregunta, opcion1, opcion2, opcion3', 'safe', 'on'=>'search'),
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
			'fk_encuesta' => array(self::BELONGS_TO, 'Encuesta', 'id_encuesta'),
			'fk_respuestas' => array(self::HAS_MANY, 'Respuestas', 'preguntas_id'),
			'fk_respuestas_encuesta' => array(self::HAS_MANY, 'Respuestas', 'preguntas_id_encuesta'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_encuesta' => 'Id Encuesta',
			'pregunta' => 'Pregunta',
			'opcion1' => 'Opcion1',
			'opcion2' => 'Opcion2',
			'opcion3' => 'Opcion3',
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
		$criteria->compare('id_encuesta',$this->id_encuesta);
		$criteria->compare('pregunta',$this->pregunta,true);
		$criteria->compare('opcion1',$this->opcion1,true);
		$criteria->compare('opcion2',$this->opcion2,true);
		$criteria->compare('opcion3',$this->opcion3,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}