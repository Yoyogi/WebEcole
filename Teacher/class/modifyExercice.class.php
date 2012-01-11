<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $crud_file;
require_once $manager;
require_once $coursclass_file;

class ModifyExercice {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ModifyExercice::$instance == NULL) {
            ModifyExercice::$instance = new ModifyExercice();
        }
        return ModifyExercice::$instance;
    }
    
    public function getLessons() {
        try {
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
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function getExerciceById($id_cours) {
        try {
            $crud = Crud::getInstance();
            return $crud->getExerciceById($id_cours);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function updateExercice($id, $motif, $id_cours) {
        try {
            $crud = Crud::getInstance();
            $cours = $crud->getLessonById($id_cours);
            $crud->updateExercice($id, $motif, $cours);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    
}

?>
