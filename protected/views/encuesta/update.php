<?php
/*@var this EncuestaController*/
/*@var model Encuesta*/

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('index'),
	'Detalle'=>array('view','id'=>$model->id),
	'Editar',
);
?>
<center>
	<h3>Editar Encuesta</h3>
</center>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
