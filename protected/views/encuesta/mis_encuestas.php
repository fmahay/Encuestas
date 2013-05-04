<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */

$this->breadcrumbs=array(
	'Mis Encuestas Asignadas',
);

?>
<center>
	<h3>Mis encuestas asignadas</h3>
</center>

<?php 
	$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'misEncuestas-assigned-grid',
	'dataProvider'=>$model->searchMisEncuestas(),
	'enablePagination' => true,
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
			'name'=>'status_det',
			'value'=>'$data->status_det == 0 ? "Pendiente" : "Contestada"',
			'filter'=>DetEncuestas::getStatus(),
		),
		array(
			'class'=>'CButtonColumn',
			'header'=>'Acciones',
			'htmlOptions'=>array('style'=>'width:300px|important'),
			'headerHtmlOptions'=>array('style'=>'width:300px|important'),
			'template'=>'{results}{answer}',
			'buttons'=> array(
			    'results'=>array(
			        'url'=>'Yii::app()->controller->createUrl("myanswer", array("id"=>$data->id,"nombre"=>$data->nombre))',
			        'label'=>'<i class="icon-signal"></i>',
					'options'=>array('title'=>'Ver Mis Respuestas'),
			        'visible'=>'$data->status_det == 0 ? false : true',
			    ),
			    'answer'=>array(
			        'url'=>'Yii::app()->controller->createUrl("answer", array("id"=>$data->id,"nombre"=>$data->nombre))',
			        'label'=>'<i class="icon-ok"></i>',
					'options'=>array('title'=>'Responder Encuesta'),
			        'visible'=>'$data->status_det == 1 ? false : true',
			    ),
		    ),
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
