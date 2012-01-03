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
    header('Location: pup-indexPupil.htm');
} 
else if ($logged == 2) {
    header('Location: tea-indexTeacher.htm');
} 
else if ($logged == 3) {
    header('Location: adm-indexAdmin.htm');
}

?>

<!-- ici redirection en fonction de ce qui est trouvé en base données -->


