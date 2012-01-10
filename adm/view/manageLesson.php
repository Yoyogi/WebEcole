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
    
    require_once $manage_lesson_class;
    $manage_lesson = ManageLesson::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des cours</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_id)) {
                        $manage_lesson->deleteLesson($v_id);
                    }

                    $lessons = $manage_lesson->getLesson();
                    $header = $manage_lesson->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "<td></td>";
                    echo "</tr>";

                    foreach ($lessons as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='adm-modifyLesson-" . $row['id'] . ".htm'>Modifier</a>  <a href='adm-manageLesson-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="adm-addLesson.htm">Ajouter une Lesson</a>
        </td>
    </tr>
</table>