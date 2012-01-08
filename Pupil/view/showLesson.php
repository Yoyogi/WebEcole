<?php
    require_once $show_lesson_class;
    $show_lesson = ShowLesson::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_pupil_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Affichage des cours</caption>
                <tr bgcolor="#ff0000">
                <?php    
                    $lessons = $show_lesson->getLesson();
                    $header = $show_lesson->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
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