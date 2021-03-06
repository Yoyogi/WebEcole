<?php

require_once $crud_file;
require_once $manager;

class AssignEtudiantToPromotion extends Manager {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (AssignEtudiantToPromotion::$instance == NULL) {
            AssignEtudiantToPromotion::$instance = new AssignEtudiantToPromotion();
        }
        return AssignEtudiantToPromotion::$instance;
    }
    
    public function getStudent() {
        try {
            $crud = Crud::getInstance();
            return $crud->getStudents();
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getPromotion() {
        try {
            $crud = Crud::getInstance();
            return $crud->getPromotions();
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function assign($student, $promotion) {
        try {
            $crud = Crud::getInstance();
            $crud->addPromotionToStudent($crud->getStudentById($student), $crud->getPromotionById($promotion));
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
