<?php
/**
 * @author Francisco Mahay
 * fecha: 05-abril-2013
 */
class EncuestaController extends SCController
{
	public $layout='//layouts/column2';
	
	/**
	 * Render the main page
	 */
	public function actionIndex() {
		$model=new Encuesta('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Encuesta']))
			$model->attributes=$_GET['Encuesta'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	/**
	 * List the survey of particular model
	 */
	public function actionMisencuestas() {
		$this->render('mis_encuestas');
	}
	
	/*
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreate() {
		 $model=new Encuesta;

	    $this->performAjaxValidation($model);
	
	    if(isset($_POST['Encuesta']))
	    {
	        $model->attributes=$_POST['Encuesta'];
	        
	        $model->fk_admin_email = Yii::app()->user->getId();
	        $model->fk_admin_tipo = Yii::app()->user->getState('tipo');

	        if($model->save())
	        	$this->redirect('index');
	    }
	    $this->render('create',array('model'=>$model));
	}
	
	/**
	 * Change status from a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete() {
		if(isset($_POST['val_id'])) {
			$id = $_POST['val_id'];
				
			$model=$this->loadModel($id);
			
			$status = $model->status == 1 ? 0:1;
			
			$sql = "UPDATE Encuesta SET status=:status WHERE id=:id";  
		    $comando = Yii::app()->db->createCommand($sql);  
		    $comando->bindParam(":status", $status, PDO::PARAM_STR);  
		    $comando->bindParam(":id", $id, PDO::PARAM_STR);  
		    $control = $comando->execute();
			
			if($control > 0) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
		}
		
		$this->redirect('index');
			
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);

		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$this->performAjaxValidation($model);
			if(isset($_POST['Encuesta'])) {
				$model->attributes=$_POST['Encuesta'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
			$this->render('update',array(
				'model'=>$model,
			));
		}
	}
	/**
	 * Displays a particular model.
	 * @param int id primary key
	 */
	public function actionView($id) {
		$model = $this->loadModel($id);
		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$this->render('_view', array(
				'model'=>$model,
			));	
		}
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	private function loadModel($id) {
		$model=Encuesta::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax']==='encuesta-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}	
}
