<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddLesson
 *
 * @author Midgard
 */
require_once $crud_file;
require_once $manager;

class AddLesson {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (AddLesson::$instance == NULL) {
            AddLesson::$instance = new AddLesson();
        }
        return AddLesson::$instance;
    }
    
    public function getTeachers() {
        $crud = Crud::getInstance();
        $teachers = $crud->getTeachers();
        $index = 0;

        $array = array();
        foreach ($teachers as $teacher) {
            
            $array[$index] = array();
            $array[$index]['id_enseignant'] = $teacher->id_enseignant;
            $array[$index]['nom'] = $teacher->nom;
            $array[$index]['prenom'] = $teacher->prenom;
            $array[$index]['rue'] = $teacher->rue;
            $array[$index]['cp'] = $teacher->cp;
            $array[$index]['ville'] = $teacher->ville;
            $array[$index]['email'] = $teacher->email;
            $array[$index]['ulogin'] = $teacher->ulogin;
            $array[$index]['passwd'] = $teacher->passwd;
            $index++;
        }
        
        return $array;
    }
}

?>
