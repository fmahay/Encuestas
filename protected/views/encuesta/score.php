<?php
/* @var $this EncuestaController */
/* @var $model Resultado */
/* @var $modelEncuesta Encuesta */

$this->breadcrumbs=array(
	'Mis Encuestas Creadas'=>array('encuesta/index'),
	'Resultados',
);
?>
<script type="text/javascript">
	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table,
	// instantiates the pie chart, passes in the data and
	// draws it.
	function drawChart() {
		<?php foreach ($model as $key => $resultado) { ?>
			// Create the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Topping');
			data.addColumn('number', 'Slices');
			
			data.addRows([
				['<?php echo $resultado->opcion1;?>', <?php echo $resultado->res1;?>],
				['<?php echo $resultado->opcion2;?>', <?php echo $resultado->res2;?>],
				['<?php echo $resultado->opcion3;?>', <?php echo $resultado->res3;?>],
			]);

			// Set chart options
			var options = {'title':'<?php echo $resultado->pregunta;?>',
			               'width':400,
			               'height':300,
			               'is3D':true,
			               };

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById("<?php echo 'chart_div'.$key;?>"));
			chart.draw(data, options);
		<?php } ?>
	}
</script>

<center>
		<h3>Resultados de la encuesta: <?php echo CHtml::encode($modelEncuesta->nombre); ?></h3>
</center>

<blockquote>
	<h4>Detalle</h4>
</blockquote>
	
<b><?php echo CHtml::encode($modelEncuesta->getAttributeLabel('fecha_inicio')); ?>:</b>
<?php echo CHtml::encode($modelEncuesta->fecha_inicio); ?>
<br />
<b><?php echo CHtml::encode($modelEncuesta->getAttributeLabel('fecha_fin')); ?>:</b>
<?php echo CHtml::encode($modelEncuesta->fecha_fin); ?>
<br />
<b><?php echo CHtml::encode('Total de Usuarios Asignados'); ?>:</b>
<?php echo CHtml::encode($modelEncuesta->count_asignados); ?>
<br />
<b><?php echo CHtml::encode('Total de Usuarios que han respondido'); ?>:</b>
<?php echo CHtml::encode($modelEncuesta->count_respondidas); ?>
<br />
<b><?php echo CHtml::encode('FALTA GENERAR EL REPORTE'); ?>:</b>
<br /><br />

<blockquote>
	<h4>Resultados</h4>
</blockquote>
<div class="accordion" id="accordion2">
  	<?php foreach ($model as $key => $resultado) { ?>
	  <div class="accordion-group">
	    <div class="accordion-heading">
	      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="<?php echo '#collapse'.($key+1); ?>">
	        <?php echo ($key+1).'.'; ?>
	        <b><?php echo CHtml::encode('Pregunta'); ?>:</b>
        	<?php echo $resultado->pregunta; ?>
	      </a>
	    </div>
	    <div id="<?php echo 'collapse'.($key+1); ?>" class="accordion-body <?php echo $key === 0 ? 'collapse in' : 'collapse'; ?>">
	      <div class="accordion-inner">
	      	<div id="<?php echo 'chart_div'.$key;?>" style="float:left"></div>
			<div id="<?php echo 'table_div'.$key;?>" style="float:right">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<th>Opción</th>
						<th>Total</th>
					</tr>
					<tr>
						<td><?php echo $resultado->opcion1;?></td>
						<td><?php echo $resultado->res1;?></td>
					</tr>
					<tr>
						<td><?php echo $resultado->opcion2;?></td>
						<td><?php echo $resultado->res2;?></td>
					</tr>
					<tr>
						<td><?php echo $resultado->opcion3;?></td>
						<td><?php echo $resultado->res3;?></td>
					</tr>
				</table>
			</div>
	      </div>
	    </div>
	  </div>
 	<?php } ?>
</div>