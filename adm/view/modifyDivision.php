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
require_once $modify_division_class;
$modify_division = ModifyDivision::getInstance();
$division = $modify_division->getDivisionById($v_id);


//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        try {
            $modify_division->modifyDivisionFunc($libelle);
        echo "Matiere ajoutee";
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
            <form method="POST" action="adm-addDivision.htm">
                <input type="hidden" name="isValided" value="valided">
                <p><label> Libelle </label> <input type=text name=libelle value="<?php echo $division->libelle; ?>"> </p>

                <p> <input type="submit" name="envoyer" value="Se connecter"> </p>
            </form>
        </td>
    </tr>
</table>