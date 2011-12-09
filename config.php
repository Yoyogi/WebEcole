<?php
/* nom des fichiers principaux */
$controller_file = "controller.php";
$header_file = "header.php";
$footer_file = "footer.php";

/* configuration de doctrine */
define('CFG_DB_DSN', 'mysql://root@localhost/webecole');
define('LIB_DIR',  dirname(__FILE__).'/lib/');
define('CFG_DIR',  dirname(__FILE__).'/');
require_once(LIB_DIR.'vendor/doctrine/Doctrine.php');
spl_autoload_register(array('Doctrine_Core', 'autoload'));

/* nom des fichiers de style */
$styleGeneral_file = "style.css";

/* nom des répertoires */
$crud_repo = "crud/";
$auth_repo = "auth/";
$adm_repo = "adm/";
$pupil_repo = "pupil/";
$teacher_repo = "teacher/";
$classes_repo = "crud/classes/";

/* nom des fichiers de page */
$index_file = $auth_repo."auth.php";
$log_forwarding_file = $auth_repo."forwarding.php";
$add_division_file = $adm."addDivision.php";
$add_lesson_file = $adm."addLesson.php";
$add_people_file = $adm."addPeople.php";
$add_subject_file = $adm."addSubject.php";
$index_admin_file = $adm."indexAdmin.php";
$manage_absence_file = $adm."manageAbsence.php";
$manage_division_file = $adm."manageDivision.php";
$manage_lesson_file = $adm."manageLesson.php";
$manage_people_file = $adm."managePeople.php";
$manage_subject_file = $adm."manageSubject.php";
$modify_division_file = $adm."modifyDivision.php";
$modify_lesson_file = $adm."modifyLesson.php";
$modify_people_file = $adm."modifyPeople.php";
$modify_subject_file = $adm."modifySubject.php";


//$logged_accueil = $auth_repo."addPeople.php";
//$gest_personne_file = $adm_repo."gest_personne.php";

/* nom des fichiers du crud */
$crud_file = $crud_repo."Crud.php";
$icrud_file = $crud_repo."ICrud.php";

/* nom des classes */
$studentclass_file = "Student.class.php";
?>
