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

require_once $forward_absence_class;

$business = ForwardAbsence::getInstance();
$absence = $business->getAbsenceById($idAbs);

?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <p>Un mail a été envoyé à l'élève <?php echo $absence->etudiant->nom." ".$absence->etudiant->prenom; ?> pour son absence.</p>
            <input type="button" onclick='window.location.href="adm-indexAdmin.htm"' value="Retour &agrave; la page de connexion"/>
        </td>
    </tr>
</table>