<?php

require_once $crud_file;
require_once $manager;

class ManageAbsence extends Manager {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManageAbsence::$instance == NULL) {
            ManageAbsence::$instance = new ManageAbsence();
        }
        return ManageAbsence::$instance;
    }
    
    function ManageAbsence() {
        $this->header = array('id_absence' => 'Identifiant', 'motif' => 'Motif', 'nom_etudiant' => 'Nom', 'prenom_etudiant' => 'Prenom', 'nom_cours' => 'Cours');
    }
    
    public function getAbsence() {
        $crud = Crud::getInstance();
        $absences = $crud->getAbsences();
        $index = 0;

        $array = array();
        foreach ($absences as $absence) {
            $student = $crud->getStudentById($absence->id_etudiant);
            $matiere = $crud->getSubjectByLesson($absence->id_cours);
            
            $array[$index] = array();
            $array[$index]['id'] = $absences->id_absence;
            $array[$index]['motif'] = $absences->motif;
            $array[$index]['nom'] = $student->nom;
            $array[$index]['prenom'] = $student->prenom;
            $array[$index]['cour'] = $matiere->libelle;
            $index++;
        }
        
        return $array;
    }
    
    public function getHeader() {
        return $this->header;
    }
    
    public function deleteAbsence($id) {
        $crud = Crud::getInstance();
    }
}

?>
