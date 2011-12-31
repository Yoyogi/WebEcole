<?php
/* nom des fichiers principaux */
$controller_file = "controller.php";
$header_file = "header.php";
$footer_file = "footer.php";

/* configuration de doctrine */
define('CFG_DB_DSN', 'mysql://root@localhost/webecole');
define('LIB_DIR',  dirname(__FILE__).'/lib/');
define('CRUD_DIR', dirname(__FILE__).'/crud/');
define('CFG_DIR',  dirname(__FILE__).'/');
require_once(LIB_DIR.'vendor/doctrine/Doctrine.php');
spl_autoload_register(array('Doctrine_Core', 'autoload'));
spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));
Doctrine_Core::generateModelsFromYaml(CFG_DIR.'DoctrineConfig.yml', CRUD_DIR.'models', array('generateTableClasses' => true));

/* nom des fichiers de style */
$styleGeneral_file = "style.css";

/* nom des répertoires */
$crud_repo = "crud/";
$auth_repo = "auth/";
$adm_repo = "adm/";
$pupil_repo = "pupil/";
$teacher_repo = "teacher/";
$classes_repo = "crud/classes/";

/* nom des fichiers AUTH */
$controller_auth_file = $auth_repo."controller_Auth.php";
$index_file = $auth_repo."auth.php";
$log_forwarding_file = $auth_repo."forwarding.php";

/* nom des fichiers ADM */
$controller_adm_file = $adm_repo."controller_Admin.php";
$add_division_file = $adm_repo."view/AddDivision.php";
$add_lesson_file = $adm_repo."view/AddLesson.php";
$add_people_file = $adm_repo."view/AddPeople.php";
$add_subject_file = $adm_repo."view/AddSubject.php";
$index_admin_file = $adm_repo."IndexAdmin.php";
$manage_absence_file_admin = $adm_repo."view/ManageAbsence.php";
$manage_division_file = $adm_repo."view/ManageDivision.php";
$manage_lesson_file_admin = $adm_repo."view/ManageLesson.php";
$manage_people_file = $adm_repo."view/ManagePeople.php";
$manage_subject_file = $adm_repo."view/ManageSubject.php";
$modify_division_file = $adm_repo."view/ModifyDivision.php";
$modify_lesson_file = $adm_repo."view/ModifyLesson.php";
$modify_people_file = $adm_repo."view/ModifyPeople.php";
$modify_subject_file = $adm_repo."view/ModifySubject.php";

$manage_people_class = $adm_repo."class/ManagePeople.class.php";

/* nom des fichiers TEACHER */
$controller_teacher_file = $teacher_repo."controller_Teacher.php";
$index_teacher_file = $teacher_repo."indexTeacher.php";
$manage_absence_file_teacher = $teacher_repo."view/manageAbsence.php";
$manage_exercice_file = $teacher_repo."view/manageExercice.php";
$manage_lesson_file_teacher = $teacher_repo."view/manageLesson.php";
$show_student_file = $teacher_repo."view/showStudents.php";

/* nom des fichiers PUPIL */
$controller_pupil_file = $pupil_repo."controller_Pupil.php";
$index_pupil_file = $pupil_repo."indexPupil.php";
$show_absence_file = $pupil_repo."view/showAbsence.php";
$show_lesson_file = $pupil_repo."view/showLesson.php";


/* nom des fichiers du crud */
$crud_file = $crud_repo."Crud.php";
$icrud_file = $crud_repo."ICrud.php";

/* nom des classes */
$absenceclass_file = "models/Absence.php";
$administrateurclass_file = "models/Administrateur.php";
$aideclass_file = "models/Aide.php";
$coursclass_file = "models/Cours.php";
$enseignantclass_file = "models/Enseignant.php";
$enseignantmatiereclass_file = "models/EnseignantMatiere.php";
$etudiantclass_file = "models/Etudiant.php";
$etudiantpromotionclass_file = "models/EtudiantPromotion.php";
$exerciceclass_file = "models/Exercice.php";
$matiereclass_file = "models/Matiere.php";
$promotionclass_file = "models/Promotion.php";
?>
