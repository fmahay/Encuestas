<?php /* @var $this Controller */ ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<?php Yii::app()->clientScript->registerScriptFile('js/jquery.js'); ?>
	<?php echo Yii::app()->bootstrap->register(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <div class="container">
						<?php $this->widget('zii.widgets.CMenu',array(
								'encodeLabel'=>false,
								'items'=>array(
									array('label'=>'<i class="icon-home icon-white"></i><strong>'.CHtml::encode(Yii::app()->name).'</strong>', 'url'=>array('/site/index')),
									array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
									array('label'=>'Contact', 'url'=>array('/site/contact')),
									array('label'=>'<i class="icon-user icon-white"></i> Usuarios', 'url'=>array('/usuarios/index'), 'visible'=>Yii::app()->user->getState('tipo')=='Administrador'),
									array('label'=>'<i class="icon-book icon-white"></i> Encuestas', 'url'=>array(''), 'visible'=>!Yii::app()->user->isGuest, 'items'=>array(
											array('label'=>'<i class="icon-list-alt"></i> Mis Encuestas Creadas', 'url'=>array('/encuesta/index'), 'visible'=>Yii::app()->user->getState('tipo') == 'Administrador'),
											array('label'=>'<i class="icon-pencil"></i> Mis Encuestas Asignadas', 'url'=>array('/encuesta/misencuestas'), 'visible'=>!Yii::app()->user->isGuest),
									), 'itemOptions'=>array('class'=>'dropdown'), 'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'submenuOptions'=>array('class'=>'dropdown-menu')),
									array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
								),
								'htmlOptions'=>array(
									'class'=>'nav',
									'id'=>'nav',
								),
							));
					 		if(!Yii::app()->user->isGuest) {
			 			?>
			 			<div style="float: right; padding-right: 50px">			 				
			 				<div class="btn-group">
		  						<a class="btn btn-primary" href=""><i class="icon-user icon-white"></i> <?php  echo Yii::app()->user->getName();?></a>
		  						<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
		  						<ul class="dropdown-menu">
								    <li><?php echo CHtml::link('<i class="icon-check"></i> Ver Perfil',$this->createUrl('usuarios/profile'));?>
								    <li><?php echo CHtml::link('<i class="icon-edit"></i> Editar Perfil',$this->createUrl('usuarios/update'));?>
								    <li><?php echo CHtml::link('<i class="icon-lock"></i> Cambiar Contraseña',$this->createUrl('usuarios/changePassword'));?>
								    <li class="divider"></li>
								    <li><?php echo CHtml::link('<i class="icon-off"></i> Logout',$this->createUrl('site/logout'));?></li>
							  	</ul>
							</div>
			 			</div>
			 			<?php
					 		}
						?>
                </div>
            </div>
        </div>

<div class="container bg" id="page">
		<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'htmlOptions'=>array(
				'class'=>'breadcrumb'
			)
		)); ?><!-- breadcrumbs -->
		<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
