<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    $header = array('Identifiant' => 'identifiant', 'Nom' => 'nom', 'Prenom' => 'prenom', 'Status' => 'status');
?>

<table border="1">
    <caption align="center">Gestion des personnes</caption>
    <tr bgcolor="#ff0000">
    <?php
        foreach ($header as $id => $value) {
            ?><th rowspan="2" width="50"><?php echo $id ?></th><?php
        }
        ?><th rowspan="2">Actions</th><?php
    ?>
    </tr>
    
</table>
