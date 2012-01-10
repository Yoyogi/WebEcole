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
    
    require_once $manage_lesson_class_teacher;
    $manage_lesson = ManageLesson::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des cours</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_id)) {
                        try {
                            $manage_lesson->deleteLesson($v_id);
                        }
                        catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    try {
                        $lessons = $manage_lesson->getLesson();
                        $header = $manage_lesson->getHeader();
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<th>" . $value . "</th>";   
                    } 
                    echo "</tr>";

                    foreach ($lessons as $key => $row)
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