<?php
/* @var $this EncuestaController */
/* @var $model Usuarios */
/* @var $id Encuesta*/

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('encuesta/index'),
	'Detalle'=>array('view','id'=>$id),
	'Asignar usuarios'
);

$this->menu=array(
	array('label'=>'Detalle de Encuesta', 'url'=>array('view', 'id'=>$id)),
	array('label'=>'Ver Usuarios Asignados', 'url'=>array('assigned', 'id'=>$id)),
);
?>

<center>
	<h3>Asignar usuarios a la Encuesta</h3>
</center>

<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'asign-form',
));

	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-grid',
	'dataProvider'=>$model->searchUsers($id),
	'enablePagination' => true,
	'filter'=>$model,
	'ajaxUpdate'=>true,
	'columns'=>array(
		array(
			'class'=>'CCheckBoxColumn',
			'selectableRows'=>2,
			'header'=>'Asignar',
		),
		'email',
		'nombre',
		array(
			'name'=>'tipo',
			'filter'=>Usuarios::getListTipos(),
		),
	),
	'htmlOptions'=>array(
		'class'=>'table  table-striped table-hover'
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

echo CHtml::submitButton('Asignar', array('class'=>'btn btn-primary'));
$this->endWidget(); ?>
