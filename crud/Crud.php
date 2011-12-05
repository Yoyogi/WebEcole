<?php
require_once $icrud_file;

class Crud implements ICrud {
    var $connection;
    
    function Crud() {
        $connection = Doctrine_Manager::connection(CFG_DB_DSN);
    }
    
    function createStudent() {
        $student = new Student();
        $student->nom = "TIRAND";
        $student->prenom = "Yannick";
        $student->date_naissance = "25/07/1989";
        $student->rue = "9, rue général René";
        $student->cp = 34000;
        $student->ville = "Montpellier";
        $student->email = "ytirand@epsi.fr";
        $student->ulogin = "ytirand";
        $student->passwd = "1234";
        $student->photo = "C:/photo_yt.jpg";
        
        $student->save();
    }
    
    function getStudents() {
        
    }
}

?>
