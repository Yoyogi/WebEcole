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
        try {
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
        catch (Exception $e) {
            throw $e;
        }
    }

    public function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo) {
        try {
            $crud = Crud::getInstance();
            $crud->updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd) {
        try {
            $crud = Crud::getInstance();
            $crud->updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    function convertStringToDate($string) {
        list($d, $m, $y) = explode('/', $string);
        $mk = mktime(0, 0, 0, $m, $d, $y);
        $result = strftime('%Y-%m-%d',$mk);
        return $result;
    }
}

?>
