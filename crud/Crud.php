<?php
require_once $icrud_file;
class Crud implements ICrud {
    var $connexion;
    
    function Crud() {
        $dsn = "mysql://root:root@localhost/webecole";
    }
    
    function createStudent() {
        
    }
    
    function getStudents() {
        
    }
}

?>
