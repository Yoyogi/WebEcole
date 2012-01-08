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
    
    public function getPromotions() {
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
    
    public function getMatieres() {
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
    
    function addLessonFunc($date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere) {
        $crud = Crud::getInstance();
        $crud->createLesson($date, $duree, $descript, $enseignant, $promotion, $matiere);
    }
    
    function getSubjectByIdFunc($id_matiere){
        $crud = Crud::getInstance();
        $mat = new Matiere();
        $mat = $crud->getSubjectById($id_matiere);
        return $mat;
    }
    
    function getTeacherByIdFunc($id_enseignant){
        $crud = Crud::getInstance();
        $ens = new Enseignant();
        $ens = $crud->getTeacherById($id_enseignant);
        return $ens;
    }
    
    function getPromotionByIdFunc($id_promo){
        $crud = Crud::getInstance();
        $pro = new Promotion();
        $pro = $crud->getPromotionById($id_promo);
        return $pro;
    }
}

?>
