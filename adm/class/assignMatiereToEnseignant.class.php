<?php

require_once $crud_file;
require_once $manager;

class AssignMatiereToEnseignant extends Manager {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (AssignMatiereToEnseignant::$instance == NULL) {
            AssignMatiereToEnseignant::$instance = new AssignMatiereToEnseignant();
        }
        return AssignMatiereToEnseignant::$instance;
    }
    
    public function getTeacher() {
        $crud = Crud::getInstance();
        return $crud->getTeachers();
    }
    
    public function getSubject() {
        $crud = Crud::getInstance();
        return $crud->getSubjects();
    }
    
    public function assign($teacher, $subject) {
        $crud = Crud::getInstance();
        $crud->addSubjectToTeacher($crud->getTeacherById($teacher), $crud->$subject);
    }
}

?>

