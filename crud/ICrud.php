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
    function addPromotionToStudent(Etudiant $student, Promotion $promotion);
    function removePromotionToStudent(Etudiant $student, Promotion $promotion);
    function addAbsenceToStudent(Absence $absence, Etudiant $student);
    function removeAbsenceToStudent(Absence $absence, Etudiant $student);
    function getStudents();
    function getStudentById($id);
    function getStudentByLogin($login);
    
    //crud enseignant
    function createTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
    function updateTeacher($id, $nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
    function deleteTeacher($idTeacher);
    function addSubjectToTeacher(Enseignant $enseignant, Matiere $matiere);
    function removeSubjectToTeacher(Enseignant $enseignant, Matiere $matiere);
    function addLessonToTeacher(Enseignant $enseignant, Cours $cours);
    function removeLessonToTeacher(Enseignant $enseignant, Cours $cours);
    function getTeachers();
    function getTeacherById($id);
    function getTeacherByLogin($login);
    
    //crud administrateur
    function getAdmins();
    function getAdminById($id);
    function getAdminByLogin($login);
    
    //crud absence
    function createAbsence($motif, Etudiant $etudiant, Cours $cours);
    function updateAbsence($id, $motif, Etudiant $etudiant, Cours $cours);
    function deleteAbsence($id);
    function getAbsences();
    function getAbsencesBylesson($idLesson);
    function getAbsencesByStudent($idStudent);
    
    //crud cours
    function createLesson($date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere);
    function updateLesson($id, $date, $duree, $descript, Enseignant $enseignant, Promotion $promotion, Matiere $matiere);
    function deleteLesson($id);
    function addAbsenceToLesson(Cours $lesson, Absence $absence);
    function removeAbsenceToLesson(Cours $lesson, Absence $absence);
    function addExerciceToLesson(Cours $lesson, Exercice $exercice);
    function removeExerciceToLesson(Cours $lesson, Exercice $exercice);
    function getLessons();
    function getLessonById($id);
    function getLessonsByTeacher($idTeacher);
    function getLessonsBySubject($idSubject);
    function getLessonsByPromotion($idPromotion);
    
    //crud matière
    function createSubject($libelle);
    function updateSubject($id, $libelle);
    function deleteSubject($id);
    function addTeacherToSubject(Matiere $subject, Enseignant $teacher);
    function removeTeacherToSubject(Matiere $subject, Enseignant $teacher);
    function addLessonToSubject(Matiere $subject, Cours $lesson);
    function removeLessonToSubject(Matiere $subject, Cours $lesson);
    function getSubjects();
    function getSubjectsByTeacher($idTeacher);
    function getSubjectByLesson($idLesson);
    
    //crud aide
    function createHelp($page, $libelle);
    function updateHelp($id, $page, $libelle);
    function deleteHelp($id);
    function getHelps();
    function getHelpById($id);
    function getHelpsByPage($page);
    
    //crud promotion
    function createPromotion($libelle);
    function updatePromotion($id, $libelle);
    function deletePromotion($id);
    function addStudentToPromotion(Promotion $promotion, Etudiant $student);
    function removeStudentFromPromotion(Promotion $promotion, Etudiant $student);
    function addLessonToPromotion(Promotion $promotion, Cours $lesson);
    function removeLessonFromPromotion(Promotion $promotion, Cours $lesson);
    function getPromotions();
    function getPromotionById($id);
    function getPromotionsByStudent($student);
    function getPromotionsByLesson($lesson);
    
    //crud exercice
    function createExercice($libelle, Cours $lesson);
    function updateExercice($id, $libelle, Cours $lesson);
    function deleteExercice($id);
    function getExercices();
    function getExerciceById($id);
    function getExercicesByLesson($id_lesson);
}

?>
