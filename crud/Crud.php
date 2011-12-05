<?php
require_once $icrud_file;
class Crud implements ICrud {
    $connexion;
    
    function Crud() {
        $dsn = "mysql://root:root@localhost/webecole";
    }
    
    function createStudent() {
        $student = pdoMap::get("students")->InsertStudent(  "toto",
                                                            "titi",
                                                            "01/02/02",
                                                            "9, rue du mouftard",
                                                            "35623",
                                                            "Moufetard",
                                                            "titi@toto.com",
                                                            "titi",
                                                            "toto",
                                                            "C://toto.png");
//        $student->name = "toto";
//        $student->surname = "titi";
//        $student->birthday = "01/02/02";
//        $student->adress = "9, rue du mouftard";
//        $student->zipCode = "35623";
//        $student->city = "Moufetard";
//        $student->mail = "titi@toto.com";
//        $student->login = "titi";
//        $student->passwd = "toto";
//        $student->photo = "C://toto.png";
//        $student->Insert();
    }
    
    function getStudents() {
        $students = pdoMap::get("students")->SelectEntity(1);
        echo $students;
    }
}

?>
