<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form method="POST" action="addEleve.htm">
    <p><label> Identifiant </label> <input type=text name=identifiant> </p>
    <p><label> Libelle </label> <input type=text name=libelle> </p>
    <select name="Enseignant">
        <option value="oui">Oui</option>
    </select>
    
    <p> <input type="submit" name="envoyer" value="Ajouter matière"> </p>
</form>