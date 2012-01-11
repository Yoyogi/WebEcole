<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "teacher") {
            if ($_SESSION["type"] == "student") {
                header('Location: pup-indexPupil.htm');
            }
            else if ($_SESSION["type"] == "admin") {
                header('Location: adm-indexAdmin.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    
    require_once $manage_absence_class_teacher;
    $manage_absence = ManageAbsence::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des absences</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_id)) {
                        try {
                            $manage_absence->deleteAbsence($v_id);
                        }
                        catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    try {
                        $absences = $manage_absence->getAbsence();
                        $header = $manage_absence->getHeader();
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<th>" . $value . "</th>";   
                    } 
                    echo "<th></th>";
                    echo "</tr>";

                    foreach ($absences as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='tea-manageAbsence-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="tea-addAbsence.htm">Ajouter une Absence</a>
        </td>
    </tr>
</table>