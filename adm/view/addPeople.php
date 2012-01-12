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
require_once $add_people_class;
$add_people = AddPeople::getInstance();

if (isset($status)){
    
    if ($status=="2"){
        if (($login != null) && ($password != null) && ($lastName != null)
            && ($firstName != null) && ($email != null) && ($street != null) 
                && ($zipcode != null) && ($city != null)){
            
            try {
                $add_people->addTeacher($lastName, $firstName, $street, $zipcode, $city, $email, $login, $password);
                header('Location: adm-managePeople.htm');
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
    }
    
    if ($status=="1"){
        
        if (($login != null) && ($password != null) && ($lastName != null)
            && ($firstName != null) && ($email != null) && ($street != null) 
                && ($zipcode != null) && ($city != null) && ($photo != null) && ($birthDay != null)){
            try {
                $date = $add_people->convertStringToDate($birthDay);
                $add_people->addPupil($lastName, $firstName, $date, $street, $zipcode, $city, $email, $login, $password, $photo);
                header('Location: adm-managePeople.htm');
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
    }
    
    
}else{
    echo "Choisissez une categorie";
}


?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <form method="POST" action="adm-addPeople.htm">

                <select name="status" onchange="window.location.href='adm-addPeople-'+this.selectedIndex+'.htm'">
                    <option <?php if ($type==0) echo "selected='selected'"; ?> value="1">Elève</option>
                    <option <?php if ($type==1) echo "selected='selected'"; ?> value="2">Professeur</option>
                </select>
                
                <?php
                    if (isset($type)) {
                        if ($type == 0) {
                            echo "<p class='title_form'>Ajout d'un élève</p>";
                        }
                        else {
                            echo "<p class='title_form'>Ajout d'un enseignant</p>";
                        }
                    }
                    else {
                        echo "<p class='title_form'>Ajout d'un élève</p>";
                    }
                ?>

                <?php
                    if (isset($type)) {
                ?>
                <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login"></p>
                <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password"></p>
                <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName"></p>
                <p><span class="label_form"><label>Prénom</label></span><input class="input_form" type="text" name="firstName"></p>
                <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street"></p>
                <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode"></p>
                <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city"></p>
                <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email"></p>

                <?php
                        if ($type==0){
                ?>

                <!-- si la personne a ajouter est un étudiant -->

                <p><label class="label_form">Photo</label><input class="input_form" type="text" name="photo"></p>
                <p><label class="label_form">Date de naissance</label><input class="input_form" type="text" name="birthDay"></p>
                <?php
                        }
                ?>
                <p class="button_form">
                    <input type="submit" name="envoyer" value="Ajouter la personne">
                    <input type="button" name="back" value="Retour" onclick="window.location.href='adm-managePeople.htm';" />
                </p>
                <?php
                    }
                    else {
                        ?>
                <p><span class="label_form"><label>Login</label></span><input class="input_form" type="text" name="login"></p>
                <p><span class="label_form"><label>Mot de passe</label></span><input class="input_form" type="text" name="password"></p>
                <p><span class="label_form"><label>Nom</label></span><input class="input_form" type="text" name="lastName"></p>
                <p><span class="label_form"><label>Prénom</label></span><input class="input_form" type="text" name="firstName"></p>
                <p><span class="label_form"><label>Rue</label></span><input class="input_form" type="text" name="street"></p>
                <p><span class="label_form"><label>Code postal</label></span><input class="input_form" type="text" name="zipcode"></p>
                <p><span class="label_form"><label>Ville</label></span><input class="input_form" type="text" name="city"></p>
                <p><span class="label_form"><label>Email</label></span><input class="input_form" type="text" name="email"></p>
                <p><label class="label_form">Photo</label><input class="input_form" type="text" name="photo"></p>
                <p><label class="label_form">Date de naissance</label><input class="input_form" type="text" name="birthDay"></p>
                <p class="button_form">
                    <input type="submit" name="envoyer" value="Ajouter la personne">
                    <input type="button" name="back" value="Retour" onclick="window.location.href='adm-managePeople.htm';" />
                </p>
                        <?php
                    }
                ?>


            </form>
        </td>
    </tr>
</table>