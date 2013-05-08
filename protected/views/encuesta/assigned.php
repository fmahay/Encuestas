<?php
/* @var $this EncuestaController */
/* @var $model Usuarios */
/* @var $id Encuesta*/

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('encuesta/index'),
	'Detalle'=>array('view','id'=>$id),
	'Usuarios Asignados'
);

$this->menu=array(
	array('label'=>'Detalle de Encuesta', 'url'=>array('view', 'id'=>$id)),
	array('label'=>'Asignar Usuarios', 'url'=>array('assign', 'id'=>$id)),
);
?>
<center>
	<h3>Usuarios asignados a la encuesta</h3>
</center>

<div id="modal_upd" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			<i class="icon-remove"></i>
		</button>
		<h4 align="center">Eliminar registro</h4>
	</div>
	<div class="modal-body">
		<form id="form_delete" name="form_delete" method="post" action="<? echo Yii::app()->controller->createUrl("unassign")?>">
			<div class="alert alert-error" id="div_alert">
				<strong>Importante!!!</strong> El registro será eliminado y no podrá recuperarlo.
			</div>
			<p>¿Desea <strong>Eliminar</strong> el registro seleccionado ?</p>
			<?php echo CHtml::hiddenField('val_id', null); ?>
	</div>
	<div class="modal-footer">
		<center>
			<?php echo CHtml::submitButton('Eliminar', array('class'=>'btn btn-danger','id'=>'btn_upd_status')); ?>
			<?php echo CHtml::button('Cancelar', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
		</center>
	</div>
		</form>
</div>

<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuarios-assigned-grid',
	'dataProvider'=>$model->searchAssignedUsers($id),
	'enablePagination' => true,
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
			'class'=>'CButtonColumn',
			'header'=>'Acciones',
			'template'=>'{delete}',
			'buttons'=>array(
				'delete'=>array(
					'url'=>'$data->id',
					'visible'=>'$data->status == 0 ? true : false',
					'options'=>array('title'=>'eliminar registro'),
					'click'=>"js:function(){
                        event.preventDefault();
						
						$('#val_id').val($(this).attr('href')); 

						$('#modal_upd').modal({show:true}); 
                    }",
				),
			),
			'htmlOptions'=>array('style'=>'width:300px|important'),
			'headerHtmlOptions'=>array('style'=>'width:300px|important'),
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
?>
