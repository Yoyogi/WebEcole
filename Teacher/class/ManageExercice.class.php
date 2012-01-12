<?php

require_once $crud_file;
require_once $manager;

class ManageExercice {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManageExercice::$instance == NULL) {
            ManageExercice::$instance = new ManageExercice();
        }
        return ManageExercice::$instance;
    }
    
    function ManageExercice() {
        $this->header = array('id' => 'ID','libelle' => 'Libelle', 'cours' => 'Cours');
    }
    
    public function getExercice() {
        try {
            $crud = Crud::getInstance();
            $teacher = $crud->getTeacherByLogin($_SESSION["login"]);
            $lessons = $crud->getLessonsByTeacher($teacher->id_enseignant);
            $index = 0;

            $array = array();
            foreach ($lessons as $lesson) {
                $exercices = $crud->getExercicesByLesson($lesson->id_cours);
                foreach ($exercices as $exercice) {
                    $array[$index] = array();
                    $array[$index]['id'] = $exercice->id_exercice;
                    $array[$index]['libelle'] = $exercice->libelle;
                    $array[$index]['descript'] = $lesson->descript;
                    $index++;
                }
            }

            return $array;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getHeader() {
        return $this->header;
    }
    
    public function deleteExercice($id) {
        try {
            $crud = Crud::getInstance();
            $crud->deleteExercice($id);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
