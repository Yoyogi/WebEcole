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
        $this->header = array('nom_cours' => 'Cours', 'nom_etudiant' => 'Nom', 'prenom_etudiant' => 'Prenom', 'motif' => 'Motif');
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
                $array[$index]['cour'] = $matiere->libelle;
                $array[$index]['nom'] = $student->nom;
                $array[$index]['prenom'] = $student->prenom;
                $array[$index]['motif'] = $absence->motif;
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
    
    public function deleteAbsence($id) {
        try {
            $crud = Crud::getInstance();
            $crud->deleteAbsence($id);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
