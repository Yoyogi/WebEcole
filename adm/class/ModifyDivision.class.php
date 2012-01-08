<?php

require_once $crud_file;
require_once $manager;

class ModifyDivision {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (ModifyDivision::$instance == NULL) {
            ModifyDivision::$instance = new ModifyDivision();
        }
        return ModifyDivision::$instance;
    }
    
    public function getDivisionByID($id_division) {
        $crud = Crud::getInstance();
        return $crud->getPromotionById($id_division);
    }

    public function updateDivision($id, $libelle) {
        $crud = Crud::getInstance();
        $crud->updatePromotion($id, $libelle);
    }
}

?>