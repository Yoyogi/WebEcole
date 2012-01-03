<?php
    require_once $assign_etudianttopromotion_class;
    $assign_student_to_promotion = AssignEtudiantToPromotion::getInstance();
?>

<select name="student" id="student">
    <?php
    $students = $assign_student_to_promotion->getStudent();
    $promotions = $assign_student_to_promotion->getPromotion();

    foreach ($students as $student) {
        echo "<option>" . $student->nom . " " . $student->prenom . "</option>";
    }
    ?>
</select>
