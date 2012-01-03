<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once $add_division_class;
$add_division = AddDivision::getInstance();

//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        $add_division->addDivisionFunc($libelle);
        echo "Matiere ajoutee";
    } else {

        echo $isValided;
        echo "Veillez a remplir tous les champs correctement";
    }
}
?>


<form method="POST" action="addDivision.htm">
    <input type="hidden" name="isValided" value="valided">
    <p><label> Libelle </label> <input type=text name=libelle> </p>

    <p> <input type="submit" name="envoyer" value="Se connecter"> </p>
</form>