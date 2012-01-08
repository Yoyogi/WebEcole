<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<table class="sub_body">
    <tr>
        <td class="menu">
            <?php include $menu_adm_file; ?>
        </td>
        <td class="content_td">
            <form method="POST" action="adm-addEleve.htm">


                <select name="Promotion">
                    <option value="oui">Oui</option>
                </select>
                <select name="Matiere">
                    <option value="oui">Oui</option>
                </select>
                <select name="Enseignant">
                    <option value="oui">Oui</option>
                </select>


                <p> <input type="submit" name="envoyer" value="Ajouter cours"> </p>
            </form>
        </td>
    </tr>
</table>