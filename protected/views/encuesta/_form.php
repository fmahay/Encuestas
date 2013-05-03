<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'encuesta-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre'); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_inicio'); ?>
		<?php 
			$this->widget('zii.widgets.jui.CJuiDatePicker',
						array(
						'model'=>$model,
						'attribute'=>'fecha_inicio',
						'language'=>'es',
						'options'=>array(
										'dateFormat'=>'yy-mm-dd',
										'constrainInput'=>'false',
										'duration'=>'fast',
										'showAnim'=>'slideDown',
										'minDate'=>'new Date()',
										'maxDate'=>'+12m',
									)
						)
			);
		?>
		<?php echo $form->error($model,'fecha_inicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_fin'); ?>
		<?php 
			$this->widget('zii.widgets.jui.CJuiDatePicker',
						array(
						'model'=>$model,
						'attribute'=>'fecha_fin',
						'language'=>'es',
						'options'=>array(
										'dateFormat'=>'yy-mm-dd',
										'constrainInput'=>'false',
										'duration'=>'fast',
										'showAnim'=>'slideDown',
										'minDate'=>'new Date()',
										'maxDate'=>'+12m',
									)
						)
			);
		?>
		<?php echo $form->error($model,'fecha_fin'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
