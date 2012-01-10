<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "student") {
            if ($_SESSION["type"] == "teacher") {
                header('Location: tea-indexTeacher.htm');
            }
            else if ($_SESSION["type"] == "admin") {
                header('Location: adm-indexAdmin.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    
    require_once $show_absence_class;
    $show_absence = ShowAbsence::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_pupil_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Affichage des absences</caption>
                <tr bgcolor="#ff0000">
                <?php    
                    try {
                        $absences = $show_absence->getAbsence();
                        $header = $show_absence->getHeader();
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "</tr>";

                    foreach ($absences as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
        </td>
    </tr>
</table>