<?php
    require_once $manage_absence_class;
    $manage_absence = ManageAbsence::getInstance();
?>

<table border="1">
    <caption align="center">Gestion des absences</caption>
    <tr bgcolor="#ff0000">
    <?php    
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
            echo "</tr>";
        } 
    ?>
    </tr>
    
</table>