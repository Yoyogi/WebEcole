<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $manage_people = ManagePeople::getInstance();
    
?>

<table border="1">
    <caption align="center">Gestion des personnes</caption>
    <tr bgcolor="#ff0000">
    <?php
        $people = $manage_people->getPeople();
        $header = $manage_people->getHeader();
        foreach ($people as $value) {
            ?><th rowspan="2" width="50"><?php echo $id ?></th><?php
        }
        ?><th rowspan="2">Actions</th><?php
    ?>
    </tr>
    
</table>
