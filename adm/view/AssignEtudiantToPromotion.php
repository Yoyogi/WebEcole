<?php
    require_once $assign_etudianttopromotion_class;
    $assign_student_to_promotion = AssignEtudiantToPromotion::getInstance();
    $students = $assign_student_to_promotion->getStudent();
    $promotions = $assign_student_to_promotion->getPromotion();

    if ($isValided != null) {
        if ($student != null && $promotion != null) {
            $assign_student_to_promotion->assign($student, $promotion);
            echo "Etudiant assigné à une promotion.";
        } 
    }
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <form method="POST" action="adm-assignEtudiantToPromotion.htm">
                <input type="hidden" name="isValided" value="valided" />

                <select name="student" id="student">
                    <?php
                    foreach ($students as $student) {
                        echo "<option value=\"" . $student->id_etudiant . "\">" . $student->nom . " " . $student->prenom . "</option>";
                    }
                    ?>
                </select>

                <select name="promotion" id="promotion">
                    <?php
                    foreach ($promotions as $promotion) {
                        echo "<option value=\"" . $promotion->id_promo . "\">" . $promotion->libelle . "</option>";
                    }
                    ?>
                </select>

                <input type="submit" name="assign" value="Assign" />
            </form>
        </td>
    </tr>
</table>
