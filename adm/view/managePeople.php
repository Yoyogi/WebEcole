<?php
    require_once $manage_people_class;
    $manage_people = ManagePeople::getInstance();
?>

<table border="1">
    <caption align="center">Gestion des personnes</caption>
    <tr bgcolor="#ff0000">
    <?php
        if (isset($v_action)) {
            if ($v_action == ManagePeople::$DELETE) {
                $manage_people->deletePeople($v_type, $v_id);
            }
            else if ($v_action == ManagePeople::$UPDATE) {
                
            }
        }
    
        $people = $manage_people->getPeople();
        $header = $manage_people->getHeader();
       
        echo "<tr>";
        foreach ($header as $id => $value)
        {
            echo "<td>" . $value . "</td>";   
        } 
        echo "<td>Controles</td>";
        echo "</tr>";
        
        foreach ($people as $key => $row)
        {
            echo "<tr>";
            foreach($row as $cell)
            {
                echo "<td>" . $cell . "</td>";
            }
            echo "<td><a href=''>Modifier</a>  <a href='managePeople-" . ManagePeople::$DELETE . "-" . $row['id'] . "-" . $manage_people->getStatus($row['status']) . ".htm'>Supprimer</a></td>";
            echo "</tr>";
        } 
    ?>
    </tr>
    
</table>
<a href="">Ajouter une personne</a>
