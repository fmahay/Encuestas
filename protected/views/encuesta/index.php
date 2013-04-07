<?php
/* @var $this EncuestaController */

$this->breadcrumbs=array(
	'Encuesta',
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

$this->menu=array(
	array('label'=>'Crear Encuesta', 'url'=>array('create')),
);
?>
<h1 align="center">Administración de Encuestas Creadas</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<div id="modal_upd_status" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			<i class="icon-remove"></i>
		</button>
		<h4 align="center" id="lb_message" />
	</div>
	<div class="modal-body">
		<form id="form_delete" name="form_delete" method="post" action="<? echo Yii::app()->controller->createUrl("delete")?>">
			<div class="alert alert-error" id="div_alert">
				<strong>Importante!!!</strong> El registro no será eliminado, únicamente se cambiará el status a "Inactivo".
			</div>
			<p>¿Desea <strong id="strong_action"></strong> la cuenta seleccionada ?</p>
			<?php echo CHtml::hiddenField('val_id', null); ?>
	</div>
	<div class="modal-footer">
		<center>
			<?php echo CHtml::submitButton('Eliminar', array('class'=>'btn','id'=>'btn_upd_status')); ?>
			<?php echo CHtml::button('Cancelar', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
		</center>
	</div>
		</form>
</div>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'encuesta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>"function(){
		$.datepicker.setDefaults($.datepicker.regional['es']);
		jQuery('#start_date').datepicker({'dateFormat': 'yy-mm-dd'});
		jQuery('#end_date').datepicker({'dateFormat': 'yy-mm-dd'});
	}", 
	'ajaxUpdate'=>true,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'name'=>'fecha_inicio',
			'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',
							array(
							'model'=>$model,
							'attribute'=>'fecha_inicio',
							'language'=>'es',
							'htmlOptions'=>array(
								'id'=>'start_date'
							),
							'options'=>array(
											'dateFormat'=>'yy-mm-dd',
											'constrainInput'=>'false',
											'duration'=>'fast',
											'showAnim'=>'slideDown',
										),
							),
							true
						),
		),
		array(
			'name'=>'fecha_fin',
			'filter'=>$this->widget('zii.widgets.jui.CJuiDatePicker',
							array(
							'model'=>$model,
							'attribute'=>'fecha_fin',
							'language'=>'es',
							'htmlOptions'=>array(
								'id'=>'end_date'
							),
							'options'=>array(
											'dateFormat'=>'yy-mm-dd',
											'constrainInput'=>'false',
											'duration'=>'fast',
											'showAnim'=>'slideDown',
										),
							),
							true
						),
		),
		array(
			'name'=>'status',
			'value'=>'$data->status == 1 ? "Activo" : "Inactivo"',
			'filter'=>Encuesta::getStatus(),
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Acciones',
			'template'=>'{view} {update} {delete}',
			'buttons'=>array(
				'view'=>array(
					'url'=>'Yii::app()->controller->createUrl("view", array("id"=>$data->id))',
				),
				'update'=>array(
					'url'=>'Yii::app()->controller->createUrl("delete", array("id"=>$data->id))',
					'visible'=>'$data->status == 0 ? true:false',
					'options'=>array('title'=>'Activar registro'),
					'click'=>"js:function(){
                        event.preventDefault();
						$('#lb_message').text('Activar registro');
						$('#div_alert').css('display', 'none'); 
						$('#strong_action').text('Activar');
						
						$('#val_id').val($(this).parent().parent().children(':first-child').text());
						
						if($('#btn_upd_status').hasClass('btn-danger')) {
							$('#btn_upd_status').removeClass('btn-danger');
						}
						$('#btn_upd_status').val('Activar').addClass('btn-primary');
						$('#modal_upd_status').modal({show:true});
                    }",
				),
				'delete'=>array(
					'url'=>'Yii::app()->controller->createUrl("delete", array("id"=>$data->id))',
					'visible'=>'$data->status == 1 ? true:false',
					'options'=>array('title'=>'Inactivar registro'),
					'click'=>"js:function(){
                        event.preventDefault();
						$('#lb_message').text('Inactivar registro');
						$('#div_alert').css('display', '');
						$('#strong_action').text('Inactivar');
						
						$('#val_id').val($(this).parent().parent().children(':first-child').text());
						
						if($('#btn_upd_status').hasClass('btn-primary')){
							$('#btn_upd_status').removeClass('btn-primary');
						}
						$('#btn_upd_status').val('Inactivar').addClass('btn-danger');
						$('#modal_upd_status').modal({show:true});
                    }",
				),
			),
			'htmlOptions'=>array('style'=>'width:300px|important'),
			'headerHtmlOptions'=>array('style'=>'width:300px|important'),
		),
		array(
			'class'=>'CLinkColumn',
			'header'=>'Editar',
			'imageUrl'=>Yii::app()->baseUrl.'/images/writing_file.png',
			'labelExpression'=>'"Editar registro"',
			'urlExpression'=>'Yii::app()->controller->createUrl("update", array("id"=>$data->id))',
			'htmlOptions'=>array('style'=>'text-align:center', 'title'=>'Editar registro'),
		),
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