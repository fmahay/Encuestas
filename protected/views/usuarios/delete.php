<?php
/* @var $this UsuariosController*/
/* @var $model Usuarios */
?>	
<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			<i class="icon-remove"></i>
		</button>
		<h4 align="center">Eliminar registro</h4>
	</div>
	<div class="modal-body">
		<div class="view">
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'usuarios-form',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
				'validateOnSubmit'=>true,
				),
			)); 
			echo $form->hiddenField($model,'email',array('type'=>"hidden",'size'=>150,'maxlength'=>255));
			echo $form->hiddenField($model,'tipo',array('type'=>"hidden",'size'=>150,'maxlength'=>255));
			?>	
			<div class="alert alert-error">
				<strong>Importante!!!</strong> El registro no será eliminado, únicamente se cambiará el status a "Inactivo".
			</div>
			<p>¿Desea <strong>Inactivar</strong> la cuenta de <strong><?php echo $model->nombre?></strong> ?</p>
		</div>
	</div>
	<div class="modal-footer">
		<center>
			<?php echo CHtml::submitButton('Eliminar', array('class'=>'btn btn-danger')); ?>
			<?php echo CHtml::button('Cancelar', array('class'=>'btn', 'data-dismiss'=>'modal', 'aria-hidden'=>true)); ?>
		</center>
		<?php $this->endWidget(); ?>
	</div>