<?php

require_once $crud_file;
require_once $manager;

class ManagePeople extends Manager {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManagePeople::$instance == NULL) {
            ManagePeople::$instance = new ManagePeople();
        }
        return ManagePeople::$instance;
    }
    
    function ManagePeople() {
        $this->header = array('nom' => 'Nom', 'prenom' => 'Prenom', 'status' => 'Status');
    }
    
    public function getPeople() {
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
                $array[$index]['status'] = "Student";
                $index++;
            }

            foreach ($teachers as $teacher) {
                $array[$index] = array();
                $array[$index]['id'] = $teacher->id_enseignant;
                $array[$index]['nom'] = $teacher->nom;
                $array[$index]['prenom'] = $teacher->prenom;
                $array[$index]['status'] = "Teacher";
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
    
    public function deletePeople($type, $id) {
        try {
            $crud = Crud::getInstance();

            if ($type == Manager::$TEACHER) {
                $crud->deleteTeacher($id);
            }
            else if ($type == Manager::$STUDENT) {
                $crud->deleteStudent($id);
            }
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
