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


require_once $modify_subject_class;
$modify_subject = ModifySubject::getInstance();
$subject = $modify_subject->getSubjectByID($v_id);

//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        try {
            $modify_subject->updateSubject($v_id, $libelle);
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
            <form method="POST" action="adm-modifySubject-<?php echo $v_id; ?>.htm">
                <input type="hidden" name="isValided" value="valided">
                <p><label> Libelle </label> <input type=text name=libelle value="<?php echo $subject->libelle; ?>"> </p>
                <p> <input type="submit" name="envoyer" value="Modifier matiere"> </p>
            </form>
        </td>
    </tr>
</table>