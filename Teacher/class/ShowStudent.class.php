<?php

require_once $crud_file;
require_once $manager;

class ShowStudent extends Manager {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ShowStudent::$instance == NULL) {
            ShowStudent::$instance = new ShowStudent();
        }
        return ShowStudent::$instance;
    }
    
    public function getHeader() {
        return $this->header;
    }
    
    function ShowStudent() {
        $this->header = array('nom' => 'Nom', 'prenom' => 'Prenom', 'date_naissance' => 'Date de naissance', 'rue' => 'rue', 'cp' => 'CP', 'ville' => 'Ville', 'email' => 'Email');
    }
    
    public function getStudent() {
        try {
            $crud = Crud::getInstance();
            $students = $crud->getStudents();
            $teachers = $crud->getTeachers();
            $index = 0;

            $array = array();
            foreach ($students as $student) {
                $array[$index] = array();
                $array[$index]['nom'] = $student->nom;
                $array[$index]['prenom'] = $student->prenom;
                $array[$index]['date_naissance'] = date("d/m/Y", strtotime($student->date_naissance));
                $array[$index]['rue'] = $student->rue;
                $array[$index]['cp'] = $student->cp;
                $array[$index]['ville'] = $student->ville;
                $array[$index]['email'] = $student->email;
                $index++;
            }

            return $array;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
