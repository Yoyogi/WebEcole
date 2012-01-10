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
    }
    
    if ($status=="1"){
        
        if (($login != null) && ($password != null) && ($lastName != null)
            && ($firstName != null) && ($email != null) && ($street != null) 
                && ($zipcode != null) && ($city != null) && ($photo != null) && ($birthDay != null)){
            try {
                $add_people->addPupil($lastName, $firstName, $birthDay, $street, $zipcode, $city, $email, $login, $password, $photo);
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
                    <option <?php if ($type==0) echo "selected='selected'"; ?> value="0"></option>
                    <option <?php if ($type==1) echo "selected='selected'"; ?> value="1">Elève</option>
                    <option <?php if ($type==2) echo "selected='selected'"; ?> value="2">Professeur</option>
                </select>

                <?php
                    if (isset($type)) {
                        if ($type != 0) {
                ?>
                <p><label class="label_form"> Login </label> <input class="input_form" type="text" name="login"> </p>
                <p><label class="label_form"> Mot de passe </label> <input class="input_form" type="text" name="password"> </p>
                <p><label class="label_form"> Nom </label> <input class="input_form" type="text" name="lastName"> </p>
                <p><label class="label_form"> Prenom </label> <input class="input_form" type="text" name="firstName"> </p>
                <p><label class="label_form"> Rue </label> <input class="input_form" type="text" name="street"> </p>
                <p><label class="label_form"> Code postal </label> <input class="input_form" type="text" name="zipcode"> </p>
                <p><label class="label_form"> Ville </label> <input class="input_form" type="text" name="city"> </p>
                <p><label class="label_form"> Email </label> <input class="input_form" type="text" name="email"> </p>

                <?php
                        }
                        if ($type==1){
                ?>

                <!-- si la personne a ajouter est un étudiant -->

                <p><label class="label_form"> Photo </label> <input class="input_form" type="text" name="photo"> </p>
                <p><label class="label_form"> Date de naissance </label> <input class="input_form" type="text" name="birthDay"> </p>
                <?php
                        }
                ?>
                <p> <input type="submit" name="envoyer" value="Ajouter personne"> </p>
                <?php
                    }
                ?>


            </form>
        </td>
    </tr>
</table>