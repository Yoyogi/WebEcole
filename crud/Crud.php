<?php
require_once $icrud_file;
class Crud implements ICrud {
    var $connection;
    
    function Crud() {
        $dsn = "mysql://root:root@localhost/webecole";
        $connection = Doctrine_Manager::connection($dns);
        echo "connected";
    }
    
    function createStudent() {
        
    }
    
    function getStudents() {
        
    }
}

?>
