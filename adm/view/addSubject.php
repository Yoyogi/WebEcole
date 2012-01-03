<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once $add_subject_class;
$add_subject = AddSubject::getInstance();

//echo "fihefrviuerncvi      :      " . $libelle;

if (isset($isValided)){
    if(isset($libelle)){
        $add_subject->addSubjectFunc($libelle);
        echo "Matiere ajoutee";
    }
}else{
    echo "Veillez a remplir tous les champs correctement";
}

?>

<form method="POST" action="addSubject.htm">
    <input type="hidden" name="isValided">
    <p><label> Libelle </label> <input type=text name=libelle> </p>
    <p> <input type="submit" name="envoyer" value="Ajouter matière"> </p>
</form>