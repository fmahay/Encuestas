<?php
/* @var $this UsuariosController*/
/* @var $model Usuarios */
?>
	
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		<i class="icon-remove"></i>
	</button>
	<h4 align="center">Datos del Usuario</h4>
</div>
<div class="modal-body">
	<div class="view">
		<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
		<?php echo CHtml::encode($data->email); ?>
		<br />
		
		<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
		<?php echo CHtml::encode($data->nombre); ?>
		<br />
		
		<b><?php echo CHtml::encode($data->getAttributeLabel('tipo')); ?>:</b>
		<?php echo CHtml::encode($data->tipo); ?>
		<br />
		
		<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
		<?php echo CHtml::encode($data->status == 1 ? 'Activo' : 'Inactivo'); ?>
		<br />
		
		<b><?php echo CHtml::encode('Número de encuestas asignadas'); ?>:</b>
		<?php echo CHtml::encode($data->count_encuestas_asignadas); ?>
		<br />
		
		<?php
			if($data->tipo == 'Administrador') {
		?>
			<b><?php echo CHtml::encode('Número de encuestas creadas'); ?>:</b>
			<?php echo CHtml::encode($data->fk_administradores_et->count_encuestas_creadas); ?>
			<br />	
		<?php
			}
		?>
	</div>
</div>
<div class="modal-footer">
	<center>
		<?php echo CHtml::button('Close', array('class'=>'btn btn-primary', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
	</center>
</div>