<?php // GEN Students AT 2011-12-02 10:55:32
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
}
