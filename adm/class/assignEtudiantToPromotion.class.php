<<?php

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
        $crud = Crud::getInstance();
        return $crud->getStudents();
    }
    
    public function getPromotion() {
        $crud = Crud::getInstance();
        return $crud->getPromotions();
    }
    
    public function assign($student, $promotion) {
        $crud = Crud::getInstance();
        $crud->addPromotionToStudent($student, $promotion);
    }
}

?>
