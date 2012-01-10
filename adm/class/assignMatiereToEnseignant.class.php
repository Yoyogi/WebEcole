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
        try {
            $crud = Crud::getInstance();
            return $crud->getTeachers();
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getSubject() {
        try {
            $crud = Crud::getInstance();
            return $crud->getSubjects();
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function assign($teacher, $subject) {
        try {
            $crud = Crud::getInstance();
            $crud->addSubjectToTeacher($crud->getTeacherById($teacher), $crud->getSubjectById($subject));
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>

