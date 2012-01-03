<?php
    require_once $manage_absence_class;
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
                        $manage_absence->deleteAbsence($v_id);
                    }

                    $absences = $manage_absence->getAbsence();
                    $header = $manage_absence->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "<td></td>";
                    echo "</tr>";

                    foreach ($absences as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='tea-modifyAbsence-" . $row['id'] . ".htm'>Modifier</a>  <a href='tea-manageAbsence-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="tea-addAbsence.htm">Ajouter une Absence</a>
        </td>
    </tr>
</table>