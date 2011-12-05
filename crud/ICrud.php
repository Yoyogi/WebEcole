<?php

require_once $classes_repo.$studentclass_file;

interface ICrud {
    //crud étudiant
    function createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteStudent($idStudent);
    function getStudents();
    function getStudentById($id);
    
    //crud enseignant
    function createTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteTeacher($idTeacher);
    function getTeachers();
    function getTeacherById($id);
}

?>
