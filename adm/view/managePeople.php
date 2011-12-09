<?php
    require_once $manage_people_class;
    $manage_people = ManagePeople::getInstance();
?>

<table border="1">
    <caption align="center">Gestion des personnes</caption>
    <tr bgcolor="#ff0000">
    <?php
        $people = $manage_people->getPeople();
        $header = $manage_people->getHeader();
        
        foreach ($people as $key => $row)
        {
            foreach($row as $cell)
            {
                
            }
        } 
    ?>
    </tr>
    
</table>
