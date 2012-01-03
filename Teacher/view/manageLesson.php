<?php
    require_once $manage_lesson_class;
    $manage_lesson = ManageLesson::getInstance();
?>

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
            echo "<td><a href='modifyLesson-" . $row['id'] . ".htm'>Modifier</a>  <a href='manageLesson-" . $row['id'] . ".htm'>Supprimer</a></td>";
            echo "</tr>";
        } 
    ?>
    </tr>
    
</table>
<a href="addLesson.htm">Ajouter une Lesson</a>