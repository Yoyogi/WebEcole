<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "teacher") {
            if ($_SESSION["type"] == "student") {
                header('Location: pup-indexPupil.htm');
            }
            else if ($_SESSION["type"] == "admin") {
                header('Location: adm-indexAdmin.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    
    require_once $manage_exercice_class;
    $manage_exercice = ManageExercice::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des exercices</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_id)) {
                        $manage_exercice->deleteExercice($v_id);
                    }

                    $exercices = $manage_exercice->getExercice();
                    $header = $manage_exercice->getHeader();

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<td>" . $value . "</td>";   
                    } 
                    echo "<td></td>";
                    echo "</tr>";

                    foreach ($exercices as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='tea-modifyExercice-" . $row['id'] . ".htm'>Modifier</a>  <a href='tea-manageExercice-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="tea-addExercice.htm">Ajouter une exercices</a>
        </td>
    </tr>
</table>