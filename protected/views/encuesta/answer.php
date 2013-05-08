<?php
/* @var $this EncuestaController */
/* @var $model Encuesta */
/* @var $model_det DetEncuesta */

$this->breadcrumbs=array(
	'Encuesta'=>array('index'),
	'Mis Encuestas'=>array('misencuestas'),
);
?>

<h3><?php echo $model->nombre; ?></h3>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'encuesta-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<ol>
		<?php foreach ($model->fk_preguntas as $indice => $pregunta) { ?>
		<li>
			<?php echo $form->labelEx($pregunta,$pregunta->pregunta); ?>
			<?php echo $form->radioButton($pregunta, 'id', array('value'=>$pregunta->opcion1, 'name'=>$pregunta->id,'uncheckValue'=>null, 'checked'=>true)).' '.$pregunta->opcion1; ?>
			<?php echo $form->radioButton($pregunta, 'id', array('value'=>$pregunta->opcion2, 'name'=>$pregunta->id,'uncheckValue'=>null)).' '.$pregunta->opcion2; ?>
			<?php echo $form->radioButton($pregunta, 'id', array('value'=>$pregunta->opcion3, 'name'=>$pregunta->id,'uncheckValue'=>null)).' '.$pregunta->opcion3; ?>
			
			<?php echo $form->hiddenField($pregunta, 'id', array('value'=>$pregunta->id, 'name'=>'pre_'.$indice,'uncheckValue'=>null)); ?>
			<br /><br />
		</li>
	<?php } ?>
	</ol>

	<div class="row">
		<?php echo $form->labelEx($model_det,'comentario (opcional)'); ?>
		<?php echo $form->textArea($model_det,'comentario',  array('rows'=>3, 'cols'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Responder', array('class'=>'btn btn-primary')); ?>
		<?php echo CHtml::button('Cancelar', array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->