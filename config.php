<?php
/* nom des fichiers principaux */
$controller_file = "/controller.php";
$header_file = "/header.php";
$footer_file = "/footer.php";

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
$styleMenu_file = "design/style_menu.css";

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
$deconnexion_file = $auth_repo."deconnexion.php";

/* manager générale */
$manager = "manager.class.php";

/* nom des fichiers ADM */
$controller_adm_file = $adm_repo."controller_Admin.php";
$add_absence_file = $adm_repo."view/AddAbsence.php";
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
$assign_etudianttopromotion_file = $adm_repo."view/assignEtudiantToPromotion.php";
$assign_matieretoenseignant_file = $adm_repo."view/assignMatiereToEnseignant.php";
$forward_absence_file = $adm_repo."view/forwardAbsence.php";
$menu_adm_file = $adm_repo."adm_menu.php";

$manage_people_class = $adm_repo."class/ManagePeople.class.php";
$manage_absence_class = $adm_repo."class/ManageAbsence.class.php";
$manage_division_class = $adm_repo."class/ManageDivision.class.php";
$manage_lesson_class = $adm_repo."class/ManageLesson.class.php";
$manage_subject_class = $adm_repo."class/ManageSubject.class.php";
$add_people_class = $adm_repo."class/AddPeople.class.php";
$add_division_class = $adm_repo."class/AddDivision.class.php";
$add_absence_class = $adm_repo."class/AddAbsence.class.php";
$add_lesson_class = $adm_repo."class/AddLesson.class.php";
$add_subject_class = $adm_repo."class/AddSubject.class.php";
$modify_people_class = $adm_repo."class/ModifyPeople.class.php";
$modify_division_class = $adm_repo."class/ModifyDivision.class.php";
$modify_lesson_class = $adm_repo."class/ModifyLesson.class.php";
$modify_subject_class = $adm_repo."class/ModifySubject.class.php";
$assign_etudianttopromotion_class = $adm_repo."class/AssignEtudiantToPromotion.class.php";
$assign_matieretoenseignant_class = $adm_repo."class/AssignMatiereToEnseignant.class.php";
$forward_absence_class = $adm_repo."class/ForwardAbsence.class.php";

/* nom des fichiers TEACHER */
$controller_teacher_file = $teacher_repo."controller_Teacher.php";
$index_teacher_file = $teacher_repo."IndexTeacher.php";
$manage_absence_file_teacher = $teacher_repo."view/ManageAbsence.php";
$manage_exercice_file = $teacher_repo."view/ManageExercice.php";
$manage_lesson_file_teacher = $teacher_repo."view/ManageLesson.php";
$show_student_file = $teacher_repo."view/ShowStudents.php";
$add_exercice_file = $teacher_repo."view/AddExercice.php";
$add_absence_file = $teacher_repo."view/AddAbsence.php";
$manage_exercice_class = $teacher_repo."class/ManageExercice.class.php";
$manage_absence_class_teacher = $teacher_repo."class/ManageAbsence.class.php";
$manage_lesson_class_teacher = $teacher_repo."class/ManageLesson.class.php";
$show_student_class = $teacher_repo."class/showStudent.class.php";
$add_absence_class = $teacher_repo."class/AddAbsence.class.php";
$add_exercice_class = $teacher_repo."class/AddExercice.class.php";
$menu_teacher_file = $teacher_repo."teacher_menu.php";
$modify_exercice_file = $teacher_repo."view/ModifyExercice.php";
$modify_exercice_class = $teacher_repo."class/ModifyExercice.class.php";

/* nom des fichiers PUPIL */
$controller_pupil_file = $pupil_repo."controller_Pupil.php";
$index_pupil_file = $pupil_repo."indexPupil.php";
$show_absence_file = $pupil_repo."view/showAbsence.php";
$show_lesson_file = $pupil_repo."view/showLesson.php";
$show_absence_class = $pupil_repo."class/ShowAbsence.class.php";
$show_lesson_class = $pupil_repo."class/ShowLesson.class.php";
$menu_pupil_file = $pupil_repo."pupil_menu.php";

/* nom des fichiers du crud */
$crud_file = $crud_repo."Crud.php";
$icrud_file = $crud_repo."ICrud.php";

/* nom des classes */
$absenceclass_file = $crud_repo . "models/Absence.php";
$administrateurclass_file = $crud_repo . "models/Administrateur.php";
$aideclass_file = $crud_repo . "models/Aide.php";
$coursclass_file = $crud_repo . "models/Cours.php";
$enseignantclass_file = $crud_repo . "models/Enseignant.php";
$enseignantmatiereclass_file = $crud_repo . "models/EnseignantMatiere.php";
$etudiantclass_file = $crud_repo . "models/Etudiant.php";
$etudiantpromotionclass_file = $crud_repo . "models/EtudiantPromotion.php";
$exerciceclass_file = $crud_repo . "models/Exercice.php";
$matiereclass_file = $crud_repo . "models/Matiere.php";
$promotionclass_file = $crud_repo . "models/Promotion.php";
?>
