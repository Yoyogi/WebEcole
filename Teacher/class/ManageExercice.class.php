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
        $this->header = array('id_exercice' => 'Identifiant', 'libelle' => 'Libelle', 'cours' => 'Cours');
    }
    
    public function getExercice() {
        try {
            $crud = Crud::getInstance();
            $exercices = $crud->getExercices();
            $index = 0;

            $array = array();
            foreach ($exercices as $exercice) { 
                $cour = $crud->getLessonById($exercice->id_cours);

                $array[$index] = array();
                $array[$index]['id'] = $exercice->id_exercice;
                $array[$index]['libelle'] = $exercice->libelle;
                $array[$index]['libelle'] = $cour->id_cours;
                $index++;
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
