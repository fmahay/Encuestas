<?php
/*@var this UsuariosController*/ 
/*@var model Usuarios*/ 
?>
<div class="view">
	<center>
		<h3>Mi Perfil</h3>
	</center>
	<b><?php echo CHtml::encode($model->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($model->email); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($model->nombre); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('tipo')); ?>:</b>
	<?php echo CHtml::encode($model->tipo); ?>
	<br />
	
	<b><?php echo CHtml::encode($model->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($model->status == 1 ? 'Activo' : 'Inactivo'); ?>
	<br />
</div>