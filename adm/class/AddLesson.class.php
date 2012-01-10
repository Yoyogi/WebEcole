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
require_once $matiereclass_file;
require_once $promotionclass_file;
require_once $enseignantclass_file;

class AddLesson {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (AddLesson::$instance == NULL) {
            AddLesson::$instance = new AddLesson();
        }
        return AddLesson::$instance;
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
    
    function addLessonFunc($date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
        try {
            $crud = Crud::getInstance();
            $crud->createLesson($date, $duree, $descript, $enseignant, $promotion, $matiere);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function getSubjectByIdFunc($id_matiere){
        try {
            $crud = Crud::getInstance();
            $mat = new Matiere();
            $mat = $crud->getSubjectById($id_matiere);
            return $mat;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function getTeacherByIdFunc($id_enseignant){
        try {
            $crud = Crud::getInstance();
            $ens = new Enseignant();
            $ens = $crud->getTeacherById($id_enseignant);
            return $ens;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function getPromotionByIdFunc($id_promo){
        try {
            $crud = Crud::getInstance();
            $pro = new Promotion();
            $pro = $crud->getPromotionById($id_promo);
            return $pro;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
