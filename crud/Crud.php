<?php
require_once $icrud_file;

class Crud implements ICrud {
    var $connection;
    
    function Crud() {
        $connection = Doctrine_Manager::connection(CFG_DB_DSN);
    }
    
    function createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        $student = new Student();
        $student->nom = $nom;
        $student->prenom = $prenom;
        $student->date_naissance = $date_naisse;
        $student->rue = $rue;
        $student->cp = $cp;
        $student->ville = $ville;
        $student->email = $email;
        $student->ulogin = $ulogin;
        $student->passwd = $passwd;
        $student->photo = $photo;
        
        $student->save();
    }
    
    function getStudents() {
        return Doctrine_Core::getTable("Student")->findAll();
    }
}

?>
