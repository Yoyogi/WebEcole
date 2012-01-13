<?php

require_once $crud_file;
require_once $manager;

class ManageLesson {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManageLesson::$instance == NULL) {
            ManageLesson::$instance = new ManageLesson();
        }
        return ManageLesson::$instance;
    }
    
    function ManageLesson() {
        $this->header = array('id' => 'ID', 'date_cours' => 'Date', 'duree' => 'Durée', 'promo' => 'Promotion', 'matiere' => 'Matière', 'professeur' => 'Enseignant');
    }
    
    public function getLesson() {
        try {
            $crud = Crud::getInstance();
            $lessons = $crud->getLessons();
            $index = 0;

            $array = array();
            foreach ($lessons as $lesson) {  
                $promotion = $crud->getPromotionById($lesson->id_promo);
                $matiere = $crud->getSubjectByLesson($lesson->id_cours);
                $teacher = $crud->getTeacherByLesson($lesson);

                $array[$index] = array();
                $array[$index]['id'] = $lesson->id_cours;
                $array[$index]['date_cours'] = date("d/m/Y", strtotime($lesson->date_cours));
                $array[$index]['duree'] = $lesson->duree;
                $array[$index]['promotion'] = $promotion->libelle;
                $array[$index]['matiere'] = $matiere->libelle;
                $array[$index]['professeur'] = $teacher->nom;
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
    
    public function deleteLesson($id) {
        try {
            $crud = Crud::getInstance();
            $crud->deleteLesson($id);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
