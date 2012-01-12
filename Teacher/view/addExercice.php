<?php

    require_once $add_exercice_class;
    require_once $coursclass_file;
    
    try {
        $add_exercice = AddExercice::getInstance();
        $lessons = $add_exercice->getLessons();
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
    
    if ($isValided != null) {
        if ($libelle != null) {
            try {
                $LessonObj = $add_exercice->getLessonByIdFunc($lesson);
                $add_exercice->addExerciceFunc($libelle, $LessonObj);
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
            <p class="subtitle">Ajout d'un exercice</p>
            <form method="POST" action="tea-addExercice.htm">
                <input type="hidden" name="isValided" value="valided" />

                <!-- combobox promotion -->
                Cours : <select name="lesson" id="lesson">
                <?php

                    
                    foreach ($lessons as $key => $row)
                    {
                        
                        echo "<option value=\"" . $row["id_cours"] . "\">";
                        
                            echo " " . $row["date_cours"] . " - " . $row["matiere"] . " : " . $row["descript"] . " ";
                        
                         echo "</option>";
                    } 
                ?>
                </select>
                                
                <p><label> Libelle : </label> <input type=text name=libelle> </p>
                
                <input type="submit" name="addExercice" value="Créer le cours" />
                <input type="button" name="back" value="Retour" onclick="window.location.href='tea-manageExercice.htm';" />
            </form>
        </td>
    </tr>
</table>