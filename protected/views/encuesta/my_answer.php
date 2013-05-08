<?php
/* @var $this EncuestaController */
/* @var $model Preguntas */
/* @var $modelDet DetEncuestas */


$this->breadcrumbs=array(
	'Mis Encuestas Asignadas'=>array('misencuestas'),
	'Mis Respuestas',
);

?>

<div class="view">
	<center>
		<h3>Encuesta: <?php echo CHtml::encode($modelDet->fk_encuesta_id->nombre); ?></h3>
	</center>
	
	<blockquote>
  		<h4>Detalle</h4>
	</blockquote>
	
	<b><?php echo CHtml::encode($modelDet->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($modelDet->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($modelDet->getAttributeLabel('comentario')); ?>:</b>
	<?php echo CHtml::encode($modelDet->comentario); ?>
	<br /><br />

	<blockquote>
  		<h4>Respuestas</h4>
	</blockquote>
	<div class="accordion" id="accordion2">
	  	<?php foreach ($model as $key => $pregunta) { ?>
		  <div class="accordion-group">
		    <div class="accordion-heading">
		      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="<?php echo '#collapse'.($key+1); ?>">
		        <?php echo ($key+1).'.'; ?>
		        <b><?php echo CHtml::encode($pregunta->getAttributeLabel('pregunta')); ?>:</b>
	        	<?php echo $pregunta->pregunta; ?>
		      </a>
		    </div>
		    <div id="<?php echo 'collapse'.($key+1); ?>" class="accordion-body <?php echo $key === 0 ? 'collapse in' : 'collapse'; ?>">
		      <div class="accordion-inner">
		        <b><?php echo CHtml::encode($pregunta->getAttributeLabel('respuesta')); ?>:</b>
		        <?php echo $pregunta->respuesta; ?>
		      </div>
		    </div>
		  </div>
  	 	<?php } ?>
	</div>

</div>