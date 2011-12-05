<?php // GEN Students AT 2011-12-02 12:27:11
interface IStudentsAdapter {
}
class StudentsAdapterImpl
extends pdoMap_Dao_Adapter
implements 
pdoMap_Dao_IAdapter, IStudentsAdapter
{
	public static $adapter = 'students';
	public function __construct() {
		parent::__construct('students');
	}
}
class StudentsEntityImpl extends pdoMap_Dao_Entity  {
	public function __construct($values = null) {
		parent::__construct('students', $values);
	}
	public function InsertStudent($name, $surname, $birthday, $adress, $zipCode, $city, $mail, $login, $passwd, $photo) {
		$this = $this->getAdapter()->Create();
		$this->__set('name', $name);
		$this->__set('surname', $surname);
		$this->__set('birthday', $birthday);
		$this->__set('adress', $adress);
		$this->__set('zipCode', $zipCode);
		$this->__set('city', $city);
		$this->__set('mail', $mail);
		$this->__set('login', $login);
		$this->__set('passwd', md5($passwd));
		$this->__set('photo', $photo);
		return $this->Insert();
	}
}
