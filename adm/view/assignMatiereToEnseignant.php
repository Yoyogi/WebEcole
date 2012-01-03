<?php
    require_once $assign_matieretoenseignant_class;
    $assign_matiere_to_enseignant = AssignMatiereToEnseignant::getInstance();
    $teachers = $assign_matiere_to_enseignant->getTeacher();
    $subjects = $assign_matiere_to_enseignant->getSubject();

    if ($isValided != null) {
        if ($teachers != null && $subjects != null) {
            $assign_matiere_to_enseignant->assign($teachers, $subjects);
            echo "Matiere assignée à l'enseignant";
        }
    }
?>

<form method="POST" action="adm-assignMatiereToEnseignant.htm">
    <input type="hidden" name="isValided" value="valided" />
    
    <select name="teacher" id="teacher">
        <?php
        foreach ($teachers as $teacher) {
            echo "<option value=\"" . $teachers->id_enseignant . "\">" . $teachers->nom . " " . $teachers->prenom . "</option>";
        }
        ?>
    </select>

    <select name="subject" id="subject">
        <?php
        foreach ($subjects as $subject) {
            echo "<option value=\"" . $subjects->id_matiere . "\">" . $subjects->libelle . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="assign" value="Assign" />
</form>