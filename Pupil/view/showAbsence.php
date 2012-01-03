<?php
    require_once $show_absence_class;
    $show_absence = ShowAbsence::getInstance();
?>

<table border="1">
    <caption align="center">Affichage des absences</caption>
    <tr bgcolor="#ff0000">
    <?php    
        $absences = $show_absence->getAbsence();
        $header = $show_absence->getHeader();
       
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