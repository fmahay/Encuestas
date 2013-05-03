<?php
/* @var $this UsuariosController*/
/* @var $model_usuario Usuarios */
/* @var $form CActiveForm */

?>
	
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		<i class="icon-remove"></i>
	</button>
	<h4 align="center">Nuevo Usuario</h4>
</div>
<div class="modal-body">
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

		<?php echo $form->errorSummary($model_usuario); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model_usuario,'email'); ?>
			<?php echo $form->textField($model_usuario,'email',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su email')); ?>
			<?php echo $form->error($model_usuario,'email'); ?>
			
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model_usuario,'check_tipo'); ?>
			<?php echo $form->checkBox($model_usuario,'check_tipo'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model_usuario,'nombre'); ?>
			<?php echo $form->textField($model_usuario,'nombre',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su nombre')); ?>
			<?php echo $form->error($model_usuario,'nombre'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model_usuario,'pass'); ?>
			<?php echo $form->passwordField($model_usuario,'pass',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su contraseña')); ?>
			<?php echo $form->error($model_usuario,'pass'); ?>
		</div>
	</div>
</div>
<div class="modal-footer">
	<center>
		<?php echo CHtml::button('Close', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
		<?php echo CHtml::submitButton('Crear', array('class'=>'btn btn-primary')); ?>
	</center>
	<?php
		$this->endWidget();
	?>
</div>