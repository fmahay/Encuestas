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
		$model=new Encuesta('searchMisEncuestas');
		$model->unsetAttributes();
		if(isset($_GET['Encuesta']))
			$model->attributes=$_GET['Encuesta'];

		$this->render('mis_encuestas',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionCreate() {
		$model=new Encuesta;

	    $this->performAjaxValidation($model);
	
	    if(isset($_POST['Encuesta'])) {
	        $model->attributes=$_POST['Encuesta'];
	        
	        $model->fk_admin_email = Yii::app()->user->getId();
	        $model->fk_admin_tipo = Yii::app()->user->getState('tipo');

	        if($model->save()) {
        		$this->redirect(array('view','id'=>$model->id));
	        }
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
		
		if($this->compareDates($model->fecha_fin)) {
			$this->render('message_warning',array(
				'message'=>"No puede editar la encuesta, el tiempo de finalización ($model->fecha_fin) ha concluido.",
			));
		} else {
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
	 * @param integer id primary key
	 */
	public function actionView($id) {
		$model = $this->loadModel($id);
		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$model_preguntas = new Preguntas('search');
			$model_preguntas->unsetAttributes();
			if(isset($_GET['Preguntas']))
				$model_preguntas->attributes=$_GET['Preguntas'];

			$this->render('_view', array(
				'model'=>$model,
				'model_preguntas'=>$model_preguntas,
			));
		}
	}

	/**
	 * Display the user list to assign a survey.
	 * @param integer id primary key
	*/
	public function actionAssign($id) {
		$model = $this->loadModel($id);
		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		
		if($this->compareDates($model->fecha_fin)) {
			$this->render('message_warning',array(
				'message'=>"No puede asignar usuarios a la encuesta, el tiempo de finalización ($model->fecha_fin) ha concluido."
			));
		} else {
			$modelU = new Usuarios('search');
			$modelU->unsetAttributes();
			
			if(isset($_GET['Usuarios']))
				$modelU->attributes=$_GET['Usuarios'];
			
			if(isset($_POST['usuarios-grid_c0'])) {
				foreach ($_POST['usuarios-grid_c0'] as $u) {
					$atts = explode(',', $u);

					$DetEncuestas = new DetEncuestas;
					
					$DetEncuestas->fk_encuesta = $id;
					$DetEncuestas->fk_usuarios_email = $atts[0];
					$DetEncuestas->fk_usuarios_tipo = $atts[1];

					$DetEncuestas->save();
				}

				$this->redirect(array('assigned','id'=>$id));
			}
			$this->render('assign',array(
				'id'=>$id,
				'model'=>$modelU
			));
		}
	}

	/**
	 * Display the user list assigned to a survey.
	 * @param integer id primary key
	*/
	public function actionAssigned($id) {
		$model = $this->loadModel($id);
		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$modelU = new Usuarios('search');
			$modelU->unsetAttributes();
			
			if(isset($_GET['Usuarios']))
				$modelU->attributes=$_GET['Usuarios'];

			$this->render('assigned', array(
				'id'=>$id,
				'model'=>$modelU,
			));
		}
	}

	/**
	 * Remove an user assigned to a survey.
	*/
	public function actionUnassign() {
		if(isset($_POST['val_id'])) {
			$model = $this->loadModelDet($_POST['val_id']);
			$id_encuesta = $model->fk_encuesta;
			
			if($model->fk_encuesta_id->fk_admin_email !== Yii::app()->user->getId())
				throw new CHttpException(404, 'The requested page does not exist.');
			else{
				$model->delete();
				$this->redirect(array('assigned','id'=>$id_encuesta));
			}
		}
	}

	/**
	 * Register the answer of a survey
	 * @param integer id primary key survey
	 */
	public function actionAnswer($id) {
		$model = $this->loadModel($id);
		if(self::compareDates($model->fecha_fin)) {
			$this->render('message_warning',array(
				'message'=>"No puede responder la encuesta, el tiempo de finalización ($model->fecha_fin) ha concluido."
			));
		} else {
			$modelDet = new DetEncuestas;

			$this->performAjaxValidation($modelDet);
			
			if(isset($_POST['yt0'])) {
				$modelDet->attributes=$_POST['DetEncuestas'];

				for ($i=0; $i < $model->count_preguntas(); $i++) {
					$respuesta = $_POST[$_POST["pre_$i"]];
					$email = Yii::app()->user->getId();
					$tipo = Yii::app()->user->getState('tipo');
					$id_pre = $_POST["pre_$i"];

					$sql = "INSERT INTO respuestas (respuesta, fecha, fk_usuarios_email, fk_usuarios_tipo, fk_preguntas, fk_preguntas_encuesta) 
							VALUES('$respuesta', now(), '$email', '$tipo', $id_pre, $model->id);";
		    		$comando = Yii::app()->db->createCommand($sql);  
		    		$comando->execute();
				}
				
				$modelNew = $this->loadModelDetFk($id, Yii::app()->user->getId(), Yii::app()->user->getState('tipo'));
				$modelNew->comentario = $modelDet->comentario;
				$modelNew->fecha = new CDbExpression('NOW()');
				$modelNew->status = 1;
				
				if($modelNew->save())
					$this->redirect(array('misencuestas'));
			}
			
		    $this->render('answer',array(
		    	'model'=>$model,
		    	'model_det'=>$modelDet
	    	));
		}

	}

	/**
	 * Display the answers of a survey
	 * @param integer id primary key survey
	 */
	public function actionMyAnswer($id) {
		$model = $this->loadModelRespuestas($id, Yii::app()->user->getId(), Yii::app()->user->getState('tipo'));
		
		$modelDet = $this->loadModelDetFk($id, Yii::app()->user->getId(), Yii::app()->user->getState('tipo'));

		$this->render('my_answer', array(
			'model'=>$model,
			'modelDet'=>$modelDet,
		));
	}
	
	/**
	 * Display the score of a survey
	 * @param integer id primary key survey
	 */
	public function actionScore($id) {
		$model = $this->loadModel($id);
		if($model->fk_admin_email !== Yii::app()->user->getId())
			throw new CHttpException(404, 'The requested page does not exist.');
		
		if(!$this->compareDates($model->fecha_fin)) {
			$this->render('message_warning',array(
				'message'=>"Aún no puede ver los resultados, el tiempo de finalización ($model->fecha_fin) aun no concluye."
			));

		} else {
			$modelR = $this->loadResultados($id);
			
			$this->render('score', array(
				'model' => $modelR,
				'modelEncuesta' => $model,
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	private function loadModelDet($id) {
		$model = DetEncuestas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer id primary key of a survery
	 * @param String email of a user
	 * @param String tipo of user
	 */
	private function loadModelDetFk($id, $email, $tipo) {
		$criteria = new CDbCriteria;
		$criteria->condition = "fk_encuesta = $id && fk_usuarios_email = '$email' && fk_usuarios_tipo = '$tipo'";

		$model = DetEncuestas::model()->find($criteria);

		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer id primary key of a survery
	 * @param String email of a user
	 * @param String tipo of user
	 */
	private function loadModelRespuestas($id, $email, $tipo) {
		$criteria = new CDbCriteria;
		
		$criteria->select = "t.id_encuesta, t.pregunta, r.respuesta";
		$criteria->join = "inner join respuestas as r on t.id = r.fk_preguntas && t.id_encuesta=r.fk_preguntas_encuesta";
		$criteria->condition = "id_encuesta = $id && fk_usuarios_email = '$email' && fk_usuarios_tipo = '$tipo'";

		$model = Preguntas::model()->findAll($criteria);

		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer id primary key of a survery
	 */
	private function loadModelPreguntas($id) {
		$criteria = new CDbCriteria;
		$criteria->condition = "id_encuesta = $id";

		$model = Preguntas::model()->findAll($criteria);

		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer id primary key of a survery
	 */
	private function loadResultados($id) {
		$model = $this->loadModelPreguntas($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		else {
			$listModel = array();
			
			foreach ($model as $pregunta) {
				$modelRes = new Resultado;
				
				$sql = "SELECT id,id_encuesta,pregunta,opcion1,opcion2,opcion3,
						(SELECT count(respuestas.id) FROM respuestas WHERE respuesta = '$pregunta->opcion1' && fk_preguntas = $pregunta->id) AS res1,
						(SELECT count(respuestas.id) FROM respuestas WHERE respuesta = '$pregunta->opcion2' && fk_preguntas = $pregunta->id) AS res2,
						(SELECT count(respuestas.id) FROM respuestas WHERE respuesta = '$pregunta->opcion3' && fk_preguntas = $pregunta->id) AS res3
						FROM preguntas WHERE id = $pregunta->id && id_encuesta = $pregunta->id_encuesta";
				$res = Yii::app()->db->createCommand($sql)->query();
				
				foreach ($res as $r) {
					$modelRes->id = $r['id'];
					$modelRes->id_encuesta = $r['id_encuesta'];
					$modelRes->pregunta = $r['pregunta'];
					$modelRes->opcion1 = $r['opcion1'];
					$modelRes->opcion2 = $r['opcion2'];
					$modelRes->opcion3 = $r['opcion3'];
					$modelRes->res1 = $r['res1'];
					$modelRes->res2 = $r['res2'];
					$modelRes->res3 = $r['res3'];
				}
				array_push($listModel, $modelRes);
			}

			return $listModel;
		}
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

	public static function compareDates($fecha_fin) {
		date_default_timezone_set("America/Cancun");
		if(version_compare($fecha_fin, date('Y-m-d'), '<'))
			return true;
		else
			return false;
	}
}
