<?php

require_once $crud_file;
require_once $manager;

class ModifyPeople {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (ModifyPeople::$instance == NULL) {
            ModifyPeople::$instance = new ModifyPeople();
        }
        return ModifyPeople::$instance;
    }
    
    public function getPeopleByID($id_people, $type_people) {
        $crud = Crud::getInstance();
        
        if ($type_people == Manager::$ADMIN) {
            return $crud->getAdminById($id_people);
        }
        else if ($type_people == Manager::$TEACHER) {
            return $crud->getTeacherById($id_people);
        }
        else {
            return $crud->getStudentById($id_people);
        }
    }

    public function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        $crud = Crud::getInstance();
        $crud->updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    }
    
    public function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        $crud = Crud::getInstance();
        $crud->updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
    }
}

?>
