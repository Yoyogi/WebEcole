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

//Vérification de remplissagge des champs en post
require_once $modify_people_class;
$modify_people = ModifyPeople::getInstance();
    
if ($v_type == Manager::$TEACHER){
    if (($login != null) && ($password != null) && ($lastName != null)
        && ($firstName != null) && ($email != null) && ($street != null) 
            && ($zipcode != null) && ($city != null)){

        try {
            $modify_people->updateTeacher($lastName, $firstName, $street, $zipcode, $city, $email, $login, $password);
            echo "enseignant ajoute";
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }else{
        echo "Login : " . $login;
        echo "password : " . $password;
        echo "lastname : " . $lastName;
        echo "firstname : " . $firstName;
        echo "email : " . $email;
        echo "street : " . $street;
        echo "zipcode : " . $zipcode;
        echo "city : " . $city;
        echo "Veuillez remplir tous les champs correctement";
    }

    $teacher = $modify_people->getPeopleByID($v_id, $v_type);
    ?>
    <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login" value="<?php echo $teacher->ulogin; ?>"></p>
    <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password" value="<?php echo $teacher->passwd; ?>"></p>
    <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName" value="<?php echo $teacher->nom; ?>"></p>
    <p><span class="label_form"><label>Prenom</label></span><input class="input_form" type="text" name="firstName" value="<?php echo $teacher->prenom; ?>"></p>
    <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street" value="<?php echo $teacher->rue; ?>"></p>
    <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode" value="<?php echo $teacher->cp; ?>"></p>
    <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city" value="<?php echo $teacher->ville; ?>"></p>
    <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email" value="<?php echo $teacher->email; ?>"></p>
    <?php
}

if ($v_type == Manager::$STUDENT){

    if (($login != null) && ($password != null) && ($lastName != null)
        && ($firstName != null) && ($email != null) && ($street != null) 
            && ($zipcode != null) && ($city != null) && ($photo != null) && ($birthDay != null)){
        try {
            $add_people->updateStudent($lastName, $firstName, $birthDay, $street, $zipcode, $city, $email, $login, $password, $photo);
            echo "eleve ajoute";
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    else {
        echo "<br>Login : " . ($login != null);
        echo "<br>password : " . ($password != 0);
        echo "<br>lastname : " . ($lastName != 0);
        echo "<br>firstname : " . ($firstName != 0);
        echo "<br>email : " . ($email != 0);
        echo "<br>street : " . ($street != 0);
        echo "<br>zipcode : " . ($zipcode != null);
        echo "<br>city : " . ($city != 0);
        echo "<br>photo : " . ($photo != 0);
        echo "<br>birthday : " . ($birthDay != 0);
        echo "<br>Veuillez remplir tous les champs correctement";

    }

    $student = $modify_people->getPeopleByID($v_id, $v_type);
    ?>
    <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login" value="<?php echo $student->ulogin; ?>"></p>
    <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password" value="<?php echo $student->passwd; ?>"></p>
    <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName" value="<?php echo $student->nom; ?>"></p>
    <p><span class="label_form"><label>Prenom</label></span><input class="input_form" type="text" name="firstName" value="<?php echo $student->prenom; ?>"></p>
    <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street" value="<?php echo $student->rue; ?>"></p>
    <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode" value="<?php echo $student->cp; ?>"></p>
    <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city" value="<?php echo $student->ville; ?>"></p>
    <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email" value="<?php echo $student->email; ?>"></p>
    <p><label class="label_form">Photo</label><input class="input_form" type="text" name="photo" value="<?php echo $student->photo; ?>"></p>
    <p><label class="label_form">Date de naissance</label><input class="input_form" type="text" name="birthDay" value="<?php echo $student->date_naissance; ?>"></p>
    <?php        
}

?>
