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
 * @property DetEncuestas[] $detEncuestases
 * @property Administradores $fkAdminTipo
 * @property Administradores $fkAdminEmail
 * @property Preguntas[] $preguntases
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

	public static function getStatus() {
		return $list_status= array('0'=>'Inactivo', '1'=>'Activo');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that will receive user inputs.
		return array(
			array('nombre, fecha_inicio, fecha_fin, fk_admin_email, fk_admin_tipo', 'required'),
			array('nombre, fk_admin_email', 'length', 'max'=>150),
           	array('fecha_inicio, fecha_fin', 'date', 'format'=>array('yyyy-MM-dd'), 'allowEmpty'=>false),
           	array('fecha_fin', 'compareDate','compareAttribute'=>'fecha_inicio', 'operator'=>'<', 'format'=>'yyyy-MM-dd', 'message'=> 'La fecha final debe de ser mayor a la fecha de inicio.'),
			#SE DEBE DE CREAR UNA REGLA PARA VERIFICAR QUE LA FECHA_FIN SEA MAYOR A LA DE INICIO Y VICEVERSA
			// The following rule is used by search().
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
			'fk_det_encuesta' => array(self::HAS_MANY, 'DetEncuestas', 'fk_encuesta'),
			'fk_admin' => array(self::BELONGS_TO, 'Administradores', 'fk_admin_email, fk_admin_tipo'),
			'fk_preguntas' => array(self::HAS_MANY, 'Preguntas', 'id_encuesta'),
		);
	}

	/**
	* Comparation between two dates
	*/
	public function compareDate($attribute, $params) {
		if (empty($params['compareAttribute']) || empty($params['operator']))
           $this->addError($attribute, 'Parametros inválidos');

       $compare_date = $this->$params['compareAttribute'];
       $format = (!empty($params['format'])) ? $params['format'] : 'yyyy-MM-dd';
       $operator = (!empty($params['operator'])) ? $params['operator'] : '<';
       $message = (!empty($params['message'])) ? $params['message'] : "$attributes no es $operator que la ".$params['compareAttribute'];

       $start = CDateTimeParser::parse($this->$attribute,$format);
       $end = CDateTimeParser::parse($compare_date,$format);

       if (version_compare($start, $end, $operator))
       		$this->addError($attribute, $message);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID Encuesta',
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

		$email = Yii::app()->user->getId();
		$tipo = Yii::app()->user->getState('tipo');

		$criteria=new CDbCriteria;
		$criteria->condition = "fk_admin_email = '$email' && fk_admin_tipo = '$tipo'";

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_fin',$this->fecha_fin,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}