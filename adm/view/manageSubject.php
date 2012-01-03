<?php
    require_once $manage_subject_class;
    $manage_subject = ManageSubject::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des matieres</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_type) && isset($v_id)) {
                        $manage_subject->deletePeople($v_id);
                    }

                    $matiere = $manage_subject->getSubject();
                    $header = $manage_subject->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "<td></td>";
                    echo "</tr>";

                    foreach ($matiere as $key => $row)
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
            <a href="adm-addSubject.htm">Ajouter une matieres</a>
        </td>
    </tr>
</table>