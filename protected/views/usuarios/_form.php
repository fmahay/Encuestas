<?php
/* @var $this UsuariosController*/
/* @var $model Usuarios */
/* @var $form CActiveForm */
?>
<div class="form">
	<center>
		<h3>Editar Perfil</h3>
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
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su email')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Escriba su nombre')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	<center>
		<?php echo CHtml::submitButton('Guardar', array('class'=>'btn btn-primary')); ?>
	</center>
</div>
<?php $this->endWidget(); ?>