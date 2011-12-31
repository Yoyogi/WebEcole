<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//Vérification de remplissagge des champs en post
require_once $add_people_class;
$add_people = AddPeople::getInstance();


if ($_POST['status']!=null){
    
    if ($_POST['status']=="professeur"){
        if (($_POST['login']) && ($_POST['password']) && ($_POST['lastName']) 
            && ($_POST['firstName']) && ($_POST['email']) && ($_POST['street']) 
                && ($_POST['zipcode']) && ($_POST['city'])){
            $add_people->addTeacher($nom, $prenom, $rue, $cp, $ville, $email, $ulogin, $passwd);
        }
    }
    
    if ($_POST['status']=="eleve"){
        
        if (($_POST['login']) && ($_POST['password']) && ($_POST['lastName']) 
            && ($_POST['firstName']) && ($_POST['email']) && ($_POST['street']) 
                && ($_POST['zipcode']) && ($_POST['city']) && ($_POST['photo']) && ($_POST['birthday'])){
            $add_people->addPupil($nom, $prenom, $date_naissance, $rue, $cp, $ville, $email, $ulogin, $passwd, $photo);
        }
        
    }
    
    
    

    

    
    
}


?>

    
<form method="POST" action="addPeople.htm">
    
    <select name="status" onchange="fonction(this);">
        <option value="eleve">eleve</option>
        <option value="professeur">professeur</option>
    </select>


    <p><label> Login </label> <input type="text" name="login"> </p>
    <p><label> Mot de passe </label> <input type="text" name="password"> </p>
    <p><label> Nom </label> <input type="text" name="lastName"> </p>
    <p><label> Prenom </label> <input type="text" name="firstName"> </p>
    <p><label> Rue </label> <input type="text" name="street"> </p>
    <p><label> Code postal </label> <input type="text" name="zipcode"> </p>
    <p><label> Ville </label> <input type="text" name="city"> </p>
    <p><label> Email </label> <input type="text" name="email"> </p>
    <p><label> Statut </label> <input type="text" name=""> </p>
    
    <!-- si la personne a ajouter est un étudiant -->
    
    <p><label> Photo </label> <input type="text" name="photo"> </p>
    <p><label> Date de naissance </label> <input type="text" name="birthDay"> </p>
    
    <p> <input type="submit" name="envoyer" value="Ajouter personne"> </p>
</form>