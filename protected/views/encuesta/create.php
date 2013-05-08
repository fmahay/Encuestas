<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Mis Encuestas Creadas', 'url'=>array('index')),
	array('label'=>'Mis Encuestas Asignadas', 'url'=>array('misencuestas')),
);
?>

<h3>Crear Encuesta</h3>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>