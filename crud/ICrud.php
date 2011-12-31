 <?php

require_once $absenceclass_file;
require_once $administrateurclass_file;
require_once $aideclass_file;
require_once $coursclass_file;
require_once $enseignantclass_file;
require_once $enseignantmatiereclass_file;
require_once $etudiantclass_file;
require_once $etudiantpromotionclass_file;
require_once $exerciceclass_file;
require_once $matiereclass_file;
require_once $promotionclass_file;

interface ICrud {
    //crud étudiant
    function createStudent($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function updateStudent($idStudent, $nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
    function deleteStudent($idStudent);
    function getStudents();
    function getStudentById($id);
    function getStudentByLogin($login);
    
    //crud enseignant
    function createTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
    function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
    function deleteTeacher($idTeacher);
    function getTeachers();
    function getTeacherById($id);
    function getTeacherByLogin($login);
    
    //crud administrateur
    function getAdmins();
    function getAdminById($id);
    function getAdminByLogin($login);
    
    //crud absence
    function createAbsence($motif, $etudiant, $cours);
    function getAbsences();
    function getAbsencesBylesson($idLesson);
    function getAbsencesByStudent($idStudent);
    
    //crud cours
    function getLessons();
    function getLessonById($id);
    function getLessonsByTeacher($idTeacher);
    function getLessonsBySubject($idSubject);
    function getLessonsByPromotion($idPromotion);
    
    //crud matière
    function getSubjects();
    function getSubjectsByTeacher($idTeacher);
    function getSubjectByLesson($idLesson);
}

?>
