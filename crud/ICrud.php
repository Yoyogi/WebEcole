<?php

require_once $classes_repo.$studentclass_file;

interface ICrud {
    //crud étudiant
    function createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteStudent($idStudent);
    function getStudents();
    function getStudentById($id);
    
    //crud enseignant
    function createTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateTeacher($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteTeacher($idTeacher);
    function getTeachers();
    function getTeacherById($id);
    
    //crud administrateur
    function getAdmins();
    function getAdminById($id);
    
    //crud absence
    function getAbsencesBylesson($idLesson);
    function getAbsencesByStudent($idStudent);
    
    //crud cours
    function getLessons();
    function getLessonsByTeacher($idTeacher);
    function getLessonsBySubject($idSubject);
    function getLessonsByPromotion($idPromotion);
    
    //crud matière
    function getSubjects();
    function getSubjectsByTeacher($idTeacher);
    function getSubjectsByLesson($idLesson);
}

?>
