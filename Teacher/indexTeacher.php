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
?>
<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <p class="accueil_msg">
                Bienvenue sur votre intranet !<br><br>
                Vous pouvez accéder aux cours qui vous sont affectés, gérer vos exercices, signalez une absence, et consulter la liste des élèves.<br><br>
                Bonne navigation !
            </p>
        </td>
    </tr>
</table>