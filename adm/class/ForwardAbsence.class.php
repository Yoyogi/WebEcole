<?php

require_once $crud_file;

class ForwardAbsence {
    
    public static $instance = NULL;
    private $crud;

    static public function getInstance() {
        if (ForwardAbsence::$instance == NULL) {
            ForwardAbsence::$instance = new AddDivision();
        }
        return ForwardAbsence::$instance;
    }
    
    function getAbsenceById($id_absence) {
        try {
            $crud = Crud::getInstance();
            $absence = $crud->getAbsenceById($id_absence);
            return $absence;
        }
        catch (Exception $e) {
            throw $e;
        }
        return null;
    }
}

?>
