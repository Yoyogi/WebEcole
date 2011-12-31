<?php

require_once $crud_file;

class ManagePeople {
    public static $instance = NULL;
    private $header;
    
    public static $ADMIN = 0;
    public static $TEACHER = 1;
    public static $STUDENT = 2;
    
    public static $DELETE = 0;
    public static $UPDATE = 1;
    
    static public function getInstance() {
        if (ManagePeople::$instance == NULL) {
            ManagePeople::$instance = new ManagePeople();
        }
        return ManagePeople::$instance;
    }
    
    function ManagePeople() {
        $this->header = array('id' => 'Identifiant', 'nom' => 'Nom', 'prenom' => 'Prenom', 'status' => 'Status');
    }
    
    public function getPeople() {
        $crud = Crud::getInstance();
        $students = $crud->getStudents();
        $teachers = $crud->getTeachers();
        $index = 0;

        $array = array();
        foreach ($students as $student) {
            $array[$index] = array();
            $array[$index]['id'] = $student->id_etudiant;
            $array[$index]['nom'] = $student->nom;
            $array[$index]['prenom'] = $student->prenom;
            $array[$index]['status'] = "Student";
            $index++;
        }

        foreach ($teachers as $teacher) {
            $array[$index] = array();
            $array[$index]['id'] = $teacher->id_enseignant;
            $array[$index]['nom'] = $teacher->nom;
            $array[$index]['prenom'] = $teacher->prenom;
            $array[$index]['status'] = "Teacher";
            $index++;
        }
        
        return $array;
    }
    
    public function getHeader() {
        return $this->header;
    }
    
    public function deletePeople($type, $id) {
        $crud = Crud::getInstance();
        
        echo $type;
        if ($type == ManagePeople::$TEACHER) {
            $crud->deleteTeacher($id);
        }
        else if ($type == ManagePeople::$STUDENT) {
            $crud->deleteStudent($id);
        }
    }
    
    public function getStatus($str) {
        if ($str == "Admin") {
            return ManagePeople::$ADMIN;
        }
        else if ($str == "Teacher") {
            return ManagePeople::$TEACHER;
        }
        else {
            return ManagePeople::$STUDENT;
        }
    }
}

?>
