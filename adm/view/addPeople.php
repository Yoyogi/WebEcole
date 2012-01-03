<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Vérification de remplissagge des champs en post
require_once $add_people_class;
$add_people = AddPeople::getInstance();

echo "status" . $status;
echo "login" . $login;
echo "password" . $password;
echo "lastname" . $lastName;
echo "firstname" . $firstName;
echo "email" . $email;
echo "street" . $street;
echo "zipcode" . $zipcode;
echo "city" . $city;
if (isset($status)){
    
    if ($status=="2"){
        if ((isset($login)) && (isset($password)) && (isset($lastName))
            && (isset($firstName)) && (isset($email)) && (isset($street)) 
                && (isset($zipcode)) && (isset($city))){
            echo "tuta";
            $add_people->addTeacher($lastName, $firstName, $street, $zipcode, $city, $email, $login, $password);
        }
    }
    
    if ($status=="1"){
        
        if (($login) && ($password) && ($lastName) 
            && ($firstName) && ($email) && ($street) 
                && ($zipcode) && ($city) && ($photo) && ($birthday)){
            echo "tutu";
            $add_people->addPupil($lastName, $firstName, $birthDay, $street, $zipcode, $city, $email, $login, $password, $photo);
        }
        
    }
    
    
}


?>

    
<form method="POST" action="addPeople.htm">
    
    <select name="status" onchange="window.location.href='addPeople-'+this.selectedIndex+'.htm'">
        <option <?php if ($type==0) echo "selected='selected'"; ?> value="0"></option>
        <option <?php if ($type==1) echo "selected='selected'"; ?> value="1">eleve</option>
        <option <?php if ($type==2) echo "selected='selected'"; ?> value="2">professeur</option>
    </select>

    <?php
        if (isset($type)) {
            if ($type != 0) {
    ?>
    <p><label> Login </label> <input type="text" name="login"> </p>
    <p><label> Mot de passe </label> <input type="text" name="password"> </p>
    <p><label> Nom </label> <input type="text" name="lastName"> </p>
    <p><label> Prenom </label> <input type="text" name="firstName"> </p>
    <p><label> Rue </label> <input type="text" name="street"> </p>
    <p><label> Code postal </label> <input type="text" name="zipcode"> </p>
    <p><label> Ville </label> <input type="text" name="city"> </p>
    <p><label> Email </label> <input type="text" name="email"> </p>
    
    <?php
            }
            if ($type==1){
    ?>
    
    <!-- si la personne a ajouter est un étudiant -->
    
    <p><label> Photo </label> <input type="text" name="photo"> </p>
    <p><label> Date de naissance </label> <input type="text" name="birthDay"> </p>
    <?php
            }
    ?>
    <p> <input type="submit" name="envoyer" value="Ajouter personne"> </p>
    <?php
        }
    ?>
    
    
</form>