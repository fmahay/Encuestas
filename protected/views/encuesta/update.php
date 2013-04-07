<?php
/*@var this EncuestaController*/
/*@var model Encuesta*/

$this->breadcrumbs=array(
	'Encuesta'=>array('index'),
	$model->id=>array('_view','id'=>$model->id),
	'Update',
);
?>
<center>
	<h3>Editar Encuesta</h3>
</center>

<?php date_default_timezone_set("America/Cancun");
	if(version_compare($model->fecha_fin, date('Y-m-d'), '<')) {
?>
	<div class="alert alert-error">
		<p>La Encuesta no puede ser editada, el tiempo de finalización (<?php echo $model->fecha_fin; ?>) ha concluido.</p>
	</div>	
<?php } else {	?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php	
}
?>