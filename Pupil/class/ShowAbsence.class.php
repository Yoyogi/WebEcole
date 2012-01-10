<?php

require_once $crud_file;
require_once $manager;

class ShowAbsence extends Manager {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ShowAbsence::$instance == NULL) {
            ShowAbsence::$instance = new ShowAbsence();
        }
        return ShowAbsence::$instance;
    }
    
    function ShowAbsence() {
        $this->header = array('motif' => 'Motif', 'nom_etudiant' => 'Nom', 'prenom_etudiant' => 'Prenom', 'nom_cours' => 'Cours');
    }
    
    public function getAbsence() {
        try {
            $crud = Crud::getInstance();
            $absences = $crud->getAbsences();
            $index = 0;

            $array = array();
            foreach ($absences as $absence) {
                $student = $crud->getStudentById($absence->id_etudiant);
                $matiere = $crud->getSubjectByLesson($absence->id_cours);

                $array[$index] = array();
                $array[$index]['motif'] = $absences->motif;
                $array[$index]['nom'] = $student->nom;
                $array[$index]['prenom'] = $student->prenom;
                $array[$index]['cour'] = $matiere->libelle;
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
