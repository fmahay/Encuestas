<?php
/* @var $this PreguntasController */
/* @var $model Preguntas */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'preguntas-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'pregunta'); ?>
		<?php echo $form->textField($model,'pregunta', array('class'=>'input-xxlarge')); ?>
		<?php echo $form->error($model,'pregunta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opcion1'); ?>
		<?php echo $form->textField($model,'opcion1'); ?>
		<?php echo $form->error($model,'opcion1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opcion2'); ?>
		<?php echo $form->textField($model,'opcion2'); ?>
		<?php echo $form->error($model,'opcion2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'opcion3'); ?>
		<?php echo $form->textField($model,'opcion3'); ?>
		<?php echo $form->error($model,'opcion3'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->