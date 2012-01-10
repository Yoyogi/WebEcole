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
        try {
            $crud = Crud::getInstance();
            return $crud->getLessonById($id_lesson);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
public function getTeachers() {
        try {
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
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getPromotions() {
        try {
            $crud = Crud::getInstance();
            $promotions = $crud->getPromotions();
            $index = 0;

            $array = array();
            foreach ($promotions as $promotion) {

                $array[$index] = array();
                $array[$index]['id_promo'] = $promotion->id_promo;
                $array[$index]['libelle'] = $promotion->libelle;
                $index++;
            }

            return $array;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getMatieres() {
        try {
            $crud = Crud::getInstance();
            $matieres = $crud->getSubjects();
            $index = 0;

            $array = array();
            foreach ($matieres as $matiere) {

                $array[$index] = array();
                $array[$index]['id_matiere'] = $matiere->id_matiere;
                $array[$index]['libelle'] = $matiere->libelle;
                $index++;
            }

            return $array;
        }
        catch (Exception $e) {
            throw $e;
        }
    }

    public function updateLesson($id, $date, $duree, $descript, $id_enseignant, $id_promotion, $id_matiere) {
        try {
            $crud = Crud::getInstance();
            $enseignant = $crud->getTeacherById($id_enseignant);
            $promotion = $crud->getPromotionById($id_promotion);
            $matiere = $crud->getSubjectById($id_matiere);

            $crud->updateLesson($id, $date, $duree, $descript, $enseignant, $promotion, $matiere);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
