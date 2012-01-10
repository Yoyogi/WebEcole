<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "admin") {
            if ($_SESSION["type"] == "teacher") {
                header('Location: tea-indexTeacher.htm');
            }
            else if ($_SESSION["type"] == "student") {
                header('Location: pup-indexPupil.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
    
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
                        try {
                            $manage_subject->deletePeople($v_id);
                        }
                        catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    try {
                        $matiere = $manage_subject->getSubject();
                        $header = $manage_subject->getHeader();
                    }
                    catch (Exception $e) {
                        echo $e->getMessage();
                    }

                    echo "<tr>";
                    foreach ($header as $id => $value)
                    {
                        echo "<th>" . $value . "</th>";   
                    } 
                    echo "<th></th>";
                    echo "</tr>";

                    foreach ($matiere as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='adm-modifySubject-" . $row['id'] . ".htm'>Modifier</a>  <a href='adm-manageSubject-" . $row['id'] . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="adm-addSubject.htm">Ajouter une matieres</a>
        </td>
    </tr>
</table>