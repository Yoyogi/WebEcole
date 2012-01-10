<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddDivision
 *
 * @author Midgard
 */

require_once $crud_file;


class AddDivision {
    //put your code here
    
    public static $instance = NULL;
    private $crud;

    static public function getInstance() {
        if (AddDivision::$instance == NULL) {
            AddDivision::$instance = new AddDivision();
        }
        return AddDivision::$instance;
    }

    
    function addDivisionFunc($libelle){
        try {
            $crud = Crud::getInstance();
            $crud->createPromotion($libelle);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

?>
