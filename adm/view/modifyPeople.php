<?php

session_start();
if(isset($_SESSION["type"])) {
    if (!$_SESSION["type"] == "admin") {
        if ($_SESSION["type"] == "teacher") {
            header('Location: tea-indexTeacher.htm');
        }
        else if ($_SESSION["type"] == "student") {
            header('Location: pup-indexPupil.htm');
        }
    }
}
else {
    header('Location: accueil.htm');
}
?>
<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <?php

            //Vérification de remplissagge des champs en post
            require_once $modify_people_class;
            $modify_people = ModifyPeople::getInstance();

            if ($v_type == Manager::$TEACHER){
                if (($login != null) && ($password != null) && ($lastName != null)
                    && ($firstName != null) && ($email != null) && ($street != null) 
                        && ($zipcode != null) && ($city != null)){

                    try {
                        $modify_people->updateTeacher($v_id, $lastName, $firstName, $street, $zipcode, $city, $email, $login, $password);
                        header('Location: adm-managePeople.htm');
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }

                $teacher = $modify_people->getPeopleByID($v_id, $v_type);
                ?>
                <p class="subtitle">Modifier un enseignant</p>
                <form method="POST" action="adm-modifyPeople-<?php echo $v_id . "-" . $v_type; ?>.htm">
                    <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login" value="<?php echo $teacher->ulogin; ?>"></p>
                    <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password" value="<?php echo $teacher->passwd; ?>"></p>
                    <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName" value="<?php echo $teacher->nom; ?>"></p>
                    <p><span class="label_form"><label>Prénom</label></span><input class="input_form" type="text" name="firstName" value="<?php echo $teacher->prenom; ?>"></p>
                    <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street" value="<?php echo $teacher->rue; ?>"></p>
                    <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode" value="<?php echo $teacher->cp; ?>"></p>
                    <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city" value="<?php echo $teacher->ville; ?>"></p>
                    <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email" value="<?php echo $teacher->email; ?>"></p>
                    <p class="button_form">
                        <input type="submit" name="envoyer" value="Modifier l'enseignant">
                        <input type="button" name="back" value="Retour" onclick="window.location.href='adm-managePeople.htm';" />
                    </p>
                </form>
                <?php
            }

            if ($v_type == Manager::$STUDENT){
                if (($login != null) && ($password != null) && ($lastName != null)
                    && ($firstName != null) && ($email != null) && ($street != null) 
                        && ($zipcode != null) && ($city != null) && ($photo != null) && ($birthDay != null)){
                    try {
                        $date = $modify_people->convertStringToDate($birthDay);
                        $modify_people->updateStudent($v_id, $lastName, $firstName, $date, $street, $zipcode, $city, $email, $login, $password, $photo);
                        header('Location: adm-managePeople.htm');
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } 
                
                $student = $modify_people->getPeopleByID($v_id, $v_type);
                ?>
                <p class="subtitle">Modifier un étudiant</p>
                <form method="POST" action="adm-modifyPeople-<?php echo $v_id . "-" . $v_type; ?>.htm">
                    <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login" value="<?php echo $student->ulogin; ?>"></p>
                    <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password" value="<?php echo $student->passwd; ?>"></p>
                    <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName" value="<?php echo $student->nom; ?>"></p>
                    <p><span class="label_form"><label>Prénom</label></span><input class="input_form" type="text" name="firstName" value="<?php echo $student->prenom; ?>"></p>
                    <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street" value="<?php echo $student->rue; ?>"></p>
                    <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode" value="<?php echo $student->cp; ?>"></p>
                    <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city" value="<?php echo $student->ville; ?>"></p>
                    <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email" value="<?php echo $student->email; ?>"></p>
                    <p><label class="label_form">Photo</label><input class="input_form" type="text" name="photo" value="<?php echo $student->photo; ?>"></p>
                    <p><label class="label_form">Date de naissance</label><input class="input_form" type="text" name="birthDay" value="<?php echo date("d/m/Y", strtotime($student->date_naissance)); ?>"></p>
                    <p class="button_form">
                        <input type="submit" name="envoyer" value="Modifier l'étudiant">
                        <input type="button" name="back" value="Retour" onclick="window.location.href='adm-managePeople.htm';" />
                    </p>
                </form>
                <?php     
            }

            ?>

        </td>
    </tr>
</table>
