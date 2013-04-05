<?php
/**
 * @author Francisco Mahay
 * fecha: 25-marzo-2013
 */

class UsuariosController extends SCController
{
	public $layout='//layouts/column2';
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$model_usuario = new Usuarios;
		$model_usuario->scenario = 'create';
		
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model_usuario);
		
		$this->actionCreate($model_usuario);	
		
		$model=new Usuarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuarios']))
			$model->attributes=$_GET['Usuarios'];

		$this->render('index',array(
			'model'=>$model,
			'model_usuario'=>$model_usuario,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	private function actionCreate($model) {
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST['Usuarios']))
		{
			$model->validate();
			$model->attributes=$_POST['Usuarios'];
			
			$model->check_tipo == 1 ? $model->tipo = 'Administrador' : $model->tipo = 'Normal';
			$model->pass_php = md5($model->pass);
			$model->session = $model->generateSalt();
			$model->pass_hash= $model->hashPassword($model->pass, $model->session);
			
			if($model->save())
				$this->redirect('index');
		}
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'profile' page.
	 */
	public function actionUpdate() {
		if(Yii::app()->user->getId() != null && Yii::app()->user->getState("tipo") != null) {
			$email = Yii::app()->user->getId();
			$tipo = Yii::app()->user->getState("tipo");
			
			$model = $this->loadModel($email, $tipo);
			
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
			if(isset($_POST['Usuarios'])) {
				$model->attributes=$_POST['Usuarios'];
				if($model->save())
					$this->redirect(array('profile'));
			}
			
			$this->render('_form', array(
				'model'=>$model,
			));
			
		} else
			throw new CHttpException(404, 'The requested page does not exist.');
	}

	/**
	 * Change status from a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete() {
		if(isset($_POST['val_email']) && isset($_POST['val_tipo'])) {
			$email = $_POST['val_email'];
			$tipo = $_POST['val_tipo'];
				
			$model=$this->loadModel($email, $tipo);
			
			#if(isset($_POST['Usuarios'])) {
				#$model->attributes=$_POST['Usuarios'];
			$status = $model->status == 1 ? 0:1;
			
			$sql = "UPDATE Usuarios SET status=:status WHERE email=:email and tipo=:tipo";  
		    $comando = Yii::app()->db->createCommand($sql);  
		    $comando->bindParam(":status", $status, PDO::PARAM_STR);  
		    $comando->bindParam(":email", $email, PDO::PARAM_STR);  
		    $comando->bindParam(":tipo", $tipo, PDO::PARAM_STR);  
		    $control = $comando->execute();
			
			if($control > 0) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
		}
		
		$this->redirect('index');
			
	}
	
	/**
	 * Displays a particular model.
	 * @param String $email first element of composite primary key
	 * @param Strint $tipo second element of composite primary key
	 */
	public function actionView($email, $tipo) {
		$this->renderPartial('view', array(
			'model'=>$this->loadModel($email, $tipo),
		));
	}
	
	/**
	 * Displays a particular model (user perfil).
	 */
	public function actionProfile() {
		if(Yii::app()->user->getId() != null && Yii::app()->user->getState("tipo") != null) {
			$email = Yii::app()->user->getId();
			$tipo = Yii::app()->user->getState("tipo");
			
			$this->render('profile', array(
				'model'=>$this->loadModel($email, $tipo),
			));	
		} else
			throw new CHttpException(404,'The requested page does not exist.');
		
	}
	
	/**
	 * Change password from a particular model
	 */
	public function actionChangePassword() {
		if(Yii::app()->user->getId() != null && Yii::app()->user->getState("tipo") != null) {
			$email = Yii::app()->user->getId();
			$tipo = Yii::app()->user->getState("tipo");
			
			$model = $this->loadModel($email, $tipo);
			$model->scenario = 'changePassword';
			
			// Uncomment the following line if AJAX validation is needed
			$this->performAjaxValidation($model);
			if(isset($_POST['Usuarios'])) {
				$model->attributes=$_POST['Usuarios'];
				
				$model->pass_php = md5($model->confirm_new_pass);
				$model->pass_hash = $model->hashPassword($model->confirm_new_pass, $model->session);
				if($model->save())
					$this->redirect(array('profile'));
			}
			
			$this->render('change_password', array(
				'model'=>$model,
			));
			
		} else
			throw new CHttpException(404, 'The requested page does not exist.');
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	private function loadModel($email, $tipo) {
		$model=Usuarios::model()->findByPk(array('email'=>$email, 'tipo'=>$tipo));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}