<?php
    require_once $manage_division_class;
    $manage_division = ManageDivision::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des divisions</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_id)) {
                        $manage_absence->deleteDivision($v_id);
                    }

                    $promotions = $manage_division->getDivision();
                    $header = $manage_division->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "<td></td>";
                    echo "</tr>";

                    foreach ($promotions as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='adm-modifyAbsence-" . $row['id'] . ".htm'>Modifier</a>  <a href='adm-manageAbsence-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="adm-addDivision.htm">Ajouter une Division</a>
        </td>
    </tr>
</table>
