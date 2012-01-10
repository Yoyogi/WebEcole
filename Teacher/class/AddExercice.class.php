<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $crud_file;
require_once $manager;
require_once $coursclass_file;

class AddExercice {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (AddExercice::$instance == NULL) {
            AddExercice::$instance = new AddExercice();
        }
        return AddExercice::$instance;
    }
    
    public function getLessons() {
        $crud = Crud::getInstance();
        $lessons = $crud->getLessons();
        $index = 0;

        $array = array();
        foreach ($lessons as $lesson) {
            
            $array[$index] = array();
            $array[$index]['id_cours'] = $lesson->id_cours;
            $array[$index]['date_cours'] = $lesson->date_cours;
            $array[$index]['duree'] = $lesson->duree;
            $array[$index]['descript'] = $lesson->descript;
            $array[$index]['id_enseignant'] = $lesson->id_enseignant;
            $array[$index]['id_promo'] = $lesson->id_promo;
            $array[$index]['id_matiere'] = $lesson->id_matiere;
            $index++;
        }
        
        return $array;
    }
    
    function getLessonByIdFunc($id_cours){
        $crud = Crud::getInstance();
        $cou = $crud->getLessonById($id_cours);
        return $cou;
    }
    
    function addExerciceFunc($motif, Cours $cours) {
        $crud = Crud::getInstance();
        $crud->createExercice($motif, $cours);
    }
    
    
}

?>
