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


require_once $add_subject_class;
$add_subject = AddSubject::getInstance();

//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        try {
            $add_subject->addSubjectFunc($libelle);
            header('Location: adm-manageSubject.htm');
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
            <p class="subtitle">Ajout d'une matière</p>
            <form method="POST" action="adm-addSubject.htm">
                <input type="hidden" name="isValided" value="valided">
                <p><label> Libellé </label> <input type=text name=libelle> </p>
                <input type="submit" name="envoyer" value="Ajouter la matiere" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='adm-manageSubject.htm';" />
            </form>
        </td>
    </tr>
</table>