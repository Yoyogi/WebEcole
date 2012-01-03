<?php
    require_once $assign_student_to_promotion_class;
    $assign_student_to_promotion = AssignEtudiantToPromotion::getInstance();
?>

<select name="student" id="student">
    <?php while ($row=mysql_fetch_array($result))
    {
    echo"<option>$row[0]</option>";
    }?>
</select>
