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
        $crud = Crud::getInstance();
        return $crud->getSubjectById($id_subject);
    }

    public function updateSubject($id, $libelle) {
        $crud = Crud::getInstance();
        $crud->updateSubject($id, $libelle);
    }
}

?>
