<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function loggingOK($login, $passwd) {
    $crud = Crud::getInstance();
    
    $student = $crud->getStudentByLogin($login);
    if ($student != null) {
        if ($passwd == $student->passwd) {
            return 1;
        }
    }
    
    $teacher = $crud->getTeacherByLogin($login);
    if ($teacher != null) {
        if ($passwd == $teacher->passwd) {
            return 2;
        }
    }
    
    $admin = $crud->getAdminByLogin($login);
    if ($admin != null) {
        if ($passwd == $admin->passwd) {
            return 3;
        }
    }
    
    return 0;
}

session_start();
$crud = Crud::getInstance();

$logged = loggingOK($login, $password);

if ($logged == 0) {
    ?>
    <div id="auth_fail">
        <p>
            Utilisateur inconnu ou mot de passe incorrect.
        </p>
        <input type="button" onclick='window.location.href="accueil.htm"' value="Retour &agrave; la page de connexion"/>
    </div>
    <?php
}
else if ($logged == 1) {
    $student = $crud->getStudentByLogin($login);
    $_SESSION["type"] = "student";
    $_SESSION["login"] = $login;
    $_SESSION["prenom"] = $student->prenom;
    $_SESSION["nom"] = $student->nom;
    header('Location: pup-indexPupil.htm');
} 
else if ($logged == 2) {
    $teacher = $crud->getTeacherByLogin($login);
    $_SESSION["type"] = "teacher";
    $_SESSION["login"] = $login;
    $_SESSION["prenom"] = $teacher->prenom;
    $_SESSION["nom"] = $teacher->nom;
    header('Location: tea-indexTeacher.htm');
} 
else if ($logged == 3) {
    $student = $crud->getStudentByLogin($login);
    $_SESSION["type"] = "admin";
    $_SESSION["login"] = $login;
    $_SESSION["prenom"] = "Administrateur";
    header('Location: adm-indexAdmin.htm');
}

?>

<!-- ici redirection en fonction de ce qui est trouvé en base données -->


