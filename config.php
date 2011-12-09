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
$add_division_file = $adm_repo."AddDivision.php";
$add_lesson_file = $adm_repo."AddLesson.php";
$add_people_file = $adm_repo."AddPeople.php";
$add_subject_file = $adm_repo."AddSubject.php";
$index_admin_file = $adm_repo."IndexAdmin.php";
$manage_absence_file = $adm_repo."ManageAbsence.php";
$manage_division_file = $adm_repo."ManageDivision.php";
$manage_lesson_file = $adm_repo."ManageLesson.php";
$manage_people_file = $adm_repo."view/ManagePeople.php";
$manage_subject_file = $adm_repo."ManageSubject.php";
$modify_division_file = $adm_repo."ModifyDivision.php";
$modify_lesson_file = $adm_repo."ModifyLesson.php";
$modify_people_file = $adm_repo."ModifyPeople.php";
$modify_subject_file = $adm_repo."ModifySubject.php";

$manage_people_class = $adm_repo."class/ManagePeople.class.php";

/* nom des fichiers TEACHER */
$controller_teacher_file = $teacher_repo."controller_Teacher.php";
$index_teacher_file = $teacher_repo."indexTeacher.php";
$manage_absence_file_teacher = $teacher_repo."manageAbsence.php";
$manage_exercice_file = $teacher_repo."manageExercice.php";
$manage_lesson_file_teacher = $teacher_repo."manageLesson.php";
$show_student_file = $teacher_repo."showStudents.php";

/* nom des fichiers PUPIL */
$controller_pupil_file = $pupil_repo."controller_Pupil.php";
$index_pupil = $pupil_repo."indexPupil.php";
$show_absence = $pupil_repo."showAbsence.php";
$show_lesson = $pupil_repo."showLesson.php";


/* nom des fichiers du crud */
$crud_file = $crud_repo."Crud.php";
$icrud_file = $crud_repo."ICrud.php";

/* nom des classes */
$studentclass_file = "Student.class.php";
?>
