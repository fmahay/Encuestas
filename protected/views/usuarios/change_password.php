<?php
/*@var this UsuariosController*/
/*@var model Usuarios*/
?>

<div class="form">
	<center>
		<h3>Cambiar Contraseña</h3>
	</center>
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
			<?php echo $form->labelEx($model,'pass'); ?>
			<?php echo $form->passwordField($model,'pass',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su contraseña actual')); ?>
			<?php echo $form->error($model,'pass'); ?>
	</div>

	<div class="row">
			<?php echo $form->labelEx($model,'new_pass'); ?>
			<?php echo $form->passwordField($model,'new_pass',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su nueva contraseña ')); ?>
			<?php echo $form->error($model,'new_pass'); ?>
	</div>
	
	<div class="row">
			<?php echo $form->labelEx($model,'confirm_new_pass'); ?>
			<?php echo $form->passwordField($model,'confirm_new_pass',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Confirme su nueva contraseña')); ?>
			<?php echo $form->error($model,'confirm_new_pass'); ?>
	</div>
	<center>
		<?php echo CHtml::submitButton('Guardar', array('class'=>'btn btn-primary')); ?>
	</center>
</div>
<?php $this->endWidget(); ?>