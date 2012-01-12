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
require_once $add_division_class;
$add_division = AddDivision::getInstance();

//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        try {
            $add_division->addDivisionFunc($libelle);
            header('Location: adm-manageDivision.htm');
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {

        echo $isValided;
        echo "Veillez a remplir tous les champs correctement";
    }
}
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <p class="subtitle">Ajout d'une promotion</p>
            <form method="POST" action="adm-addDivision.htm">
                <input type="hidden" name="isValided" value="valided">
                <p><label> Libellé </label> <input type=text name=libelle> </p>

                <input type="submit" name="envoyer" value="Ajout de la promotion" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='adm-manageDivision.htm';" />
            </form>
        </td>
    </tr>
</table>