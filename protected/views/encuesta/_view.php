<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */
/* @var $model_preguntas Preguntas */

Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('preguntas-grid', {
				data: $(this).serialize()
			});
			return false;
		});
");

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('encuesta/index'),
	'Detalle',
);

$this->menu=array(
	array('label'=>'Agregar Pregunta', 'url'=>array('preguntas/create', 'id'=>$model->id)),
	array('label'=>'Editar Encuesta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Asignar a Usuarios', 'url'=>array('assign', 'id'=>$model->id,), 'visible'=>$model->count_preguntas === 0 ? false: true),
	array('label'=>'Usuarios Asignados', 'url'=>array('assigned', 'id'=>$model->id), 'visible'=>$model->count_preguntas === 0 ? false: true),
);
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
	<br /><br />
	
	<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'preguntas-grid',
		'dataProvider'=>$model_preguntas->search($model->id),
		'filter'=>$model_preguntas,
		'ajaxUpdate'=>true,
		'columns'=>array(
			'pregunta',
			'opcion1',
			'opcion2',
			'opcion3',
		),
		'htmlOptions'=>array(
			'class'=>'table  table-striped table-hover',
		),
		'pagerCssClass'=>'pagination pagination-centered',
		'pager'=>array(
			'cssFile'=>false,
			'header'=>'',
			'prevPageLabel'  => '«',
		    'nextPageLabel'  => '»',
		    'selectedPageCssClass' => 'active'
		)
	));
	?>
</div>