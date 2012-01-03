<?php
    require_once $manage_absence_class;
    $manage_absence = ManageAbsence::getInstance();
?>

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
            echo "<td><a href='modifyAbsence-" . $row['id'] . ".htm'>Modifier</a>  <a href='manageAbsence-" . $row['id'] . ".htm'>Supprimer</a></td>";
            echo "</tr>";
        } 
    ?>
    </tr>
    
</table>
<a href="addAbsence.htm">Ajouter une Absence</a>