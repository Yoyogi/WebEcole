<?php
    require_once $show_student_class;
    $show_student = ShowStudent::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Affichage des eleves</caption>
                <tr bgcolor="#ff0000">
                <?php    
                    $students = $show_student->getStudent();
                    $header = $show_student->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "</tr>";

                    foreach ($students as $key => $row)
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