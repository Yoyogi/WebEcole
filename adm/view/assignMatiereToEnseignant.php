<?php
    require_once $assign_matieretoenseignant_class;
    $assign_matiere_to_enseignant = AssignMatiereToEnseignant::getInstance();
    $teachers = $assign_matiere_to_enseignant->getTeacher();
    $subjects = $assign_matiere_to_enseignant->getSubject();

    if ($isValided != null) {
            echo ">";
        if ($teachers != null && $subjects != null) {
            echo "Matiere ajoutee";
        } else {
            echo $isValided;
            echo "Veillez a remplir tous les champs correctement";
        }
    }
?>

<form method="POST" action="assignMatiereToEnseignant.htm">
    <input type="hidden" name="isValided" value="valided" />
    
    <select name="teacher" id="teacher">
        <?php
        foreach ($teachers as $teacher) {
            echo "<option value=\"" . $teachers->nom . " " . $teachers->prenom . "\">" . $teachers->nom . " " . $teachers->prenom . "</option>";
        }
        ?>
    </select>

    <select name="subject" id="subject">
        <?php
        foreach ($subjects as $subject) {
            echo "<option value=\"" . $subjects->libelle . "\">" . $subjects->libelle . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="assign" value="Assign" />
</form>