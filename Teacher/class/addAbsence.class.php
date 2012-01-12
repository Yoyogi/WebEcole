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
require_once $coursclass_file;
require_once $etudiantclass_file;

class AddAbsence {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (AddAbsence::$instance == NULL) {
            AddAbsence::$instance = new AddAbsence();
        }
        return AddAbsence::$instance;
    }
    
    public function getPupils() {
        $crud = Crud::getInstance();
        $pupils = $crud->getStudents();
        $index = 0;

        $array = array();
        foreach ($pupils as $pupil) {
            
            $array[$index] = array();
            $array[$index]['id_etudiant'] = $pupil->id_etudiant;
            $array[$index]['nom'] = $pupil->nom;
            $array[$index]['prenom'] = $pupil->prenom;
            $array[$index]['date_naissance'] = $pupil->date_naissance;
            $array[$index]['rue'] = $pupil->rue;
            $array[$index]['cp'] = $pupil->cp;
            $array[$index]['ville'] = $pupil->ville;
            $array[$index]['email'] = $pupil->email;
            $array[$index]['ulogin'] = $pupil->ulogin;
            $array[$index]['passwd'] = $pupil->passwd;
            $array[$index]['photo'] = $pupil->photo;
            $index++;
        }
        
        return $array;
    }
    
    public function getLessons() {
        $crud = Crud::getInstance();
        $lessons = $crud->getLessons();
        $index = 0;

        $array = array();
        foreach ($lessons as $lesson) {
            $matiere = $crud->getSubjectById($lesson->id_matiere);
            
            $array[$index] = array();
            $array[$index]['id_cours'] = $lesson->id_cours;
            $array[$index]['date_cours'] = $lesson->date_cours;
            $array[$index]['duree'] = $lesson->duree;
            $array[$index]['descript'] = $lesson->descript;
            $array[$index]['id_enseignant'] = $lesson->id_enseignant;
            $array[$index]['id_promo'] = $lesson->id_promo;
            $array[$index]['id_matiere'] = $lesson->id_matiere;
            $array[$index]['matiere'] = $matiere->libelle;
            $index++;
        }
        
        return $array;
    }
    
    function addAbsenceFunc($motif, Etudiant $etudiant, Cours $cours) {
        $crud = Crud::getInstance();
        $crud->createAbsence($motif, $etudiant, $cours);
    }
    
    function getLessonByIdFunc($id_cours){
        $crud = Crud::getInstance();
        $cou = new Cours();
        $cou = $crud->getLessonById($id_cours);
        return $cou;
    }
    
    function getPupilByIdFunc($id_etudiant){
        $crud = Crud::getInstance();
        $etu = new Etudiant();
        $etu = $crud->getStudentById($id_etudiant);
        return $etu;
    }
}

?>
