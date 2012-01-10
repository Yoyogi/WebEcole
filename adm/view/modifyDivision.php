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
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <p class="accueil_msg">
                Bienvenue sur votre intranet !<br><br>
                Vous pouvez accéder aux différentes fonctions de gestion grâce au menu sur la gauche.<br><br>
                Bonne navigation !
            </p>
        </td>
    </tr>
</table>
