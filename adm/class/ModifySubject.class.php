<?php

require_once $crud_file;
require_once $manager;

class ModifySubject {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (ModifySubject::$instance == NULL) {
            ModifySubject::$instance = new ModifySubject();
        }
        return ModifySubject::$instance;
    }
    
    public function getSubjectByID($id_subject) {
        try {
            $crud = Crud::getInstance();
            return $crud->getSubjectById($id_subject);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function updateSubject($id, $libelle) {
        try {
            $crud = Crud::getInstance();
            $crud->updateSubject($id, $libelle);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
