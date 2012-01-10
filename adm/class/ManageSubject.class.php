<?php

require_once $crud_file;
require_once $manager;

class ManageSubject extends Manager {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManageSubject::$instance == NULL) {
            ManageSubject::$instance = new ManageSubject();
        }
        return ManageSubject::$instance;
    }
    
    function ManageSubject() {
        $this->header = array('libelle' => 'Libelle');
    }
    
    public function getSubject() {
        try {
            $crud = Crud::getInstance();
            $matieres = $crud->getSubjects();
            $index = 0;

            $array = array();
            foreach ($matieres as $matiere) {
                $array[$index] = array();
                $array[$index]['libelle'] = $matiere->libelle;
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
    
    public function deleteSubject($type, $id) {
        try {
            $crud = Crud::getInstance();
            $crud->deleteSubject($id);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
