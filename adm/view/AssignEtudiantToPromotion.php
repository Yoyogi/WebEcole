<?php
    require_once $assign_etudianttopromotion_class;
    $assign_student_to_promotion = AssignEtudiantToPromotion::getInstance();
    $students = $assign_student_to_promotion->getStudent();
    $promotions = $assign_student_to_promotion->getPromotion();

    if ($isValided != null) {
            echo ">";
        if ($student != null && $promotion != null) {
            echo "Matiere ajoutee";
        } else {
            echo $isValided;
            echo "Veillez a remplir tous les champs correctement";
        }
    }
?>

<form method="POST" action="assignEtudiantToPromotion.htm">
    <input type="hidden" name="isValided" value="valided" />
    
    <select name="student" id="student">
        <?php
        foreach ($students as $student) {
            echo "<option value=\"" . $student->nom . " " . $student->prenom . "\">" . $student->nom . " " . $student->prenom . "</option>";
        }
        ?>
    </select>

    <select name="promotion" id="promotion">
        <?php
        foreach ($promotions as $promotion) {
            echo "<option value=\"" . $promotion->libelle . "\">" . $promotion->libelle . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="assign" value="Assign" />
</form>
