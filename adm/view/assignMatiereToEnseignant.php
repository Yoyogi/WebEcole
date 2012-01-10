<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "admin") {
            if ($_SESSION["type"] == "teacher") {
                header('Location: tea-indexTeacher.htm');
            }
            else if ($_SESSION["type"] == "student") {
                header('Location: pup-indexPupil.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    
    require_once $assign_matieretoenseignant_class;
    $assign_matiere_to_enseignant = AssignMatiereToEnseignant::getInstance();
    
    try {
        $teachers = $assign_matiere_to_enseignant->getTeacher();
        $subjects = $assign_matiere_to_enseignant->getSubject();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($isValided != null) {
        if ($teachers != null && $subjects != null) {
            try {
                $assign_matiere_to_enseignant->assign($teachers, $subjects);
                echo "Matiere assignée à l'enseignant";
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
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
        </td>
    </tr>
</table>