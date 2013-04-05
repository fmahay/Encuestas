<?php
/**
 * @author Francisco Mahay
 * fecha: 25-marzo-2013
 */

class SCController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'view', 'create', 'delete'),
				'expression'=>'!$user->isGuest && $user->getState("tipo") == "Administrador"',
			),
			array('allow',
				'actions'=>array('profile', 'update', 'changePassword','misencuestas'),
				'expression'=>'!$user->isGuest',
			),
			array('deny'),
		);
	}
}