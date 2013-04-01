<?php
/**
 * @author Francisco Mahay
 * fecha: 25-marzo-2013
 */

class UsuariosController extends Controller
{
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Usuarios('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuarios']))
			$model->attributes=$_GET['Usuarios'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
		public function actionCreate() {
		$model = new Usuarios;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST['Usuarios']))
		{
			$model->validate();
			$model->attributes=$_POST['Usuarios'];
			
			$model->check_tipo == 1 ? $model->tipo = 'Administrador' : $model->tipo = 'Normal';
			$model->pass_php = md5($model->pass);
			$model->session = $model->generateSalt();
			$model->pass_hash= $model->hashPassword($_POST['Usuarios']['pass'], $model->session);
			
			if($model->save()) {
				$this->transaction->commit();
				$this->actionIndex();
			}
		}
		$this->renderPartial('create', array('model'=>$model));
	}
	
	/**
	 * Displays a particular model.
	 * @param String $email first element of composite primary key
	 * @param Strint $tipo second element of composite primary key
	 */
	public function actionView($email, $tipo) {
		$this->renderPartial('view', array(
			'data'=>$this->loadModel($email, $tipo),
		));
	}
	
	/**
	 * Change status from a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param String $email fisrt element of composite primary key
	 * @param String $tipo second element of composite primary key
	 */
	public function actionDelete($email, $tipo)
	{				
		$model=$this->loadModel($email, $tipo);
		
		if(isset($_POST['Usuarios'])) {
			#$model->attributes=$_POST['Usuarios'];
			$status = 0;
			$this->transaction = $model->dbConnection->beginTransaction();
			try {
				$sql = "UPDATE Usuarios SET status=:status WHERE email=:email and tipo=:tipo";  
			    $comando = Yii::app()->db->createCommand($sql);  
			    $comando->bindParam(":status", $status, PDO::PARAM_STR);  
			    $comando->bindParam(":email", $email, PDO::PARAM_STR);  
			    $comando->bindParam(":tipo", $tipo, PDO::PARAM_STR);  
			    $control = $comando->execute();
				
				if($control > 0) {
					$this->transaction->commit();
					#$this->actionIndex();
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
				}
			} catch(Exception $e) {
				$this->transaction->rollBack();
			}
		}

		$this->renderPartial('delete',array(
			'model'=>$model,
		));
	}
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($email, $tipo)
	{
		$model=Usuarios::model()->findByPk(array('email'=>$email, 'tipo'=>$tipo));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuarios-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}