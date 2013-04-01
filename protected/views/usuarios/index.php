<?php
/* @var $this UsuariosController */
/* @var $model Usuarios */

	$this->breadcrumbs=array(
		'Usuarios',
	);

	Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$.fn.yiiGridView.update('tareas-grid', {
				data: $(this).serialize()
			});
			return false;
		});
	");
?>

<h1 align="center">Administración de usuarios</h1>

<?php echo CHtml::link('Crear Usuario', array('create'), array('id'=>'newUsuario')); ?>

<div id="modal" class="modal hide fade"></div>
<div id="modal_details" class="modal hide fade"></div>
<div id="modal_delete" class="modal hide fade"></div>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'ajaxUpdate'=>true,
	'columns'=>array(
		'email',
		'nombre',
		array(
			'name'=>'tipo',
			'filter'=>Usuarios::getListTipos(),
		),
		array(
			'name'=>'status',
			'value'=>'$data->status == 1 ? "Activo" : "Inactivo"',
			'filter'=>Usuarios::getStatus(),
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Acciones',
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->controller->createUrl("view", array("email"=>$data->email,"tipo"=>$data->tipo))',
					'click'=>'function(){
						event.preventDefault();
						$("#modal_details").load($(this).attr("href"));
						$("#modal_details").modal({show:true});
					}',
				),
				'update'=>array(
					'url'=>'Yii::app()->controller->createUrl("update", array("email"=>$data->email,"tipo"=>$data->tipo))',
				),
				'delete'=>array(
					'url'=>'Yii::app()->controller->createUrl("delete", array("email"=>$data->email,"tipo"=>$data->tipo))',
					'click'=>'function(){
						event.preventDefault();
						//$(location).attr("href",$(this).attr("href")); 
						$("#modal_delete").load($(this).attr("href"));
						$("#modal_delete").modal({show:true});
					}',
				),
			 ),
			'htmlOptions'=>array('style'=>'width:300px|important'),
			'headerHtmlOptions'=>array('style'=>'width:300px|important'),			
		),
	),
	'htmlOptions'=>array(
		'class'=>'table table-hover'
	),
)); ?>

<script>
	$(document).ready(function() {
		$("#newUsuario").click(function() {
			event.preventDefault();	
			$("#modal").load($("#newUsuario").attr("href"));
			$("#modal").modal({show:true});
		});
	});
</script>