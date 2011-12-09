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
$logged_accueil = $auth_repo."addPeople.php";
$gest_personne_file = $adm_repo."gest_personne.php";

/* nom des fichiers du crud */
$crud_file = $crud_repo."Crud.php";
$icrud_file = $crud_repo."ICrud.php";

/* nom des classes */
$studentclass_file = "Student.class.php";
?>
