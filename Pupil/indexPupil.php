<?php
    session_start();
    if(isset($_SESSION["type"])) {
        if (!$_SESSION["type"] == "student") {
            if ($_SESSION["type"] == "teacher") {
                header('Location: tea-indexTeacher.htm');
            }
            else if ($_SESSION["type"] == "admin") {
                header('Location: adm-indexAdmin.htm');
            }
        }
    }
    else {
        header('Location: accueil.htm');
    }
?>
<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_pupil_file; ?>
        </td>
        <td class="content_td">
            <p class="accueil_msg">
                Bienvenue sur votre intranet !<br><br>
                Vous pouvez accéder à la liste des cours auxquels vous participez, ainsi que les absences qui ont été reportées.<br><br>
                Bonne navigation !
            </p>
        </td>
    </tr>
</table>