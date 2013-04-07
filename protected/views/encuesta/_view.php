<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */
/* @var $model_pregunta Preguntas */
$this->menu=array(
	array('label'=>'Agregar Pregunta', 'url'=>array('preguntas/create', 'id'=>$model->id)),
);

echo CHtml::link('Agregar pregunta', array('preguntas/create', 'id'=>$model->id));
?>

<div class="view">
	<center>
		<h3>Detalle de la encuesta: <?php echo CHtml::encode($model->nombre); ?></h3>
	</center>
	<b><?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::encode($model->id); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($model->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('fecha_inicio')); ?>:</b>
	<?php echo CHtml::encode($model->fecha_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('fecha_fin')); ?>:</b>
	<?php echo CHtml::encode($model->fecha_fin); ?>
	<br />

	<b><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($model->status == 1 ? 'Activo' : 'Inactivo'); ?>
	<br />
	
	<?php
		foreach ($model->fk_preguntas as $pregunta) {
			echo $pregunta->pregunta.'<br>';
			echo '<ul>';
				echo '<li>'.$pregunta->opcion1.'</li>';
				echo '<li>'.$pregunta->opcion2.'</li>';
				echo '<li>'.$pregunta->opcion3.'</li>';
			echo '</ul>';

		}
	?>
</div>