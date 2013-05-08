<?php
/* @var $this PreguntasController */
/* @var $model Preguntas */
/* @var $id_encuesta Encuesta */

$this->breadcrumbs=array(
	'Encuesta'=>array('encuesta/index'),
	'Detalle'=>array('encuesta/view','id'=>$id_encuesta),
	'Agregar Pregunta',
);

$this->menu=array(
	array('label'=>'Mis Encuestas Creadas', 'url'=>array('index')),
	array('label'=>'Mis Encuestas Asignadas', 'url'=>array('misencuestas'))
);
?>

<h3>Agregar Pregunta</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>