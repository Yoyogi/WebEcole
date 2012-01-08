<?php

require_once $crud_file;
require_once $manager;

class ModifyLesson {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (ModifyLesson::$instance == NULL) {
            ModifyLesson::$instance = new ModifyLesson();
        }
        return ModifyLesson::$instance;
    }
    
    public function getLessonByID($id_lesson) {
        $crud = Crud::getInstance();
        return $crud->getLessonById($id_lesson);
    }

    public function updateLesson($id, $date, $duree, $descript, $id_enseignant, $id_promotion, $id_matiere) {
        $crud = Crud::getInstance();
        $enseignant = getTeacherById($id_enseignant);
        $promotion = $crud->getPromotionById($id_promotion);
        $matiere = $crud->getSubjectById($id_matiere);
        
        $crud->updateLesson($id, $date, $duree, $descript, $enseignant, $promotion, $matiere);
    }
}

?>
