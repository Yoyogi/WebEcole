<?php

require_once($icrud_file);
class Crud implements ICrud {
    
    function Crud() {
        pdoMap::config($pdomap_config);
    }
    
    function createStudent() {
        $student = pdoMap::get("students")->Create();
        $student->name = "toto";
        $student->surname = "titi";
        $student->Insert();
    }
    
    function getStudents() {
        $students = pdoMap::get("students");
        echo $students;
    }
}

?>
