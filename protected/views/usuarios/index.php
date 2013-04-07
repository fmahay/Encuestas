<?php
/* @var $this UsuariosController */
/* @var $model_usuario Usuarios */
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
			$.fn.yiiGridView.update('usuarios-grid', {
				data: $(this).serialize()
			});
			return false;
		});
	");
	
	$this->menu=array(
		array('label'=>'Crear Usuario', 'url'=>array(''), 'linkOptions'=>array('id'=>'newUsuario')),
	);
?>

<h1 align="center">Administración de usuarios</h1>

<div id="modal" class="modal hide fade">
	<?php echo $this->renderPartial('create', array('model_usuario'=>$model_usuario,)); ?>
</div>


<div id="modal_details" class="modal hide fade"></div>
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
			<?php echo CHtml::hiddenField('val_email', null); ?>
			<?php echo CHtml::hiddenField('val_tipo', null); ?>
	</div>
	<div class="modal-footer">
		<center>
			<?php echo CHtml::submitButton('Eliminar', array('class'=>'btn','id'=>'btn_upd_status')); ?>
			<?php echo CHtml::button('Cancelar', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
		</center>
	</div>
		</form>
</div>

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
					'url'=>'Yii::app()->controller->createUrl("delete", array("email"=>$data->email,"tipo"=>$data->tipo))',
					'visible'=>'$data->status == 0 ? true:false',
					'options'=>array('title'=>'Activar registro'),
					'click'=>"js:function(){
                        event.preventDefault();
						$('#lb_message').text('Activar registro');
						$('#div_alert').css('display', 'none'); 
						$('#strong_action').text('Activar');
						
						$('#val_email').val($(this).parent().parent().children(':first-child').text()); 
						$('#val_tipo').val($(this).parent().parent().children(':nth-child(3)').text());  
						
						if($('#btn_upd_status').hasClass('btn-danger')) {
							$('#btn_upd_status').removeClass('btn-danger');	
						}
						$('#btn_upd_status').val('Activar').addClass('btn-primary');  
						$('#modal_upd_status').modal({show:true}); 
                    }",
				),
				'delete'=>array(
					'url'=>'Yii::app()->controller->createUrl("delete", array("email"=>$data->email,"tipo"=>$data->tipo))',
					'visible'=>'$data->status == 1 ? true:false',
					'options'=>array('title'=>'Inactivar registro'),
					'click'=>"js:function(){
                        event.preventDefault();
						$('#lb_message').text('Inactivar registro');
						$('#div_alert').css('display', ''); 
						$('#strong_action').text('Inactivar');
						
						$('#val_email').val($(this).parent().parent().children(':first-child').text()); 
						$('#val_tipo').val($(this).parent().parent().children(':nth-child(3)').text());
						
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

<script>
	$(document).ready(function() {
		$("#newUsuario").click(function() {
			event.preventDefault();	
			$("#modal").modal({show:true});
		});
	});
</script>