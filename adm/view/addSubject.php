<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


require_once $add_subject_class;
$add_subject = AddSubject::getInstance();

//echo "fihefrviuerncvi      :      " . $libelle;


if ($isValided != null) {
    if ($libelle != null) {
        $add_subject->addSubjectFunc($libelle);
        echo "Matiere ajoutee";
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
            <form method="POST" action="adm-addSubject.htm">
                <input type="hidden" name="isValided" value="valided">
                <p><label> Libelle </label> <input type=text name=libelle> </p>
                <p> <input type="submit" name="envoyer" value="Ajouter matiere"> </p>
            </form>
        </td>
    </tr>
</table>