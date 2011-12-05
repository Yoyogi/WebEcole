<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $header = array("identifiant", "nom", "prenom", "status");
?>

<table border="1">
    <caption align="center">Gestion des personnes</caption>
    <tr bgcolor="#ff0000">
    <?php
        foreach ($header as $i => $value) {
            ?><th rowspan="2"><?php echo $array[$i]; ?></th><?php
        }
        ?><th rowspan="2">Actions</th><?php
    ?>
    </tr>
    
</table>
