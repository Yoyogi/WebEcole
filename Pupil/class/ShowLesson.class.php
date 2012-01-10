<?php

require_once $crud_file;
require_once $manager;

class ShowLesson {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ShowLesson::$instance == NULL) {
            ShowLesson::$instance = new ShowLesson();
        }
        return ShowLesson::$instance;
    }
    
    function ShowLesson() {
        $this->header = array('date_cours' => 'Date', 'duree' => 'Duree', 'descript' => 'Description', 'promo' => 'Promotion', 'matiere' => 'Matiere');
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

                $array[$index] = array();
                $array[$index]['date_cours'] = $lesson->date_cours;
                $array[$index]['duree'] = $lesson->duree;
                $array[$index]['descript'] = $lesson->descript;
                $array[$index]['promotion'] = $promotion->libelle;
                $array[$index]['matiere'] = $matiere->libelle;
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
}

?>
