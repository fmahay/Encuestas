<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id = array();
	private $email;
	
	public function UserIdentity($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */	
	public function authenticate() {
		$user = Usuarios::model()->findByAttributes(array('email'=>strtolower($this->email)));
		if($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id['email'] = $user->email;
			$this->_id['tipo'] = $user->tipo;
			$this->setState('nombre', $user->nombre);
			#Yii::app()->getState('nombre'); // Se accede a la variable nombre
			
			$this->email = $user->email;
			$this->errorCode = self::ERROR_NONE;
		}
		return $this->errorCode == self::ERROR_NONE;
	}
	
	/**
	 * @return integer the ID of the user record
	 */
	 public function getId() {
		return $this->_id;
	 }
}