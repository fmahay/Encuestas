<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */

$this->breadcrumbs=array(
	'Encuesta'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Mis Encuestas Creadas', 'url'=>array('index')),
	array('label'=>'Mis Encuestas Asignadas', 'url'=>array('misencuestas')),
);
?>

<h1>Crear Encuesta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>