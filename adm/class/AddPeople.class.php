<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddPeople
 *
 * @author sferrand
 */
require_once $crud_file;

class AddPeople {
    public static $instance = NULL;
    private $crud;

    static public function getInstance() {
        if (AddPeople::$instance == NULL) {
            AddPeople::$instance = new AddPeople();
        }
        return AddPeople::$instance;
    }

    function addPupil($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        try {
            $crud = Crud::getInstance();
            $crud->createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    function addTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd){
        try {
            $crud = Crud::getInstance();
            $crud->createTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function convertStringToDate($string) {
        list($d, $m, $y) = explode('/', $string);
        $mk = mktime(0, 0, 0, $m, $d, $y);
        $result = strftime('%Y-%m-%d',$mk);
        return $result;
    }

}

?>