<?php
/* @var $this UsuariosController*/
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>
<h4 align="center">Nuevo Usuario</h4>
<div class="form">
	<?php
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'usuarios-form',
			'enableAjaxValidation'=>true,
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		));
	?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su email')); ?>
		<?php echo $form->error($model,'email'); ?>
		
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'check_tipo'); ?>
		<?php echo $form->checkBox($model,'check_tipo'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su nombre')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su contraseña')); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>
</div>
<center>
	<?php echo CHtml::button('Close', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
</center>
<?php $this->endWidget(); ?>