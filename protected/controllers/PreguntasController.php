<?php
/**
* @author Francisco Mahay
* fecha: 05-abril-2013
*/
class PreguntasController extends SCController
{
	/**
	 * Render the main page
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 * @param integer the id_encuesta primary key of the survey. 
	 */
	public function actionCreate($id) {
		$model_encuesta = Encuesta::model()->findByPK($id);
		if($model_encuesta->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$model = new Preguntas;
			$this->performAjaxValidation($model);
			if(isset($_POST['Preguntas'])) {
				$model->attributes = $_POST['Preguntas'];
				$model->id_encuesta = $id;

				if($model->save())
					$this->redirect(array('encuesta/view','id'=>$model->id_encuesta));
			}

			$this->render('create', array('model'=>$model));
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the id  first element of composite primary key
	 * @param integer the id_encuesta  second element of composite primary key
	 */
	private function loadModel($id, $id_encuesta) {
		$model = Preguntas::model()->findByPK(array('id'=>$id, 'id_encuesta'=>$id_encuesta));
		if($model === null)
			throw new CHttpException(404, 'The request page does not exists.');
		return model;
	}
	/**
	* Performs the AJAX validation.
	* @param CModel the model to be validated
	*/
	public function performAjaxValidation($model) {
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'preguntas-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}