<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddSubject
 *
 * @author Midgard
 */

require_once $crud_file;


class AddSubject {
    
    public static $instance = NULL;
    private $crud;

    static public function getInstance() {
        if (AddSubject::$instance == NULL) {
            AddSubject::$instance = new AddSubject();
        }
        return AddSubject::$instance;
    }

    function addSubjectFunc($libelle){
        try {
            $crud = Crud::getInstance();
            $crud->createSubject($libelle);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
