<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AddPeople
 *
 * @author sferrand
 */
require_once $crud_file;

class AddPeople {
    //put your code here

        public static $instance = NULL;
        private $crud;

        static public function getInstance() {
            if (AddPeople::$instance == NULL) {
                AddPeople::$instance = new AddPeople();
            }
            return AddPeople::$instance;
        }

        function addPupil($id_etudiant, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
            $crud = Crud::getInstance();
            $crud->createStudent($id_etudiant, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
        }
        
        function addTeacher($id_enseignant, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd){
            $crud = Crud::getInstance();
            $crud->createTeacher($id_enseignant, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
        }

    }

?>