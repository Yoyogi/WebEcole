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
    
    require_once $manage_people_class;
    $manage_people = ManagePeople::getInstance();
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <table border="1">
                <caption align="center">Gestion des personnes</caption>
                <tr bgcolor="#ff0000">
                <?php
                    if (isset($v_type) && isset($v_id)) {
                        try {
                            $manage_people->deletePeople($v_type, $v_id);
                        }
                        catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }

                    try {
                        $people = $manage_people->getPeople();
                        $header = $manage_people->getHeader();
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

                    foreach ($people as $key => $row)
                    {
                        echo "<tr>";
                        foreach($row as $cell)
                        {
                            echo "<td>" . $cell . "</td>";
                        }
                        echo "<td><a href='adm-modifyPeople-" . $row['id'] . "-" . $manage_people->getStatus($row['status']) . ".htm'>Modifier</a>  <a href='adm-managePeople-" . $row['id'] . "-" . $manage_people->getStatus($row['status']) . ".htm'>Supprimer</a></td>";
                        echo "</tr>";
                    } 
                ?>
                </tr>

            </table>
            <a href="adm-addPeople.htm">Ajouter une personne</a>
        </td>
    </tr>
</table>
