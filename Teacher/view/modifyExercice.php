<?php

    require_once $modify_exercice_class;
    require_once $coursclass_file;
    
    try {
        $modify_exercice = ModifyExercice::getInstance();
        $exercice = $modify_exercice->getExerciceById($v_id);
        $lessons = $modify_exercice->getLessons();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
    
    if ($isValided != null) {
        if ($libelle != null) {
            try {
                $modify_exercice->updateExercice($v_id, $libelle, $lesson);
                header('Location: tea-manageExercice.htm');
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
            <?php include $menu_teacher_file; ?>
        </td>
        <td class="content_td">
            <p class="subtitle">Modifier un exercice</p>
            <form method="POST" action="tea-modifyExercice-<?php echo $v_id; ?>.htm">
                <input type="hidden" name="isValided" value="valided" />
                
                <!-- combobox promotion -->
                Cours : <select name="lesson" id="lesson">
                <?php

                    
                    foreach ($lessons as $key => $row)
                    {
                        
                        echo "<option value=\"" . $row["id_cours"] . "\"";
                        if ($row["id_cours"] == $exercice->id_cours) {
                            echo " selected='selected' ";
                        }
                        echo "\>";
                        
                            echo " " . $row["date_cours"] . " - " . $row["matiere"] . " : " . $row["descript"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                                
                <p><label> Libelle : </label> <input type="text" name="libelle" value="<?php echo $exercice->libelle; ?>"> </p>
                
                <input type="submit" name="addExercice" value="Modifier l'exercice" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='tea-manageExercice.htm';" />
            </form>
        </td>
    </tr>
</table>