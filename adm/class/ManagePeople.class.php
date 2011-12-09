<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManagePeople
 *
 * @author Midgard
 */
class ManagePeople {
    //put your code here
    private static $instance = NULL;
    private $crud;
    private $header;
    
    static public function getInstance() {
        if (ManagePeople::$instance == NULL) {
            ManagePeople::$instance = new ManagePeople();
        }
        return ManagePeople::$instance;
    }
    
    function ManagePeople() {
        $crud = Crud::getInstance();
        $header = array('id_etudiant' => 'Identifiant', 'nom' => 'Nom', 'prenom' => 'Prenom', 'status' => 'Status');
    }
    
    public function getPeople() {
        $students = $crud->getStudents();
        $teachers = $crud->getTeachers();
        $index = 0;

        foreach ($students as $student) {
            $array[$index]['id_etudiant'] = $student->id_etudiant;
            $array[$index]['nom'] = $student->nom;
            $array[$index]['prenom'] = $student->prenom;
            $array[$index]['status'] = "Student";
            $index++;
        }

        foreach ($students as $student) {
            $array[$index]['id_enseignant'] = $student->id_etudiant;
            $array[$index]['nom'] = $student->nom;
            $array[$index]['prenom'] = $student->prenom;
            $array[$index]['status'] = "Teacher";
            $index++;
        }
        
        return $array;
    }
    
    public function getHeader() {
        return $this->header;
    }
}

?>
